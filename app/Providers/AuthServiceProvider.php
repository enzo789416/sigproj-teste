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
    public function boot() //permissoes do sistema
    {
        $this->registerPolicies();

        Gate::define('edit-users', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('manage-users', function ($user) {
            return $user->hasAnyRole(['admin', 'author']);
        });

        Gate::define('manage-polls', function ($user) {
            return $user->hasAnyRole(['admin', 'author']);
        });

        Gate::define('vote', function ($user) {
            return $user->hasAnyRole(['admin', 'author', 'user']);
        });

        Gate::define('delete-users', function ($user) {
            return $user->hasRole('admin');
        });
    }
}
