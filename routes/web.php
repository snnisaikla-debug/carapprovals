<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// หน้าแรก -> เด้งไป login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login / Register
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Reset Password
Route::get('/password/reset', [AuthController::class, 'showResetPassword'])->name('password.request');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');


/*
|--------------------------------------------------------------------------
| Protected Routes (ต้อง login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Approvals (Sales/Admin/Head)
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::get('/approvals/create', [ApprovalController::class, 'create'])->name('approvals.create');
    Route::post('/approvals', [ApprovalController::class, 'store'])->name('approvals.store');
    Route::get('/approvals/{groupId}', [ApprovalController::class, 'showGroup'])->name('approvals.show');
 
    Route::get('/approvals/{groupId}/edit', [ApprovalController::class, 'edit'])->name('approvals.edit');
    Route::put('/approvals/{groupId}', [ApprovalController::class, 'update'])->name('approvals.update');
    Route::delete('/approvals/{groupId}', [ApprovalController::class, 'destroy'])->name('approvals.destroy');

    // ดาวน์โหลด PDF
    // Route::get('/approvals/{groupId}/pdf', [ApprovalController::class, 'downloadPdf'])
        // ->name('approvals.pdf');


Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');

    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/edit', [AccountController::class, 'update'])->name('account.update');

    Route::get('/account/password', [AccountController::class, 'editPassword'])->name('account.password.edit');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');

    // ✅ Avatar
    Route::get('/account/avatar', [AccountController::class, 'editAvatar'])->name('account.avatar.edit');
    Route::post('/account/avatar', [AccountController::class, 'updateAvatar'])->name('account.avatar.update');

    // ✅ Soft delete
    Route::post('/account/delete', [AccountController::class, 'destroy'])->name('account.delete');
});

    // menu navbar

Route::middleware('auth')->group(function () {
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');

    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/edit', [AccountController::class, 'update'])->name('account.update');

    Route::get('/account/password', [AccountController::class, 'editPassword'])->name('account.password.edit');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
});


    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {

        // อนุมัติรอบแรก
        Route::post('/admin/approvals/{groupId}', [ApprovalController::class, 'adminAction'])
            ->name('approvals.adminAction');

        // จัดการบัญชี (Admin)
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
    });

    /*
    |--------------------------------------------------------------------------
    | Head Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('head')->group(function () {

        // รายชื่อ Sales
        Route::get('/sales', [UserController::class, 'salesList'])->name('sales.list');

        // อนุมัติรอบสุดท้าย (HEAD)
        Route::post('/head/approvals/{groupId}', [ApprovalController::class, 'headAction'])
            ->name('approvals.headAction');
    });

    /*
    |--------------------------------------------------------------------------
    | My Account
    |--------------------------------------------------------------------------
    */
    Route::get('/account', [AuthController::class, 'showAccount'])->name('account.show');
    Route::post('/account/profile', [AuthController::class, 'updateProfile'])->name('account.updateProfile');
    Route::post('/account/password', [AuthController::class, 'updatePassword'])->name('account.updatePassword');
    Route::delete('/account', [AuthController::class, 'destroyAccount'])->name('account.destroy');
    });