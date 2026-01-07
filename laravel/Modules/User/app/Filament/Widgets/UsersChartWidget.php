<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
// use Filament\Widgets\Concerns\InteractsWithPageFilters; // Temporaneamente commentato per evitare conflitti trait in Filament 4.x
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Modules\User\Models\AuthenticationLog;
use Webmozart\Assert\Assert;

class UsersChartWidget extends ChartWidget implements HasActions, HasForms
{
    use InteractsWithActions;
    use InteractsWithForms;
    // use InteractsWithPageFilters; // Temporaneamente commentato per evitare conflitti trait in Filament 4.x

    /**
     * @var array<string, mixed>|null
     */
    public ?array $pageFilters = null;

    public string $chart_id = '';

    protected ?string $pollingInterval = null;

    protected static ?int $sort = 2;

    public function getHeading(): Htmlable|string|null
    {
        return 'Authentication Log';
    }

    /**
     * Define the action to be tested.
     */
    public function testAction(): Action
    {
        return Action::make('test')
            ->requiresConfirmation()
            ->action(function (array $arguments): void {
                Log::debug('Test action called', $arguments);
            });
    }

    protected function getType(): string
    {
        return 'line';
    }

    /**
     * Retrieve the chart data based on the given filters.
     */
    protected function getData(): array
    {
        // Rimuovere chiamate di test non necessarie per ridurre overhead
        // $this->mountAction('test', ['id' => 5]);
        // $this->testAction();

        try {
            // Type narrowing for PHPStan Level 10
            $pageFilters = isset($this->pageFilters) && is_array($this->pageFilters) ? $this->pageFilters : null;

            $startDateValue = is_array($pageFilters) && isset($pageFilters['startDate']) ? $pageFilters['startDate'] : null;
            $endDateValue = is_array($pageFilters) && isset($pageFilters['endDate']) ? $pageFilters['endDate'] : null;

            Assert::nullOrString($startDate = $startDateValue);
            Assert::nullOrString($endDate = $endDateValue);
            if (null === $endDate) {
                $endDate = Carbon::now()->format('Y-m-d H:i:s');
            }
            if (null === $startDate) {
                $startDate = Carbon::now()->subMonth()->format('Y-m-d H:i:s');
            }
            Assert::notNull($startDate = Carbon::createFromFormat('Y-m-d H:i:s', $startDate));
            Assert::notNull($endDate = Carbon::createFromFormat('Y-m-d H:i:s', $endDate));

            // Limitare il range massimo a 90 giorni per ridurre memory usage
            if ($startDate->diffInDays($endDate, true) > 90) {
                $startDate = $endDate->copy()->subDays(90);
            }
        } catch (\Exception $e) {
            return [];
        }

        // Limitare a massimo 1000 record per evitare problemi di memoria
        $data = Trend::model(AuthenticationLog::class)
            ->dateColumn('login_at')
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perDay()
            // ->perMonth()
            ->count()
            ->take(1000); // Limite massimo di 1000 record
        /*
         * // Update callbacks to match expected signature
         * $chartData = $data->map(function ($value) {
         * Assert::isInstanceOf($value, TrendValue::class);
         *
         * return $value->aggregate;
         * })->toArray();
         * $chartLabels = $data->map(function ($value) {
         * Assert::isInstanceOf($value, TrendValue::class);
         *
         * return $value->date->format('Y-m-d');
         * })->toArray();
         */

        $chartData = $data->pluck('aggregate')->toArray();
        $chartLabels = $data->pluck('date')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Number of logins executed',
                    'data' => $chartData,
                ],
            ],
            'labels' => $chartLabels,
        ];
    }
}
