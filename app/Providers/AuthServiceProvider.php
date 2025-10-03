<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Project;
use App\Policies\ProjectPolicy;


class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // register policies
        // If Gate isn't bound yet (bootstrap ordering issues), defer the policy
        // registration until the application is booting to avoid container errors.
        if ($this->app->bound(\Illuminate\Contracts\Auth\Access\Gate::class)) {
            Gate::policy(Project::class, ProjectPolicy::class);
        } else {
            $this->app->booting(function () {
                Gate::policy(Project::class, ProjectPolicy::class);
            });
        }
    }
}
