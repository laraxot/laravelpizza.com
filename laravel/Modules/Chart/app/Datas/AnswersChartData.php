<?php

declare(strict_types=1);

namespace Modules\Chart\Datas;

use Filament\Support\RawJs;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\DataCollection;
use Webmozart\Assert\Assert;

class AnswersChartData extends Data
{
    public int $tot = 0;

    public string $title = 'no_set';

    public string $footer = 'no_set';

    #[MapInputName('tot_answered')]
    public int $totalAnswered = 0;

    #[MapInputName('tot_invited')]
    public int $totalInvited = 0;

    /**
     * @var DataCollection<AnswerData>
     */
    public DataCollection $answers;

    public ChartData $chart;

    public function getChartJsType(): string
    {
        $type = $this->chart->type;
        switch ($type) {
            case 'pie1':
            case 'pieAvg': // questa è una media ha un solo valore
                $type = 'doughnut';
                break;
            case 'lineSubQuestion':
                $type = 'line';
                break;
            case 'bar2':
            case 'bar1':
            case 'bar3':
            case 'horizbar1':
                $type = 'bar';
                break;

            default:
                // dddx([
                //    'type' => $type,
                //    'chart' => $this->chart,
                // ]);
                break;
        }

        return $type;
    }

    /**
     * @return array{
     *     datasets: array<int, array{
     *         label: string|array<string>,
     *         data: array<int, int|float|string>,
     *         data2?: array<int, int|float|string>,
     *         borderColor?: string|array<int, string>|null,
     *         backgroundColor?: string|array<int, string>|null,
     *     }>,
     *     labels: array<int, string>
     * }
     */
    public function getChartJsData(): array
    {
        $datasets = [];
        $answersCollection = $this->answers->toCollection();

        $labelsCollection = $answersCollection
            ->pluck('label')
            ->map(static fn ($label): string => (string) $label)
            ->values();

        $data = $answersCollection->pluck('value')->all();

        if (\in_array($this->chart->type, ['pieAvg', 'pie1'], false)) {
            $data = $answersCollection->pluck('avg')->all();

            if (isset($this->chart->max)) {
                Assert::numeric($sum = collect($data)->sum());
                Assert::numeric($this->chart->max);
                $other = $this->chart->max - $sum;
                if ($other > 0.01) {
                    $data[] = $other;
                    $labelsCollection->push((string) ($this->chart->answer_value_no_txt ?? 'answer_value_no_txt'));
                }
            }

            $data = $this->normalizeSeries($data);
        }

        if (isset($data[0]) && \is_array($data[0])) {
            $legends = array_keys($data[0]);
            foreach ($legends as $key => $legend) {
                $series = array_column($data, $legend);

                $datasets[] = [
                    'label' => (string) $legend,
                    'data' => $this->normalizeSeries($series),
                    'borderColor' => $this->chart->getColorsRgba(0.5)[$key] ?? null,
                    'backgroundColor' => $this->chart->getColorsRgba(0.5)[$key] ?? null,
                ];
            }
        } else {
            $avgValues = $answersCollection->pluck('avg')->values()->map(
                static fn ($item): string => number_format(SafeFloatCastAction::cast($item, 0.0), 2, '.', '')
            )->all();

            if (isset($this->chart->max)) {
                Assert::numeric($sum = collect($avgValues)->sum());
                Assert::numeric($this->chart->max);
                $other = $this->chart->max - $sum;
                if ($other > 0.01) {
                    $avgValues[] = number_format($other, 2, '.', '');
                    $labelsCollection->push((string) ($this->chart->answer_value_no_txt ?? 'answer_value_no_txt'));
                }
            }

            /** @phpstan-ignore offsetAccess.nonOffsetAccessible */
            $label = isset($answersCollection->pluck('avg')[0]) && ! \is_string($answersCollection->pluck('avg')[0])
                ? 'Media'
                : 'Percentuale';

            $datasets = [
                [
                    'label' => $label,
                    'data' => array_values($avgValues),
                    'data2' => $this->normalizeSeries($answersCollection->pluck('value')->all()),
                    'borderColor' => $this->chart->getColorsRgba(0.5),
                    'backgroundColor' => $this->chart->getColorsRgba(0.5),
                ],
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labelsCollection->values()->all(),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getChartJsOptionsArray(): array
    {
        $title = [];

        if ($this->title !== 'no_set') {
            $title = [
                'display' => true,
                'text' => $this->title,
                'font' => [
                    'size' => 14,
                ],
            ];
        }

        if ($this->footer !== 'no_set') {
            $title = [
                'display' => true,
                'text' => $this->footer,
                'position' => 'bottom',
            ];
        }

        $options = [];
        $options['plugins'] = [
            'title' => $title,
        ];

        if ($this->chart->type === 'horizbar1') {
            $options['indexAxis'] = 'y';
        }

        $chartJsType = $this->getChartJsType();
        $method = 'getChartJs'.Str::of($chartJsType)->studly()->toString().'OptionsArray';

        return $this->resolveChartOptions($method, $options);
    }

    public function getChartJsBarOptionsJs(): string
    {
        $chartJsData = $this->getChartJsData();
        $labels = $this->buildBarLabelsJs($chartJsData);
        $title = $this->buildBarTitleJs();
        $tooltip = $this->buildBarTooltipJs($chartJsData);
        $valueSuffix = $this->determineValueSuffix();
        $indexAxis = $this->determineIndexAxis();

        return <<<JS
            plugins: {
                title: {$title}
                ,datalabels:{
                    formatter: function(value) {
                        return value+'{$valueSuffix}';
                    },
                    display: true,
                    backgroundColor: '#ccc',
                    borderRadius:3,
                    anchor: 'start',
                    font: {
                        color: 'red',
                        weight: 'bold',
                    },
                    labels: {$labels}
                },
                legend:{
                    display: false,
                },
                tooltip: {$tooltip}
            },

            indexAxis: '{$indexAxis}'
            JS;
    }

    public function getChartJsDoughnutOptionsJs(): string
    {
        $title = '{}';
        if ($this->title !== 'no_set') {
            $title = "{
                        display: true,
                        text: '{$this->title}',
                        font: {
                            size: 14
                        },
                    }";
        }
        $firstAnswer = $this->answers->first();
        $label = '--';
        if ($firstAnswer !== null) {
            Assert::isInstanceOf($firstAnswer, AnswerData::class, '['.__LINE__.']['.__FILE__.']');
            /** @phpstan-ignore property.nonObject */
            $label = round((float) $this->answers->first()->avg, 2);
        }

        return <<<JS
            scales: {
                x:{
                    grid:{
                        display:false,
                    },
                    ticks:{
                        display:false,
                    }
                },
                y:{
                    grid:{
                        display:false,
                    },
                    ticks:{
                        display:false,
                    }
                }
            },
            plugins:{
                title: {$title}
                ,datalabels: false,
                doughnutLabel:{
                    label: '{$label}',
                }
            }
        JS;
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function getChartJsBarOptionsArray(array $options): array
    {
        if (! isset($options['plugins'])) {
            $options['plugins'] = [];
        }
        Assert::isArray($options['plugins']);
        $options['plugins']['datalabels'] = [
            'display' => true,
            'backgroundColor' => '#ccc',
            'borderRadius' => 3,
            'anchor' => 'start',
            'font' => [
                'color' => 'red',
                'weight' => 'bold',
            ],
        ];
        $options['plugins']['legend'] = [
            'display' => false,
        ];

        return $options;
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    public function getChartJsDoughnutOptionsArray(array $options): array
    {
        $options['scales'] = [
            'x' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false, // Questa opzione nasconde i numeri sull'asse X
                ],
            ],
            'y' => [
                'grid' => [
                    'display' => false,
                ],
                'ticks' => [
                    'display' => false, // Questa opzione nasconde i numeri sull'asse Y
                ],
            ],
        ];

        if (! isset($options['plugins'])) {
            $options['plugins'] = [];
        }
        Assert::isArray($options['plugins']);
        $options['plugins']['datalabels'] = [
            'display' => false,
        ];
        Assert::isInstanceOf($this->answers->first(), AnswerData::class, '['.__LINE__.']['.__FILE__.']');
        $options['plugins']['doughnutLabel'] = [
            'label' => round((float) $this->answers->first()->avg, 2),
        ];

        return $options;
    }

    public function getChartJsOptionsJs(): RawJs
    {
        $chartJsType = $this->getChartJsType();
        $method = 'getChartJs'.Str::of($chartJsType)->studly()->toString().'OptionsJs';
        $js = $this->{$method}();

        return RawJs::make('{
            '.(string) $js.'
            }');
    }

    /**
     * funzione deprecata, utilizzata nella dashboard precedente
     *
     * @return array<string, mixed>
     */
    public function getChartJsOptions(): array
    {
        $title = [];

        if ($this->title !== 'no_set') {
            $title = [
                'display' => true,
                'text' => $this->title,
                'font' => [
                    'size' => 14,
                ],
            ];
        }

        if ($this->footer !== 'no_set') {
            $title = [
                'display' => true,
                'text' => $this->footer,
                'position' => 'bottom',
            ];
        }

        $options = [];
        $options['plugins'] = [
            'title' => $title,
        ];

        if ($this->chart->type === 'horizbar1') {
            $options['indexAxis'] = 'y';
        }

        $chartJsType = $this->getChartJsType();
        $method = 'getChartJs'.Str::of($chartJsType)->studly()->toString().'OptionsArray';

        return $this->resolveChartOptions($method, $options);
    }

    /**
     * @param array{
     *     datasets: array<int, array<string, mixed>>,
     *     labels: array<int, string>
     * } $chartJsData
     */
    private function buildBarLabelsJs(array $chartJsData): string
    {
        if (\is_array($chartJsData['datasets']) && \count($chartJsData['datasets']) === 1 && $this->chart->type !== 'horizbar1') {
            return "{
                name: {
                    align: 'center',
                    formatter: function(value, ctx) {
                        return ctx.dataset.data2[ctx.dataIndex];
                    },
                    font: {
                        size: 13,
                    },
                    borderWidth: 2,
                    borderRadius: 4,
                    padding: 4
                },
                value: {
                    align: 'bottom',
                    font: {
                        size: 13
                    },
                    borderWidth: 2,
                    borderRadius: 4,
                    padding: 4
                }
            }";
        }

        return '{}';
    }

    private function buildBarTitleJs(): string
    {
        if ($this->footer !== 'no_set') {
            return "{
                        display: true,
                        text: '".$this->footer."',
                        position: 'bottom',
                    }";
        }

        if ($this->title !== 'no_set' && $this->chart->type === 'horizbar1') {
            return "{
                        display: true,
                        text: '".$this->title."',
                        font: {
                            size: 14
                        },
                    }";
        }

