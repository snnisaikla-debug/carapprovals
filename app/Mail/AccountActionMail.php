<?php

namespace App\Mail;

use App\Models\AccountAction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AccountActionMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public AccountAction $action) {}

    public function build()
    {
        return $this->subject('ยืนยันการเปลี่ยนแปลงบัญชี (YPB Approvals)')
            ->view('emails.account_action');
    }
}
