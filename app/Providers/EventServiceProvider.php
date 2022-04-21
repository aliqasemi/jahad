<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Requirement;
use App\Models\Service;
use App\Models\Template;
use App\Observers\CategoryObserver;
use App\Observers\ProjectObserver;
use App\Observers\RequirementObserver;
use App\Observers\ServiceObserver;
use App\Observers\TemplateObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Category::observe(CategoryObserver::class);
        Service::observe(ServiceObserver::class);
        Requirement::observe(RequirementObserver::class);
        Template::observe(TemplateObserver::class);
        Project::observe(ProjectObserver::class);
    }
}
