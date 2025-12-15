<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function show()
    {
        return view('account.show', ['user' => Auth::user()]);
    }

    public function edit()
    {
        return view('account.edit', ['user' => Auth::user()]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required','string','max:255'],
            // ถ้าจะบังคับ @ypb.co.th:
            // 'email' => ['required','email','ends_with:@ypb.co.th','unique:users,email,'.$user->id],
            'email' => ['required','email','unique:users,email,'.$user->id],
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('account.show')->with('success','อัปเดตข้อมูลเรียบร้อย');
    }

    public function editPassword()
    {
        return view('account.password', ['user' => Auth::user()]);
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required'],
            'new_password' => ['required','min:8','confirmed'],
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านเดิมไม่ถูกต้อง']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('account.show')->with('success','เปลี่ยนรหัสผ่านเรียบร้อย');
    }
}
