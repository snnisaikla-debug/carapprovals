<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// หน้าแรก
Route::get('/', fn () => redirect()->route('login'));

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Reset password
Route::get('/password/reset', [AuthController::class, 'showResetPassword'])->name('password.request');
Route::post('/password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    /*
    |--------------------------------------------------------------------------
    | Approvals
    |--------------------------------------------------------------------------
    */
    Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');
    Route::get('/approvals/create', [ApprovalController::class, 'create'])->name('approvals.create');
    Route::post('/approvals', [ApprovalController::class, 'store'])->name('approvals.store');

    // ✅ ดูเอกสาร (ใช้ groupId)
    Route::get('/approvals/{groupId}', [ApprovalController::class, 'showGroup'])
        ->name('approvals.show');

    // ✅ แก้ไข
    Route::get('/approvals/{groupId}/edit', [ApprovalController::class, 'edit'])
        ->name('approvals.edit');
    Route::post('/approvals/{groupId}/update', [ApprovalController::class, 'update'])
        ->name('approvals.update');

    // ✅ ลบทั้ง group
    Route::delete('/approvals/{groupId}', [ApprovalController::class, 'destroy'])
        ->name('approvals.destroy');

    // ✅ Export PDF (ใช้ approval id)
    Route::get('/approvals/{id}/pdf', [ApprovalController::class, 'exportPdf'])
        ->name('approvals.pdf');

    /*
    |--------------------------------------------------------------------------
    | Account
    |--------------------------------------------------------------------------
    */
    Route::get('/account', [AccountController::class, 'show'])->name('account.show');
    Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account/edit', [AccountController::class, 'update'])->name('account.update');

    Route::get('/account/password', [AccountController::class, 'editPassword'])->name('account.password.edit');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');

    Route::get('/account/avatar', [AccountController::class, 'editAvatar'])->name('account.avatar.edit');
    Route::post('/account/avatar', [AccountController::class, 'updateAvatar'])->name('account.avatar.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('admin')->group(function () {
    Route::post('/admin/approvals/{groupId}', [ApprovalController::class, 'adminAction'])
        ->name('approvals.adminAction');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

/*
|--------------------------------------------------------------------------
| HEAD
|--------------------------------------------------------------------------
*/
Route::middleware('head')->group(function () {
    Route::post('/head/approvals/{groupId}', [ApprovalController::class, 'headAction'])
        ->name('approvals.headAction');
});

/*
|--------------------------------------------------------------------------
| Language
|--------------------------------------------------------------------------
*/
Route::get('/lang/{lang}', function (Request $request, string $lang) {
    if (!in_array($lang, ['th', 'en'])) abort(400);
    $request->session()->put('lang', $lang);
    return back()->withCookie(cookie('lang', $lang, 60 * 24 * 30));
})->name('lang.switch');
