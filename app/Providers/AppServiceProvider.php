<?php

namespace App\Providers;

use App\Repositories\CompanyRepository;
use App\Repositories\CompanyRepositoryInterface;
use App\Repositories\MessageRepository;
use App\Repositories\MessageRepositoryInterface;
use App\Repositories\MessageViewedRepository;
use App\Repositories\MessageViewedRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Services\MessageService;
use App\Services\UserService;
use App\Services\AuthService;
use App\Services\CompanyService;
use App\Services\MessageViewedService;
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
        $this->app->bind(MessageViewedRepositoryInterface::class, MessageViewedRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);

        // Registrar o MessageService. Caso seja necessário outro Repository, adicionar outro singleton
        $this->app->singleton(MessageService::class, function ($app) {
            return new MessageService(
                $app->make(MessageRepositoryInterface::class)
            );
        });

        $this->app->singleton(CompanyService::class, function ($app) {
            return new CompanyService(
                $app->make(CompanyRepositoryInterface::class)
            );
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService(
                $app->make(UserRepositoryInterface::class)
            );
        });

        $this->app->singleton(MessageViewedService::class, function ($app) {
            return new MessageViewedService(
                $app->make(MessageViewedRepositoryInterface::class),
                $app->make(MessageRepositoryInterface::class)
            );
        });

        $this->app->singleton(AuthService::class, function ($app) {
            return new AuthService(
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
