<?php

namespace App\Policies;

use App\Models\Approval;
use App\Models\User;

class ApprovalPolicy
{
    public function update(User $user, Approval $approval): bool
    {
        // sale แก้ได้เฉพาะของตัวเอง
        if (strtolower($user->role) === 'sale') {
            return $approval->user_id === $user->id; // แนะนำใช้ user_id
            // ถ้ายังไม่มี user_id ใช้ sales_name ชั่วคราว:
            // return $approval->sales_name === $user->name;
        }

        // admin/manager ไม่ให้แก้ (แล้วแต่ระบบคุณ)
        return false;
    }
}
