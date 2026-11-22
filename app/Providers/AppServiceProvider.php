<?php

namespace App\Providers;

use App\Events\OrderCreated;
use App\Listeners\RegisterCdekOrder;
use App\Listeners\SendOrderEmail;
use App\Services\CartService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartService::class, fn ($app) => new CartService($app['session.store']));
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            OrderCreated::class,
            SendOrderEmail::class,
        );

        Event::listen(
            OrderCreated::class,
            RegisterCdekOrder::class,
        );
    }
}
