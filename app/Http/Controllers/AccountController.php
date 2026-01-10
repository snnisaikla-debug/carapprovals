<?php

namespace App\Http\Controllers;

use App\Mail\AccountActionMail;
use App\Models\AccountAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AccountController extends Controller
{
    public function show()
        {
            return view('account.show', ['user' => Auth::user()]);
        }

    public function updateProfile(Request $request)
        {
            $user = Auth::user();

            // 1. Validation ข้อมูลที่ส่งมา
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8|confirmed', // ใส่รหัสผ่านใหม่เฉพาะเมื่อต้องการเปลี่ยน
            ]);

            // 2. อัปเดตข้อมูลพื้นฐาน
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            // 3. ถ้ามีการกรอกรหัสผ่านใหม่ ให้ทำการ Hash ก่อนบันทึก
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return back()->with('success', 'อัปเดตข้อมูลเรียบร้อยแล้ว');
        }

    public function updatePhoto(Request $request)
        {
            $request->validate([
                'photo' => 'required|image|max:2048'
            ]);

            $path = $request->file('photo')->store('profile-photos', 'public');

            $user = Auth::user();
            $user->profile_photo_path = $path;
            $user->save();

            return back()->with('success', 'อัปเดตรูปโปรไฟล์เรียบร้อย');
        }

    public function requestChangeEmail(Request $request)
        {
            $request->validate([
                'new_email' => ['required','email','ends_with:@ypb.co.th','unique:users,email']
            ]);

            $action = AccountAction::create([
                'user_id' => Auth::id(),
                'type' => 'change_email',
                'token' => Str::random(64),
                'payload' => ['new_email' => $request->new_email],
                'expires_at' => now()->addMinutes(30),
            ]);

            Mail::to(Auth::user()->email)->send(new AccountActionMail($action));

            return back()->with('success', 'ส่งอีเมลยืนยันไปที่อีเมลปัจจุบันแล้ว (ยืนยันภายใน 30 นาที)');
        }

    public function requestChangePassword(Request $request)
        {
            $request->validate([
                'new_password' => ['required','min:8','confirmed'],
            ]);

            $action = AccountAction::create([
                'user_id' => Auth::id(),
                'type' => 'change_password',
                'token' => Str::random(64),
                'payload' => ['new_password_hash' => Hash::make($request->new_password)],
                'expires_at' => now()->addMinutes(30),
            ]);

            Mail::to(Auth::user()->email)->send(new AccountActionMail($action));

            return back()->with('success', 'ส่งอีเมลยืนยันแล้ว (ยืนยันภายใน 30 นาที)');
        }

    public function confirm($token)
        {
            $action = AccountAction::where('token', $token)->firstOrFail();

            if ($action->confirmed_at) {
                return redirect()->route('account.show')->with('error', 'ลิงก์นี้ถูกยืนยันไปแล้ว');
            }

            if (now()->greaterThan($action->expires_at)) {
                return redirect()->route('account.show')->with('error', 'ลิงก์หมดอายุแล้ว');
            }

            // ✅ ต้องเป็นเจ้าของบัญชีเท่านั้น
            if ($action->user_id !== Auth::id()) {
                abort(403);
            }

            $user = Auth::user();

            if ($action->type === 'change_email') {
                $user->email = $action->payload['new_email'];
                $user->save();
            }

            if ($action->type === 'change_password') {
                $user->password = $action->payload['new_password_hash'];
                $user->save();
            }

            $action->confirmed_at = now();
            $action->save();

            return redirect()->route('account.show')->with('success', 'ยืนยันเรียบร้อย');
        }
    public function editAvatar()
        {
            return view('account.avatar', ['user' => Auth::user()]);
        }

    public function updateAvatar(Request $request)
        {
            $user = Auth::user();

            // รับรูปที่ crop แล้วเป็น base64
            $request->validate([
                'avatar_data' => ['required', 'string'],
            ]);

            $data = $request->avatar_data;

            // รูปแบบ: data:image/png;base64,xxxxx
            if (!preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
                return back()->withErrors(['avatar_data' => 'รูปภาพไม่ถูกต้อง']);
            }

            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // png/jpg/jpeg

            if (!in_array($type, ['png','jpg','jpeg','webp'])) {
                return back()->withErrors(['avatar_data' => 'รองรับเฉพาะ png/jpg/jpeg/webp']);
            }

            $data = base64_decode($data);
            if ($data === false) {
                return back()->withErrors(['avatar_data' => 'ถอดรหัสรูปภาพไม่ได้']);
            }

            // ลบรูปเก่า
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            $path = 'avatars/user_'.$user->id.'_'.time().'.'.$type;
            Storage::disk('public')->put($path, $data);

            $user->avatar_path = $path;
            $user->save();

            return redirect()->route('account.show')->with('success', 'อัปเดตรูปโปรไฟล์เรียบร้อย');
        }

    public function destroy(Request $request)
        {
            $user = Auth::user();
                if ($user) 
            {

            // บันทึกวันที่ลบลง DB (ถ้า Model มี SoftDeletes จะขึ้นวันที่อัตโนมัติ)
            $user->delete(); 

            // เพื่อความปลอดภัย ให้ยืนยันรหัสผ่านก่อนลบ
            $request->validate([
                'current_password' => ['required'],]);

            // สั่งออกจากระบบทันที
            Auth::logout();

            // ล้างข้อมูล Session เพื่อให้เด้งออกจากหน้าเว็บ
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect('/login')->with('success', 'ลบบัญชีเรียบร้อยแล้ว');
            }
        
            return redirect('/');
            }
            public function showChangePasswordForm()
        {
            return view('account.password'); // ต้องไปสร้างไฟล์ View นี้ในข้อ 3
        }
    // ฟอร์มรหัสผ่าน
    public function showSecurityForm()
        {
            return view('account.password');
        }

    // บันทึกรหัสผ่านใหม่
    public function updatePassword(Request $request)
        {
            // Validate ข้อมูล
            $request->validate([
                'current_password' => 'required|current_password',
                'new_password' => 'required|string|min:8|confirmed',
            ]);

            // อัปเดตรหัสผ่าน
            $user = Auth::user();
            $user->forceFill([
                'password' => Hash::make($request->new_password)
                ])->save();

            return back()->with('success', 'เปลี่ยนรหัสผ่านเรียบร้อยแล้ว');
        }
        // ฟังก์ชัน 2: ขอเปลี่ยนอีเมล (ส่งลิงก์ยืนยันไปที่อีเมลใหม่)
    public function requestEmailChange(Request $request)
        {
            $request->validate([
                'current_password_for_email' => 'required|current_password', // ยืนยันรหัสผ่านก่อนเปลี่ยนเมล
                'new_email' => 'required|email|unique:users,email',
            ]);

            $user = Auth::user();
            $newEmail = $request->new_email;

            // สร้างลิงก์ยืนยันแบบชั่วคราว (หมดอายุใน 30 นาที)
            $verifyUrl = URL::temporarySignedRoute(
                'account.email.verify',
                now()->addMinutes(30),
                ['user_id' => $user->id, 'new_email' => $newEmail]
            );

            // ส่งอีเมล (แบบบ้านๆ ใช้ Raw Message เพื่อความรวดเร็ว)
            // ในโปรเจกต์จริงควรสร้าง Mailable Class สวยๆ
            Mail::raw("กรุณาคลิกลิงก์เพื่อยืนยันการเปลี่ยนอีเมลเป็น: $newEmail \n\n $verifyUrl", function ($message) use ($newEmail) {
                $message->to($newEmail)
                        ->subject('ยืนยันการเปลี่ยนอีเมล (Verify Email Change)');
            });

            return back()->with('success', 'ระบบได้ส่งลิงก์ยืนยันไปที่ ' . $newEmail . ' กรุณาตรวจสอบกล่องจดหมาย');
        }

    // ฟังก์ชัน 3: ยืนยันและเปลี่ยนอีเมลจริง
    public function verifyEmailChange(Request $request)
        {
            // ตรวจสอบลายเซ็นของลิงก์ (ป้องกันการปลอมแปลง)
            if (! $request->hasValidSignature()) {
                abort(403, 'ลิงก์ยืนยันไม่ถูกต้องหรือหมดอายุ');
            }

            $user = User::findOrFail($request->user_id);
            $user->email = $request->new_email;
            $user->email_verified_at = now(); // ถือว่ายืนยันแล้ว
            $user->save();

            return redirect()->route('account.security')->with('success', 'เปลี่ยนอีเมลสำเร็จแล้ว!');
        }
}