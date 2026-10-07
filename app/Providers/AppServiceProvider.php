<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        app()->bind(\App\Services\Payments\PaymentInterface::class, \App\Services\Payments\PayHappyService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('exemplo', fn(User $user) => true);

        Gate::define('can_access_manager', fn(\App\Models\User $user) => $user->hasRole('ROLE_ADMIN'));

        Blade::directive('cartcount', function(string $expression) {
            return "<?php if(count($expression)): ?>";
        });


        Blade::directive('endcartcount', function(string $expression) {
            return '<?php endif; ?>';
        });

    }
}
