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
        $this->registerInvitePolicies();
        $this->registerUserPolicies();
        $this->registerPlatformPolicies();
        $this->registerRulePolicies();
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

    public function registerInvitePolicies()
    {
        Gate::define('list-invites', function ($user) {
            return $user->hasAccess(['list-invites']);
        });

        Gate::define('create-invite', function ($user) {
            return $user->hasAccess(['create-invite']);
        });

        Gate::define('destroy-invite', function ($user) {
            return $user->hasAccess(['destroy-invite']);
        });
    }

    public function registerUserPolicies()
    {
        Gate::define('list-users', function ($user) {
            return $user->hasAccess(['list-users']);
        });

        Gate::define('create-user', function ($user) {
            return $user->hasAccess(['create-user']);
        });

        Gate::define('edit-user', function ($user) {
            return $user->hasAccess(['edit-user']) || auth()->id() == $user->id;
        });

        Gate::define('delete-user', function ($user) {
            return $user->hasAccess(['delete-user']);
        });
    }

    public function registerPlatformPolicies()
    {
        Gate::define('list-platforms', function ($user) {
            return $user->hasAccess(['list-platforms']);
        });

        Gate::define('create-platform', function ($user) {
            return $user->hasAccess(['create-platform']);
        });

        Gate::define('edit-platform', function ($user) {
            return $user->hasAccess(['edit-platform']);
        });

        Gate::define('delete-platform', function ($user) {
            return $user->hasAccess(['delete-platform']);
        });
    }

    public function registerRulePolicies()
    {
        Gate::define('create-rule', function ($user) {
            return $user->hasAccess(['create-rule']);
        });

        Gate::define('edit-rule', function ($user) {
            return $user->hasAccess(['edit-rule']);
        });

        Gate::define('delete-rule', function ($user) {
            return $user->hasAccess(['delete-rule']);
        });
    }
}
