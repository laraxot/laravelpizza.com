<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets\Samples;

use Filament\Widgets\ChartWidget;

class Doughnut01Chart extends ChartWidget
{
    protected ?string $heading = 'Blog Posts';

    /**
     * @return array<string, mixed>
     */
    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
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
        return 'doughnut';
    }

    /**
     * @return array<string, mixed>
     */
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
                'doughnutLabel' => [
                    'label' => 'label 1 !',
                ],
                'datalabels' => [
                    'display' => false,
                    'backgroundColor' => '#ccc',
                    'borderRadius' => 3,
                    'anchor' => 'start',
                    'font' => [
                        'color' => 'red',
                        'weight' => 'bold',
                    ],
                ],
            ],
        ];
    }

    /*
    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                'datalabels'=> [
                    'display'=> true,
                    'backgroundColor'=> '#ccc',
                    'borderRadius'=> 3,
                    'font'=> [
                      'color'=> 'red',
                      'weight'=> 'bold',
                    ],
                ],
                  'doughnutlabel'=> [
                    'labels'=> [
                      [
                        'text'=> '550',
                        'font'=> [
                          'size'=> 20,
                          'weight'=> 'bold',
                        ],
                        ],
                      [
                        'text'=> 'total',
                      ],
                    ],
                ],
            ],
        ];

    }
    */
    /*
    protected function getOptions(): RawJs
    {
        return RawJs::make(<<<JS
            {
                datalabels: {
                    display: true,
                    backgroundColor: '#ccc',
                    borderRadius: 3,
                    font: {
                    color: 'red',
                    weight: 'bold',
                    },
                },
                doughnutlabel: {
                    labels: [
                    {
                        text: '550',
                        font: {
                        size: 20,
                        weight: 'bold',
                        },
                    },
                    {
                        text: 'total',
                    },
                    ],
                },
            }
        JS);
    }
    */
}
