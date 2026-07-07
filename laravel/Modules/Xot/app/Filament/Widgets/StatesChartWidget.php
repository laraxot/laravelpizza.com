<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StatesChartWidget extends XotBaseChartWidget
{
    public string $stateClass;

    public string $model;

    protected ?string $heading = null;

    protected static ?int $sort = 4;

    protected static bool $isLazy = true;

    #[\Override]
    public function getHeading(): ?string
    {
        return static::transClass($this->model, 'widgets.states_chart.heading');
    }

    #[\Override]
    protected function getData(): array
    {
        $label = static::transClass($this->model, 'widgets.states_chart.label');
        try {
            /** @var class-string<Model> $modelClass */
            $modelClass = $this->model;
            $instance = new $modelClass();

            /** @var array<string, string> $colors */
            $colors = [
                'active' => 'rgb(34, 197, 94)',
                'pending' => 'rgb(234, 179, 8)',
                'integration_requested' => 'rgb(107, 114, 128)',
            ];

            /** @var array<string, int> $states */
            $states = [];
            $rows = DB::connection($instance->getConnectionName())
                ->table($instance->getTable())
                ->selectRaw('state, COUNT(*) as count')
                ->groupBy('state')
                ->get();
            foreach ($rows as $row) {
                $state = (string) ($row->state ?? '');
                $states[$state] = (int) ($row->count ?? 0);
            }

            $data = [];
            $backgroundColor = [];
            $labels = [];
            foreach ($states as $state => $count) {
                $data[] = $count;
                $backgroundColor[] = $colors[$state] ?? 'rgb(156, 163, 175)';
                $labels[] = static::transClass($this->model, 'states.'.$state.'.label');
            }

            return [
                'datasets' => [
                    [
                        'label' => $label,
                        'data' => $data,
                        'backgroundColor' => $backgroundColor,
                        'borderColor' => $backgroundColor,
                        'borderWidth' => 1,
                    ],
                ],
                'labels' => $labels,
            ];
        } catch (\Exception $e) {
            // Fallback appropriato senza logging inutile
            return [
                'datasets' => [
                    [
                        'label' => $label,
                        'data' => [],
                        'backgroundColor' => [],
                        'borderColor' => [],
                        'borderWidth' => 1,
                    ],
                ],
                'labels' => [],
            ];
        }
    }

    #[\Override]
    protected function getType(): string
    {
        return 'bar';
    }
}
