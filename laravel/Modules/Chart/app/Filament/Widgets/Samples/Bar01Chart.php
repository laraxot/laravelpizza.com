<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets\Samples;

use Filament\Support\RawJs;
use Filament\Widgets\ChartWidget;

class Bar01Chart extends ChartWidget
{
    protected ?string $heading = 'Blog Posts';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    // 'label' => 'Blog posts created',
                    'data' => [50, 60, 70, 180, 190],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['January', 'February', 'March', 'April', 'May'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    // *
    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<'JS'
            {

                plugins: {
                    datalabels: {
                        //formatter: function(value, context) {
                        //    return context.chart.data.labels[context.dataIndex] + '%';
                        //}
                        color: 'blue',
                        labels: {
                            title: {
                                font: {
                                    weight: 'bold'
                                }
                            },
                            value: {
                                color: 'green'
                            }
                        }
                    }
                },
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
    // */
}
