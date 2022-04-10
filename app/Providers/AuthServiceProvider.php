<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Template' => 'App\Policies\TemplatePolicy',
        'App\Models\Service' => 'App\Policies\ServicePolicy',
        'App\Models\Requirement' => 'App\Policies\RequirementPolicy',
        'App\Models\Step' => 'App\Policies\StepPolicy',
        'App\Models\Project' => 'App\Policies\ProjectPolicy',
        'App\Models\Product' => 'App\Policies\ProductPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\Branch' => 'App\Policies\BranchPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes();
        }

        Passport::personalAccessTokensExpireIn(Carbon::now()->addHours(12));

        Gate::before(function ($user) {
            return $user->isSuperAdmin() ? true : null;
        });
    }
}
