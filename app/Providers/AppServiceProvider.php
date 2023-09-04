<?php

namespace App\Providers;

use App\Enums\PermissionEnum;
use App\Models\Product;
use App\Models\User;
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

        Gate::define('destroy-product', function (User $user, Product $product) {
            return $user->id == $product->user_id;
        });
    }

    private function setGateBefore(): void
    {
        Gate::before(static function ($user) {
            return $user->hasPermissionTo(PermissionEnum::super_admin->value);
        });
    }
}
