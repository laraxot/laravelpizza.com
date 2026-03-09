<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Illuminate\Support\Carbon;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class UserTypeRegistrationsChartWidget extends XotBaseChartWidget
{
    public string $model = 'Modules\User\Models\User';

    protected static ?int $sort = 1;

    public function getHeading(): ?string
    {
        return 'Registrazioni Utenti';
    }

    protected function getData(): array
    {
        $startDate = now()->subDays(30);
        $endDate = now();

        $data = Trend::model($this->model)
            ->between(start: $startDate, end: $endDate)
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Utenti',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.5)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => Carbon::parse($value->date)->format('d/m')),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
