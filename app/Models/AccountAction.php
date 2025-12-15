<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccountAction extends Model
{
    protected $fillable = ['user_id','type','token','payload','expires_at','confirmed_at'];
    protected $casts = [
        'payload' => 'array',
        'expires_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}

