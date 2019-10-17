<?php

namespace App\Providers;

use App\Policies\UserPolicy;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Policies from User::class
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',   (default laravel)
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
