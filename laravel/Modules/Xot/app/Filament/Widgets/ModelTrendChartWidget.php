<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Carbon\Carbon;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class ModelTrendChartWidget extends XotBaseChartWidget
{
    public string $model;

    protected ?string $heading = null;

    protected static ?int $sort = 5;

    protected static bool $isLazy = true;

    protected ?string $pollingInterval = '300s'; // 5 minuti

    #[\Override]
    public function getHeading(): ?string
    {
        return static::transClass($this->model, 'widgets.model_trend_chart.heading');
    }

    #[\Override]
    protected function getData(): array
    {
        try {
            $data = Trend::model($this->model)
                ->between(
                    start: now()->subDays(30),
                    end: now(),
                )
                ->perDay()
                ->count();

            return [
                'datasets' => [
                    [
                        'label' => __('<nome modulo>::widgets.appointment_creation_chart.label'),
                        'data' => $data->map(fn (mixed $value) => $value instanceof TrendValue
                            ? $value->aggregate
                            : 0),
                        'backgroundColor' => 'rgba(139, 92, 246, 0.5)',
                        'borderColor' => 'rgb(139, 92, 246)',
                        'borderWidth' => 2,
                        'tension' => 0.4,
                    ],
                ],
                'labels' => $data->map(fn (mixed $value) => $value instanceof TrendValue
                    ? Carbon::parse($value->date)->format('d/m')
                    : ''),
            ];
        } catch (\Exception $e) {
            // Fallback appropriato senza logging inutile
            return [
                'datasets' => [
                    [
                        'label' => __('<nome modulo>::widgets.appointment_creation_chart.label'),
                        'data' => [],
                        'backgroundColor' => 'rgba(139, 92, 246, 0.5)',
                        'borderColor' => 'rgb(139, 92, 246)',
                        'borderWidth' => 2,
                        'tension' => 0.4,
                    ],
                ],
                'labels' => [],
            ];
        }
    }

    #[\Override]
    protected function getType(): string
    {
        return 'line';
    }
}
