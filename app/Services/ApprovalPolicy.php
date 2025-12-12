<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\User;

class ApprovalService
{
    public function latest(string|int $groupId): Approval
    {
        return Approval::where('group_id', $groupId)->orderByDesc('version')->firstOrFail();
    }

    public function createNewVersion(int $groupId, array $data, User $actor): Approval
    {
        $latest = $this->latest($groupId);

        $new = $latest->replicate();          // คัดลอกฟิลด์เดิมทั้งหมด
        $new->version = $latest->version + 1; // เพิ่มเวอร์ชัน
        $new->status  = 'WAIT_ADMIN';         // ส่งใหม่เข้าผจก.
        $new->created_by = $actor->role;

        // overwrite เฉพาะฟิลด์ที่แก้จากฟอร์ม
        $new->fill($data);

        $new->save();
        return $new;
    }

    public function approve(int $groupId, User $actor): Approval
    {
        $latest = $this->latest($groupId);

        if ($actor->role === 'admin') $latest->status = 'WAIT_HEAD';
        if ($actor->role === 'head')  $latest->status = 'APPROVED';

        $latest->save();
        return $latest;
    }

    public function reject(int $groupId, User $actor): Approval
    {
        $latest = $this->latest($groupId);

        if ($actor->role === 'admin') $latest->status = 'REJECTED_ADMIN';
        if ($actor->role === 'head')  $latest->status = 'REJECTED_HEAD';

        $latest->save();
        return $latest;
    }
}
