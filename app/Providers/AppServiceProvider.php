<?php

namespace App\Providers;

use App\Repositories\MessageRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\MessageService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Registrar o MessageRepositoryInterface. Caso seja necessário outro Repository, adicionar outro bind
        $this->app->bind(MessageRepositoryInterface::class, MessageRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);

        // Registrar o MessageService. Caso seja necessário outro Repository, adicionar outro singleton
        $this->app->singleton(MessageService::class, function ($app) {
            return new MessageService(
                $app->make(MessageRepositoryInterface::class)
            );
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService(
                $app->make(UserRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
