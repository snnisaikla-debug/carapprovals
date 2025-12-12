<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\UserController;

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

    // ดาวน์โหลด PDF
    Route::get('/approvals/{groupId}/pdf', [ApprovalController::class, 'downloadPdf'])
        ->name('approvals.pdf');

    //เปลี่ยนรูป + เปลี่ยนรหัส/อีเมล “ยืนยันผ่านเมล
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::post('/account/photo', [AccountController::class, 'updatePhoto'])->name('account.photo');

    Route::post('/account/change-email', [AccountController::class, 'requestChangeEmail'])->name('account.changeEmail');
    Route::post('/account/change-password', [AccountController::class, 'requestChangePassword'])->name('account.changePassword');

    Route::get('/account/confirm/{token}', [AccountController::class, 'confirm'])->name('account.confirm');

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
/*
    |--------------------------------------------------------------------------
    | เพิ่ม/ลบ/แก้ไข sale
    |--------------------------------------------------------------------------
    */
    Route::get('/approvals/{groupId}/edit', [ApprovalController::class, 'edit'])->name('approvals.edit');
    Route::put('/approvals/{groupId}', [ApprovalController::class, 'update'])->name('approvals.update');
    Route::delete('/approvals/{groupId}', [ApprovalController::class, 'destroy'])->name('approvals.destroy');
