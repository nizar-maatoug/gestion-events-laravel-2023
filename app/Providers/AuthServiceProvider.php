<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\EventSportif;
use App\Models\User;
use App\Policies\EventSportifPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //Pour le modèle EventSprotif appliquer la stratégie EventSportifPolicy
        EventSportif::class => EventSportifPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {//portes

        Gate::define('admin-view',function (User $user){
            return $user->role=='Admin';
        });

        Gate::define('organisateur-view',function (User $user){
            return $user->role=='Organisateur';
        });


    }
}
