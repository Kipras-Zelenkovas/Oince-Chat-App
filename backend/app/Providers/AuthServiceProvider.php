<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

use App\Policies\Friends;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('isRequested', [Friends::class, 'isRequested']);
        Gate::define('isAccepted', [Friends::class, 'isAccepted']);
        Gate::define('isBlocked', [Friends::class, 'isBlocked']);

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return 'https://localhost:5173/reset-password?token=' . $token . '&email=' . $user->email;
        });
    }
}
