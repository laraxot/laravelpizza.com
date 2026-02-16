<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Widgets;

use Illuminate\Support\Carbon;
use Modules\Meetup\Models\Event;
use Modules\Xot\Filament\Widgets\XotBaseChartWidget;

class EventsTimelineChart extends XotBaseChartWidget
{
    protected ?string $heading = 'Eventi nel Tempo';

    protected static ?int $sort = 2;

    /**
     * Get the data for the chart.
     *
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        $data = Event::selectRaw('COUNT(*) as count, DATE_FORMAT(start_date, "%Y-%m") as month')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'datasets' => [
                [
                    'label' => 'Eventi',
                    'data' => $data->pluck('count')->toArray(),
                    'fill' => 'start',
                    'tension' => 0.4,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgb(54, 162, 235)',
                    'pointBackgroundColor' => 'rgb(54, 162, 235)',
                    'pointBorderColor' => '#fff',
                ],
            ],
            'labels' => $data->map(function (Event $item) {
                /** @var mixed $monthValue */
                $monthValue = $item->getAttribute('month');
                if (! is_string($monthValue) || empty($monthValue)) {
                    return '';
                }

                return Carbon::parse($monthValue)->translatedFormat('M Y');
            })->toArray(),
        ];
    }

    /**
     * Get the type of the chart.
     */
    protected function getType(): string
    {
        return 'line';
    }
}
