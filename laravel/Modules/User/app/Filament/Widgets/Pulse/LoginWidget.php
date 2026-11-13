<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets\Pulse;

use Carbon\CarbonImmutable;
use Carbon\CarbonInterval;
use Filament\Widgets\ChartWidget;
use Laravel\Pulse\Contracts\Storage;
use Modules\User\Actions\Login\GetLoginHistoryAction;

class LoginWidget extends ChartWidget
{
    private const array PULSE_FILTERS = ['1h', '6h', '24h', '7d'];

    protected ?string $heading = 'Accessi utenti';

    protected ?string $pollingInterval = '60s';

    protected int|string|array $columnSpan = 'full';

    protected ?string $maxHeight = '250px';

    public ?string $filter = '24h';

    protected function getFilters(): ?array
    {
        return [
            '1h' => 'Ultima ora',
            '6h' => 'Ultime 6 ore',
            '24h' => 'Ultime 24 ore',
            '7d' => 'Ultimi 7 giorni',
            '30g' => 'Ultimi 30 giorni',
            '1a' => 'Ultimo anno',
            'all' => 'Storico completo',
        ];
    }

    protected function getData(): array
    {
        if (in_array($this->filter, self::PULSE_FILTERS, true)) {
            return $this->pulseData();
        }

        return $this->historyData();
    }

    /**
     * @return array{datasets: list<array<string, mixed>>, labels: list<string>}
     */
    private function historyData(): array
    {
        // 'all' (default) = storico completo in bucket mensili.
        [$since, $granularity] = match ($this->filter) {
            '30g' => [CarbonImmutable::now('UTC')->subDays(30), 'day'],
            '1a' => [CarbonImmutable::now('UTC')->subYear(), 'day'],
            default => [null, 'month'],
        };

        $history = app(GetLoginHistoryAction::class)
            ->execute($since, $granularity);

        return $this->chartData($history['data'], $history['labels']);
    }

    /**
     * @return array{datasets: list<array<string, mixed>>, labels: list<string>}
     */
    private function pulseData(): array
    {
        $interval = match ($this->filter) {
            '1h' => CarbonInterval::hour(),
            '6h' => CarbonInterval::hours(6),
            '7d' => CarbonInterval::days(7),
            default => CarbonInterval::hours(24),
        };

        // Come Pulse::graph(): storage in rescue per non rompere la dashboard.
        $graphs = rescue(
            fn () => $this->pulseStorage()
                ->graph(['user_login'], 'count', $interval),
        );

        $readings = $graphs?->get('all')
            ?->get('user_login') ?? collect();

        return $this->chartData(
            array_values($readings->values()->all()),
            array_values($readings->keys()->all()),
        );
    }

    private function pulseStorage(): Storage
    {
        return app(Storage::class);
    }

    /**
     * @param  list<int|float|null>  $data
     * @param  list<string>  $labels
     * @return array{datasets: list<array<string, mixed>>, labels: list<string>}
     */
    private function chartData(array $data, array $labels): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Accessi',
                    'data' => $data,
                    'borderColor' => '#9333ea',
                    'backgroundColor' => 'rgba(147, 51, 234, 0.1)',
                    'fill' => true,
                    'tension' => 0.2,
                    'spanGaps' => false,
                    'pointRadius' => 0,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}
