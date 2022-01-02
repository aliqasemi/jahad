<?php

namespace App\Providers;

use App\Http\Infrastructure\InterfaceRepository\AttachRequirementInterface;
use App\Http\Infrastructure\InterfaceRepository\AttachServiceInterface;
use App\Http\Infrastructure\Repository\AttachRequirementRepository;
use App\Http\Infrastructure\Repository\AttachServiceRepository;
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
