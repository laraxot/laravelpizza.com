<?php

declare(strict_types=1);

namespace Modules\Chart\Filament\Widgets\Samples;

use Filament\Widgets\ChartWidget;

class Sample01Chart extends ChartWidget
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
                    // 'label' => 'Blog posts created',
                    'data' => [50, 60, 70, 180, 190],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                    'data2' => ['aaa', 'bbbb', 'ccc', 'ddd', 'mmmm'],
                ],
            ],
            'labels' => ['January', 'February', 'March', 'April', 'May'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
                // 'tooltipNote'=> [
                //    'display' => true,
                // ],
                // 'doughnutLabel' => false,
                'datalabels' => [
                    'display' => true,
                    'backgroundColor' => '#ccc',
                    'borderRadius' => 3,
                    'anchor' => 'start',
                    'font' => [
                        'color' => 'red',
                        'weight' => 'bold',
                    ],
                    'labels' => [
                        'name' => [
                            'align' => 'top',
                            'font' => ['size' => 9],
                            // formatter: function(value, ctx) {
                            // return ctx.active
                            //     ? 'name'
                            //     : ctx.chart.data.labels[ctx.dataIndex];
                            // }
                        ],
                        'value' => [
                            'align' => 'bottom',
                            // backgroundColor: function(ctx) {
                            // var value = ctx.dataset.data[ctx.dataIndex];
                            // return value > 50 ? 'white' : null;
                            // },
                            'borderColor' => 'white',
                            'borderWidth' => 2,
                            'borderRadius' => 4,
                            // color: function(ctx) {
                            // var value = ctx.dataset.data[ctx.dataIndex];
                            // return value > 50
                            //     ? ctx.dataset.backgroundColor
                            //     : 'white';
                            // },
                            // formatter: function(value, ctx) {
                            // return ctx.active
                            //     ? 'value'
                            //     : Math.round(value * 1000) / 1000;
                            // },
                            'padding' => 4,
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
