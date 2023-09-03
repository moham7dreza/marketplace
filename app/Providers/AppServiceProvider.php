<?php

namespace App\Providers;

use App\Enums\PermissionEnum;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        $this->setGateBefore();
    }

    private function setGateBefore(): void
    {
        Gate::before(static function ($user) {
            return $user->hasPermissionTo(PermissionEnum::super_admin->value);
        });
    }
}
