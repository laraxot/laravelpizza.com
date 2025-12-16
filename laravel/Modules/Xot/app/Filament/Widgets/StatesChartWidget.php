<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Widgets;

use RuntimeException;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Override;

class StatesChartWidget extends XotBaseChartWidget
{
    public string $stateClass;

    public string $model;

    protected ?string $heading = null;

    protected static ?int $sort = 4;

    protected static bool $isLazy = true;

    #[Override]
    public function getHeading(): ?string
    {
        return static::transClass($this->model, 'widgets.states_chart.heading');
    }

    #[Override]
    protected function getData(): array
    {
        $label = static::transClass($this->model, 'widgets.states_chart.label');
        try {
            /** @var class-string<Model> $modelClass */
            $modelClass = $this->model;

            $queryResult = $modelClass::selectRaw('state, COUNT(*) as count')
                ->groupBy('state')
                ->get();

            if (! is_object($queryResult) || ! method_exists($queryResult, 'keyBy')) {
                throw new RuntimeException('Invalid query result');
            }

            $states = $queryResult->keyBy('state');

            /** @var array<string, string> $colors */
            $colors = [
                'active' => 'rgb(34, 197, 94)',
                'pending' => 'rgb(234, 179, 8)',
                'integration_requested' => 'rgb(107, 114, 128)',
            ];

            return [
                'datasets' => [
                    [
                        'label' => $label,
                        'data' => $states->pluck('count')->toArray(),
                        'backgroundColor' => $states
                            ->keys()
                            ->map(fn ($state) => $colors[(string) $state] ?? 'rgb(156, 163, 175)')
                            ->toArray(),
                        'borderColor' => $states
                            ->keys()
                            ->map(fn ($state) => $colors[(string) $state] ?? 'rgb(156, 163, 175)')
                            ->toArray(),
                        'borderWidth' => 1,
                    ],
                ],
                'labels' => $states
                    ->keys()
                    ->map(fn ($state) => static::transClass($this->model, 'states.'.((string) $state).'.label'))
                    ->toArray(),
            ];
        } catch (Exception $e) {
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

    #[Override]
    protected function getType(): string
    {
        return 'bar';
    }
}
