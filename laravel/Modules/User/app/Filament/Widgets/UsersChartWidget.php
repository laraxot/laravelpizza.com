<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Flowframe\Trend\Trend;
use Illuminate\Support\Carbon;
use Modules\User\Models\AuthenticationLog;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;
use Webmozart\Assert\Assert;

final class UsersChartWidget extends XotBaseChartWidget
{
    /**
     * @var array<string, mixed>|null
     */
    public ?array $pageFilters = null;

    public string $chart_id = '';

    protected ?string $pollingInterval = null;

    protected static ?int $sort = 2;

    public function getHeading(): string
    {
        return __('user::widgets.users_chart.heading');
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
        try {
            // Type narrowing for PHPStan Level 10
            $pageFilters = isset($this->pageFilters) && is_array($this->pageFilters) ? $this->pageFilters : null;

            $startDateValue = is_array($pageFilters) && isset($pageFilters['startDate']) ? $pageFilters['startDate'] : null;
            $endDateValue = is_array($pageFilters) && isset($pageFilters['endDate']) ? $pageFilters['endDate'] : null;

            Assert::nullOrString($startDate = $startDateValue);
            Assert::nullOrString($endDate = $endDateValue);
            if ($endDate === null) {
                $endDate = Carbon::now()->format('Y-m-d H:i:s');
            }
            if ($startDate === null) {
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
            ->count()
            ->take(1000); // Limite massimo di 1000 record

        $chartData = $data->pluck('aggregate')->toArray();
        $chartLabels = $data->pluck('date')->toArray();

        return [
            'datasets' => [
                [
                    'label' => __('user::widgets.users_chart.label'),
                    'data' => $chartData,
                ],
            ],
            'labels' => $chartLabels,
        ];
    }
}
