<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;

 
   
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
        Route::get('/', function () {
        return redirect()->route('login');
    });

    /*
    |--------------------------------------------------------------------------
    | Protected Routes
    |--------------------------------------------------------------------------
    */
    Route::middleware('auth')->group(function () {
        Route::resource('approvals', ApprovalController::class);
    
    // เพิ่มบรรทัดนี้เพื่อรองรับการกด อนุมัติ/ตีกลับ
    Route::post('approvals/{groupId}/status', [ApprovalController::class, 'updateStatus'])->name('approvals.updateStatus');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Custom Routes ของ Approval
    Route::post('/approvals/{group_id}/update-status', [ApprovalController::class, 'updateStatus'])->name('approvals.updateStatus');
    Route::post('/approvals/{group_id}/new-version', [ApprovalController::class, 'createNewVersion'])->name('approvals.newVersion');
    Route::get('/approvals/group/{group_id}', [ApprovalController::class, 'showGroup'])->name('approvals.showGroup');
    Route::get('/approvals/{id}/pdf', [ApprovalController::class, 'exportPdf'])->name('approvals.exportPdf');

    // Change Password/Gmail
    Route::get('/account/password', [AccountController::class, 'showChangePasswordForm'])->name('account.password');
    Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::get('/account/security', [AccountController::class, 'showSecurityForm'])->name('account.security');
    Route::post('/account/email', [AccountController::class, 'requestEmailChange'])->name('account.email.request');
    Route::get('/account/email/verify', [AccountController::class, 'verifyEmailChange'])->name('account.email.verify');
    
    /*
    |--------------------------------------------------------------------------
    | จัดหน้า หน้าแรก sale/admin/manager
    |--------------------------------------------------------------------------
        */
        Route::get('/lang/toggle', function () {
            $current = session('lang', config('app.locale', 'th'));
            $next = $current === 'th' ? 'en' : 'th';
            session(['lang' => $next]);
            return back();
        })->name('lang.toggle');

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
        Route::get('/approvals/{groupId}', [ApprovalController::class, 'show'])
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
        Route::get('/approvals/{id}/pdf', [App\Http\Controllers\ApprovalController::class, 'exportPdf'])
            ->name('approvals.exportPdf');

        // ✅ Submit
        Route::post('/approvals/{groupId}/submit', [ApprovalController::class, 'submit'])
        ->name('approvals.submit');

        // ✅ Manager Approve” → Approved (จบ)
        Route::post('/approvals/{groupId}/approve-manager', [ApprovalController::class, 'approveManager'])
        ->name('approvals.approveManager');

        // ✅ Reject (Admin หรือ Manager กด Reject)
        Route::post('/approvals/{groupId}/reject', [ApprovalController::class, 'reject'])
        ->name('approvals.reject');
        

    /*
    |--------------------------------------------------------------------------
    | Account
    |--------------------------------------------------------------------------
    */
    // หน้าหลักของบัญชี
    // Route::get('/account', [AccountController::class, 'show'])->name('account.show');

        Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
        Route::post('/account/edit', [AccountController::class, 'update'])->name('account.update');
        
        Route::get('/account/password', [AccountController::class, 'editPassword'])->name('account.password.edit');
        Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
        Route::post('/account/password', [AccountController::class, 'updatePassword'])->name('account.updatePassword');
        
        // updateSphp artisan route:clearphp artisan route:clear
        Route::get('/account/avatar', [AccountController::class, 'editAvatar'])->name('account.avatar.edit');
        Route::post('/account/avatar', [AccountController::class, 'updateAvatar'])->name('account.avatar.update');
        Route::post('/account/update', [AccountController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('/account/photo', [AccountController::class, 'updatePhoto'])->name('account.photo');
        Route::delete('/account/destroy', [AccountController::class, 'destroy'])->name('account.destroy');
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
    | MANAGER
    |--------------------------------------------------------------------------
    */
    Route::middleware('manager')->group(function () {
        Route::post('/manager/approvals/{groupId}', [ApprovalController::class, 'managerAction'])
            ->name('approvals.managerAction');
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