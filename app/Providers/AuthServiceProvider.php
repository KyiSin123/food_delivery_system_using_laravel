<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
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
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('edit-delete-shop', function(User $user, Shop $shop) {

            return $user->id === $shop->user_id;
        });

        Gate::define('add-menu', function($user, $shop) {

            return $user->id === $shop->user_id;
        });

        Gate::define('edit-delete-menu', function($user, $shop) {

            return $user->id === $shop->user_id;
        });

        Gate::define('add-to-cart', function($user, $shop) {
            
            return $user->id != $shop->user_id;
        });
    }
}
