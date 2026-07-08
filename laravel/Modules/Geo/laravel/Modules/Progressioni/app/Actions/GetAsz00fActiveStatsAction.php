<?php

declare(strict_types=1);

namespace Modules\Progressioni\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Modules\Progressioni\Datas\Asz00fActiveStatsData;
use Modules\Progressioni\Models\Asz00f;

/**
 * Aggrega conteggio e estremi date su assenze Sigma attive (aszann = '').
 */
class GetAsz00fActiveStatsAction
{
    public function execute(): Asz00fActiveStatsData
    {
        $activeCount = $this->activeQuery()->count();

        /** @var list<int> $lowestAsz2kd */
        $lowestAsz2kd = $this->pluckDistinctIntegers(
            $this->activeQuery()
                ->where('asz2kd', '>', 0)
                ->distinct()
                ->orderBy('asz2kd')
                ->limit(10)
                ->pluck('asz2kd'),
        );

        /** @var list<int> $highestAsz2ka */
        $highestAsz2ka = $this->pluckDistinctIntegers(
            $this->activeQuery()
                ->where('asz2ka', '>', 0)
                ->distinct()
                ->orderByDesc('asz2ka')
                ->limit(10)
                ->pluck('asz2ka'),
        );

        return new Asz00fActiveStatsData(
            activeCount: $activeCount,
            lowestAsz2kd: $lowestAsz2kd,
            highestAsz2ka: $highestAsz2ka,
        );
    }

    /**
     * @return Builder<Asz00f>
     */
    private function activeQuery(): Builder
    {
        return Asz00f::query()->where('aszann', '');
    }

    /**
     * @param  Collection<int, mixed>  $values
     * @return list<int>
     */
    private function pluckDistinctIntegers(Collection $values): array
    {
        return array_values(
            $values
                ->unique()
                ->values()
                ->map(static fn (mixed $value): int => (int) $value)
                ->take(10)
                ->all(),
        );
    }
}
