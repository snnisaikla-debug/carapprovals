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
        Route::get('/account/password', [AccountController::class, 'showChangePasswordForm'])
            ->name('account.password');
        Route::post('/account/password', [AccountController::class, 'updatePassword'])
            ->name('account.password.update');

        Route::get('/account/security', [AccountController::class, 'showSecurityForm'])
            ->name('account.security');
        Route::post('/account/email', [AccountController::class, 'requestEmailChange'])
            ->name('account.email.request');
        Route::get('/account/email/verify', [AccountController::class, 'verifyEmailChange'])
            ->name('account.email.verify');
        
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
    | Approvals (จัดระเบียบใหม่: ห้ามใช้ Route::resource ผสมกับ Route เขียนเอง)
    |--------------------------------------------------------------------------
    */

        // 1. กลุ่ม Route ที่เป็น "ชื่อเฉพาะ" (Static) -> ต้องอยู่บนสุด!
        Route::get('/approvals/fetch-version/{id}', [ApprovalController::class, 'fetchVersion'])->name('approvals.fetchVersion');
        Route::get('/approvals/create', [ApprovalController::class, 'create'])->name('approvals.create');
        Route::get('/approvals', [ApprovalController::class, 'index'])->name('approvals.index');

        // 2. กลุ่ม Route สำหรับการกระทำ (Actions / POST)
        Route::post('/approvals', [ApprovalController::class, 'store'])->name('approvals.store');
        Route::post('/approvals/{groupId}/status', [ApprovalController::class, 'updateStatus'])->name('approvals.updateStatus'); // อันนี้เหมือนจะซ้ำกับ update-status ข้างล่าง เลือกใช้สักอันครับ
        Route::post('/approvals/{group_id}/update-status', [ApprovalController::class, 'updateStatus'])->name('approvals.updateStatus');
        Route::post('/approvals/{group_id}/new-version', [ApprovalController::class, 'createNewVersion'])->name('approvals.newVersion');
        Route::post('/approvals/{groupId}/submit', [ApprovalController::class, 'submit'])->name('approvals.submit');
        Route::post('/approvals/{groupId}/approve-manager', [ApprovalController::class, 'approveManager'])->name('approvals.approveManager');
        Route::post('/approvals/{groupId}/reject', [ApprovalController::class, 'reject'])->name('approvals.reject');

        // 3. กลุ่ม Route ที่รับค่าตัวแปร {id}, {groupId} (Dynamic) -> ต้องอยู่ล่างสุดเสมอ!
        // เพราะถ้าเอาไว้บน มันจะเข้าใจว่าคำว่า "create" หรือ "fetch-version" เป็น id ของใบงาน
        Route::get('/approvals/{id}', [ApprovalController::class, 'show'])->name('approvals.show');
        Route::get('/approvals/group/{group_id}', [ApprovalController::class, 'showGroup'])->name('approvals.showGroup');
        Route::get('/approvals/{id}/edit', [ApprovalController::class, 'edit'])->name('approvals.edit');
        Route::post('/approvals/{id}/update', [ApprovalController::class, 'update'])->name('approvals.update');
        Route::delete('/approvals/{groupId}', [ApprovalController::class, 'destroy'])->name('approvals.destroy');
        Route::get('/approvals/{id}/pdf', [ApprovalController::class, 'exportPdf'])->name('approvals.exportPdf');

    /*
    |--------------------------------------------------------------------------
    | Account
    |--------------------------------------------------------------------------
    */
    // หน้าหลักของบัญชี 
        Route::get('/account', [AccountController::class, 'show'])->name('account.show');
        Route::get('/account', [AccountController::class, 'edit'])
            ->name('account.index');

        Route::get('/account/edit', [AccountController::class, 'edit'])->name('account.edit');
        Route::post('/account/edit', [AccountController::class, 'update'])->name('account.update');
    
        Route::get('/account/password', [AccountController::class, 'editPassword'])->name('account.password.edit');
        
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