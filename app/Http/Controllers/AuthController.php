<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function showRegister()
        {
            return view('auth.register');
        }

    public function register(Request $request)
        {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => [
            'required',
            'email',
            'regex:/@ypb\.co\.th$/i',  // ต้องเป็น @ypb.co.th เท่านั้น
            'unique:users,email',
        ],
            'password' => 'required|string|min:6|confirmed',
    ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'sale',  // ทุกคนที่สมัครเป็น sale
        ]);

        Auth::login($user);

        return redirect()->route('approvals.index');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'email'    => 'required|string',
        'password' => 'required|string',
    ]);

    // ถ้า user พิมพ์แค่ชื่อ เช่น "worawut" ให้เติม @ypb.co.th ให้เอง
    if (strpos($credentials['email'], '@') === false) {
        $credentials['email'] .= '@ypb.co.th';
    }

    $remember = $request->boolean('remember'); // จำรหัสผ่าน

    if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']], $remember)) {
        $request->session()->regenerate();
        return redirect()->route('approvals.index');
    }

    return back()->withErrors([
        'email' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
    ])->onlyInput('email');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
    public function showResetPassword()
    {
        return view('auth.reset');
    }

    public function resetPassword(Request $request)
    {
        $data = $request->validate([
            'email'    => ['required','email','regex:/@ypb\.co\.th$/i'],
            'password' => 'required|string|min:6|confirmed',
        ]);

        // หา user ตามอีเมล
        $user = User::where('email', $data['email'])->first();

        if (!$user) {
            return back()->withErrors(['email' => 'ไม่พบผู้ใช้งานในระบบ']);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return redirect()->route('login')->with('status', 'รีเซ็ตรหัสผ่านสำเร็จแล้ว กรุณาเข้าสู่ระบบใหม่');
    }
    public function showAccount()
    {
        $user = auth()->user();
        return view('account.show', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'avatar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->name = $data['name'];
        $user->save();

        return back()->with('status_profile', 'บันทึกข้อมูลบัญชีเรียบร้อยแล้ว');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'current_password'      => 'required',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
        }

        $user->password = Hash::make($data['password']);
        $user->save();

        return back()->with('status_password', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
    }

    public function destroyAccount(Request $request)
    {
        $user = auth()->user();

        // ป้องกันลบโดยไม่ได้ตั้งใจ
        $request->validate([
            'confirm' => 'required|in:DELETE',
        ]);

        auth()->logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'ลบบัญชีแล้ว');
    }
}
