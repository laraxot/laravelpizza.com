<?php

/**
 * @see https://github.com/shuvroroy/filament-spatie-laravel-health/tree/main
 */

declare(strict_types=1);

namespace Modules\Xot\Filament\Pages;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Widgets\WidgetConfiguration;
use Illuminate\Support\Facades\Artisan;
use Laraxot\SmtpHealthCheck\SmtpCheck;
use Modules\Xot\Filament\Widgets\HealthOverviewWidget;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Check;
use Spatie\Health\Checks\Checks\CacheCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\DatabaseConnectionCountCheck;
use Spatie\Health\Checks\Checks\DatabaseSizeCheck;
use Spatie\Health\Checks\Checks\DatabaseTableSizeCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\FlareErrorOccurrenceCountCheck;
use Spatie\Health\Checks\Checks\HorizonCheck;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\QueueCheck;
use Spatie\Health\Checks\Checks\RedisCheck;
use Spatie\Health\Checks\Checks\RedisMemoryUsageCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\Health\Commands\RunHealthChecksCommand;
use Spatie\Health\Facades\Health;
use Spatie\Health\ResultStores\ResultStore;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;

class HealthPage extends XotBasePage
{
    /**
     * Untyped to match HandlesEvents::$listeners.
     *
     * @var array<string, string>
     */
    protected $listeners = ['refresh-component' => '$refresh'];

    protected string $view = 'xot::filament.pages.health';

    public function refresh(): void
    {
        /** @var array<int, Check> $checks */
        $checks = [
            OptimizedAppCheck::new(),
            DebugModeCheck::new(),
            EnvironmentCheck::new(),
            UsedDiskSpaceCheck::new(),
            DatabaseCheck::new(),
            DatabaseSizeCheck::new(),
            DatabaseTableSizeCheck::new(),
            CacheCheck::new(),
            DatabaseConnectionCountCheck::new(),
            FlareErrorOccurrenceCountCheck::new(),
            HorizonCheck::new(),
            // Checks\MeiliSearchCheck::new(),
            QueueCheck::new(),
            RedisCheck::new(),
            ScheduleCheck::new(),
            RedisMemoryUsageCheck::new(),
            // Checks\PingCheck::new()->url('https://google.com')->name('Google'),
        ];
        if (class_exists(CpuLoadCheck::class)) {
            $checks[] = CpuLoadCheck::new();
        }
        if (class_exists(SecurityAdvisoriesCheck::class)) {
            $checks[] = SecurityAdvisoriesCheck::new();
        }
        if (class_exists(SmtpCheck::class)) {
            $checks[] = SmtpCheck::new();
        }

        /*
         * PHPStan Level 10: CpuLoadCheck, SecurityAdvisoriesCheck, and SmtpCheck
         * all extend Check, but their types are not recognized due to dynamic loading.
         * We suppress this specific error as the runtime type is guaranteed to be correct.
         * @phpstan-ignore-next-line
         */
        Health::checks($checks);
        Artisan::call(RunHealthChecksCommand::class);
        $this->dispatch('refresh-component');
        Notification::make()
            ->title('Health check results refreshed')
            ->success()
            ->send();
    }

    /**
     * @return array<int, Action>
     */
    protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->tooltip('refresh')
                ->icon('heroicon-o-arrow-path')
                ->button()
                ->action('refresh'),
        ];
    }

    /**
     * @return array<int, WidgetConfiguration>
     */
    protected function getHeaderWidgets(): array
    {
        return [
            HealthOverviewWidget::make(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $checkResults = app(ResultStore::class)->latestResults();

        return [
            'lastRanAt' => $checkResults?->finishedAt,
            'checkResults' => $checkResults,
        ];
    }
}
