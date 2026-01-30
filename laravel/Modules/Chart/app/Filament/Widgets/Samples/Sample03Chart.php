<?php

declare(strict_types=1);
/**
 * @see https://codesandbox.io/p/sandbox/chartjs-doughnut-center-labels-2h4zt?file=%2Fsrc%2Findex.js
 * @see https://www.geeksforgeeks.org/how-to-add-text-inside-the-doughnut-chart-using-chart-js/
 * @see https://quickchart.io/documentation/chart-js/custom-pie-doughnut-chart-labels/
 * @see https://jsfiddle.net/kdvuxbtj/
 */

namespace Modules\Chart\Filament\Widgets\Samples;

use Filament\Widgets\ChartWidget;

class Sample03Chart extends ChartWidget
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
            'datalabels' => [
                'color' => '#FFCE56',
            ],
            'labels' => ['January', 'February', 'March', 'April', 'May'],
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
                // 'legend' => [
                //    'display' => false,
                // ],
                'datalabels' => [
                    'display' => true,
                    'color' => '#FFCE56',
                    'backgroundColor' => '#ccc',
                    'borderRadius' => 3,
                    'font' => [
                        'color' => 'red',
                        'weight' => 'bold',
                    ],
                ],
                'doughnutlabel' => [
                    'labels' => [
                        [
                            'text' => '550',
                            'font' => [
                                'size' => 20,
                                'weight' => 'bold',
                            ],
                        ],
                        [
                            'text' => 'total',
                        ],
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
