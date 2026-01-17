<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmPasswordController extends Controller
{
    public function show()
        {
            return view('auth.confirm-delete');
        }

    public function confirm(Request $request)
        {
            $request->validate([
                'confirm_text' => ['required'],
            ]);

            if ($request->confirm_text !== 'DELETE') {
                return back()->withErrors([
                    'confirm_text' => 'กรุณาพิมพ์คำว่า DELETE ให้ถูกต้อง',
                ]);
            }

            $request->session()->passwordConfirmed();

            return redirect()->intended();

        }
}