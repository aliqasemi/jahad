<?php

namespace App\Providers;

use App\Infrastructure\InterfaceRepository\AttachRequirementInterface;
use App\Infrastructure\InterfaceRepository\AttachServiceInterface;
use App\Infrastructure\Repository\AttachRequirementRepository;
use App\Infrastructure\Repository\AttachServiceRepository;
use Illuminate\Support\ServiceProvider;

class DependencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AttachRequirementInterface::class, AttachRequirementRepository::class);
        $this->app->bind(AttachServiceInterface::class, AttachServiceRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        return [
            AttachRequirementInterface::class,
            AttachServiceInterface::class
        ];
    }
}
