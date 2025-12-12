<?php

namespace App\Policies;

use App\Models\Approval;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ApprovalPolicy
{
    public function view(User $user, Approval $approval): bool
        {
            return true; // ทุก role ดูได้ (หรือจำกัดตามบริษัทก็ได้)
        }

    public function update(User $user, Approval $approval): bool
        {
            // sale แก้ได้เฉพาะของตัวเอง และยังไม่ผ่านหัวหน้า
            return $user->role === 'sale'
                && $approval->sales_user_id === $user->id
                && in_array($approval->status, ['WAIT_ADMIN','REJECTED_ADMIN','REJECTED_HEAD']);
        }

    public function delete(User $user, Approval $approval): bool
        {
            return $user->role === 'sale'
                && $approval->sales_user_id === $user->id
                && $approval->status !== 'APPROVED';
        }

    public function approve(User $user, Approval $approval): bool
        {
            return ($user->role === 'admin' && $approval->status === 'WAIT_ADMIN')
                || ($user->role === 'head'  && $approval->status === 'WAIT_HEAD');
        }

    public function reject(User $user, Approval $approval): bool
        {
            return $this->approve($user, $approval);
        }
}