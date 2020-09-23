<?php

namespace App\Providers;

use App\User;
use App\Student;
use App\Represent;
use App\Department;
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
        //return Auth::user();
        // 管理員 Gate

        Gate::define('admin', function ($user) {
            return $user->role === User::ROLE_ADMIN;
        });

        // 學生 Gate
        Gate::define('student', function ($user) {
            return $user->role === Student::ROLE_STUDENT;
        });

    }
        
        /*
        if (Gate::allows('admin')) {
            return '系統管理者。';
        }

        if (Gate::denies('admin')) {
            return '非系統管理者！';
        }*/
}
