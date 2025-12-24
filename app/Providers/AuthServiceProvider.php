<?php

namespace App\Providers;

use App\Models\Approval;
use App\Policies\ApprovalPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings.
     */
    protected $policies = [
        Approval::class => ApprovalPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
