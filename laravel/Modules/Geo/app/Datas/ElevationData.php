<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Spatie\LaravelData\Data;

/**
 * Data object per la gestione delle informazioni sull'elevazione.
 *
 * @property float $elevation Elevazione in metri
 * @property float $latitude Latitudine del punto
 * @property float $longitude Longitudine del punto
 * @property float|null $resolution Risoluzione dei dati di elevazione in metri
 */
class ElevationData extends Data
{
    public function __construct(
        public readonly float $elevation,
        public readonly float $latitude,
        public readonly float $longitude,
        public readonly ?float $resolution = null,
    ) {}
}
