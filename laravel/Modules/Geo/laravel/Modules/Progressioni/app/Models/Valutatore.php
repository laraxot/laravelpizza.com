<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Ptv\Models\Valutatore as PtvValutatore;
use Modules\Sigma\Models\Repart;
use Override;

/**
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property string|null $nome_stabi
 * @property int|null $anno
 * @property-read Collection<int, Scheda> $benificiariProgressione
 * @property-read Collection<int, Scheda> $schede
 * @property-read Repart|null $repart
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static \Modules\Progressioni\Database\Factories\ValutatoreFactory factory($count = null, $state = [])
 * @method static Builder<static>|Valutatore query()
 *
 * @mixin \Eloquent
 */
class Valutatore extends PtvValutatore
{
    protected $connection = 'progressione';

    #[Override]
    public function getNomeStabiAttribute($value): ?string
    {
        if ($value !== null) {
            return $value;
        }

        if (! $this->repart instanceof Repart) {
            return $value;
        }

        return $this->repart->dest1;
    }

    public function budgetAssegnato(): float
    {
        return (float) $this->benificiariProgressione->sum(
            static fn (Scheda $item): int|float => $item->costo_fascia_up * $item->ptime
        );
    }
}
