<?php

declare(strict_types=1);

namespace Modules\Progressioni\Datas;

/**
 * Statistiche aggregate su record Asz00f attivi (aszann vuoto = non annullati).
 */
final readonly class Asz00fActiveStatsData
{
    /**
     * @param  list<int>  $lowestAsz2kd  Dieci valori distinti più bassi di asz2kd
     * @param  list<int>  $highestAsz2ka  Dieci valori distinti più alti di asz2ka
     */
    public function __construct(
        public int $activeCount,
        public array $lowestAsz2kd,
        public array $highestAsz2ka,
    ) {}
}
