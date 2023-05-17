<?php

namespace App\Providers;

use App\Actions\Fortify\LoginResponseImpl;
use App\Actions\Fortify\RegisterResponseImpl;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse;

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
        Paginator::useBootstrapFive();
        JsonResource::withoutWrapping();

        //@Autowired: faite moi injecter RegisterResponseImpl si vous rencontrer le contrat RegisterResponse

        $this->app->singleton(RegisterResponse::class,RegisterResponseImpl::class);
        $this->app->singleton(LoginResponse::class,LoginResponseImpl::class);
    }
}
