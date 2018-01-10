<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerGamePolicies();
    }

    public function registerGamePolicies()
    {
        Gate::define('approved-games', function ($user) {
            return $user->hasAccess(['approved-games']);
        });

        Gate::define('suggested-games', function ($user) {
            return $user->hasAccess(['suggested-games']);
        });

        Gate::define('edit-game', function ($user) {
            return $user->hasAccess(['edit-game']);
        });

        Gate::define('delete-game', function ($user) {
            return $user->hasAccess(['delete-game']);
        });

        Gate::define('approve-game', function ($user) {
            return $user->hasAccess(['approve-game']);
        });
    }
}
