<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
        {
            //
        }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
        {
            //
        }
        
        /** ลงทะเบียน policy */
    protected $policies = [
        \App\Models\Approval::class => \App\Policies\ApprovalPolicy::class,
        ];
}
