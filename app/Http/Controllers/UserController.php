<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }

    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:SALE,ADMIN',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return back();
    }
    public function salesList()
    {
        $sales = User::where('role', 'SALE')
                    ->orderBy('name')
                    ->get();

        return view('sales.index', compact('sales'));
    }

}