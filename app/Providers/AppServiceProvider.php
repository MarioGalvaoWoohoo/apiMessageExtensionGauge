<?php

namespace App\Providers;

use App\Repositories\MessageRepository;
use App\Repositories\RepositoryInterface;
use App\Services\MessageService;
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
        $this->app->bind(RepositoryInterface::class, MessageRepository::class);

        // Registrar o MessageService. Caso seja necessário outro Repository, adicionar outro singleton
        $this->app->singleton(MessageService::class, function ($app) {
            return new MessageService(
                $app->make(RepositoryInterface::class)
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
