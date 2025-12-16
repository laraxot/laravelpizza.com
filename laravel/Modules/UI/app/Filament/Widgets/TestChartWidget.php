<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

final class TestChartWidget extends ChartWidget
{
    public int $qid = 0;

    public string $max_height = '200px';

    public string $type = 'line';

    // protected static ?string $heading = 'Blog Posts';
    protected ?string $pollingInterval = null;

    // danger, gray, info, primary, success or warning
    protected string $color = 'info';

    public function getDescription(): string
    {
        return 'The number of blog posts published per month.';
    }

    // protected static ?string $maxHeight = '20px';

    protected function getData(): array
    {
        $this->maxHeight = $this->max_height;

        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created '.$this->qid,
                    'data' => [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return $this->type;
    }

    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
            {
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => '€' + value,
                        },
                    },
                },
            }
        JS);
    }
}
