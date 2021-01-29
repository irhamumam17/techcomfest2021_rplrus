<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users', function($user){
            // TODO: logika untuk mengizinkan manage users
            return count(array_intersect(["ADMIN"], json_decode($user->roles)));
        });

        Gate::define('manage-fields', function($user){
            // TODO: logika untuk mengizinkan manage fields
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });

        Gate::define('manage-bookings', function($user){
            // TODO: logika untuk mengizinkan manage bookings
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });

        Gate::define('manage-schedules', function($user){
            // TODO: logika untuk mengizinkan manage schedules
            return count(array_intersect(["ADMIN", "STAFF"], json_decode($user->roles)));
        });
    }
}
