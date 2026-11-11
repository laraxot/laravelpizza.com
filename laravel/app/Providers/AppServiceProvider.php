<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Facades\Health;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerHealthChecks();
    }

    /**
     * Controlli di produzione (spatie/laravel-health): `php artisan health:check` ogni minuto via scheduler
     * (routes/console.php); in caso di errore mail a HEALTH_NOTIFY_EMAIL. `/up` resta il ping per il load balancer.
     * docs/deploy/runbook.md.
     */
    private function registerHealthChecks(): void
    {
        // boot() puo' girare piu' volte (test, Octane): registrare due volte fa fallire spatie/laravel-health.
        if (Health::registeredChecks()->isNotEmpty()) {
            return;
        }

        Health::checks([
            DatabaseCheck::new(),
            CacheCheck::new(),
            UsedDiskSpaceCheck::new()->warnWhenUsedSpaceIsAbovePercentage(80)->failWhenUsedSpaceIsAbovePercentage(90),
            ScheduleCheck::new()->heartbeatMaxAgeInMinutes(5),
            DebugModeCheck::new()->if(app()->isProduction()),
            EnvironmentCheck::new()->expectEnvironment('production')->if(app()->isProduction()),
        ]);
    }
}