        return '{}';
    }

    /**
     * @param array{
     *     datasets: array<int, array<string, mixed>>,
     *     labels: array<int, string>
     * } $chartJsData
     */
    private function buildBarTooltipJs(array $chartJsData): string
    {
        if ($this->chart->type === 'bar2' && \is_array($chartJsData['datasets']) && \count($chartJsData['datasets']) === 1) {
            return "{
                callbacks: {
                    label: function(context) {
                        let label = (context.dataset.label || '') + ':' + (context.dataset.data[context.dataIndex] || '');

                        if (context.dataset.data2 && context.dataset.data2[context.dataIndex] !== '') {
                            label = label + '/ Rispondenti:' + (context.dataset.data2[context.dataIndex] || '');
                        }

                        return label;
                    }
                }
            }";
        }

        return '{}';
    }

    private function determineValueSuffix(): string
    {
        if ($this->chart->type === 'horizbar1' || $this->chart->max === 100.0) {
            return ' %';
        }

        return '';
    }

    private function determineIndexAxis(): string
    {
        return $this->chart->type === 'horizbar1' ? 'y' : 'x';
    }

    /**
     * @param  array<int|string, mixed>  $series
     * @return array<int, int|float|string>
     */
    private function normalizeSeries(array $series): array
    {
        $normalized = [];

        foreach (array_values($series) as $value) {
            if (\is_int($value) || \is_float($value) || \is_string($value)) {
                $normalized[] = $value;

                continue;
            }

            if ($value === null) {
                $normalized[] = 0;

                continue;
            }

            $normalized[] = $value instanceof Stringable ? (string) $value : '';
        }

        return $normalized;
    }

    /**
     * @param  array<string, mixed>  $options
     * @return array<string, mixed>
     */
    private function resolveChartOptions(string $method, array $options): array
    {
        /** @var array<string, mixed> */
        $result = $this->{$method}($options);

        return $result;
    }
}
