<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Approval;

class ApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $approval;
    public $type;    // 'new' หรือ 'update'
    public $changes; // เก็บรายการที่แก้ไข (ถ้ามี)

    // รับค่าเข้ามาตอนเรียกใช้
    public function __construct(Approval $approval, $type = 'new', $changes = [])
        {
            $this->approval = $approval;
            $this->type = $type;
            $this->changes = $changes;
        }

    // สร้างเนื้อหาอีเมล
    public function build()
        {
            // เพิ่มเวลา (H:i) เข้าไปท้ายหัวข้อ เพื่อไม่ให้ซ้ำกัน
            $timestamp = date('H:i'); 

            $subject = ($this->type === 'new') 
                ? "📢 [$timestamp] ใบขออนุมัติใหม่: " . $this->approval->customer_name
                : "✏️ [$timestamp] มีการแก้ไข (V.{$this->approval->version}): " . $this->approval->customer_name;

            return $this->subject($subject)
                        ->view('emails.approval_notification');
        }
}