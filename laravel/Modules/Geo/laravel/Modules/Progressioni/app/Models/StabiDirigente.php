<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\StabiDirigenteFactory;
use Modules\Ptv\Models\Profile;
use Modules\Ptv\Models\StabiDirigente as PtvStabiDirigenteModel;
use Modules\Sigma\Models\Repart;

/**
 * @property int $id
 * @property int|null $stabi
 * @property int|null $repar
 * @property int|null $anno
 * @property string|null $nome_diri
 * @property string|null $budget
 * @property-read Collection<int, Scheda> $benificiariProgressione
 * @property-read Collection<int, Scheda> $schede
 * @property-read Repart|null $repart
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static StabiDirigenteFactory factory($count = null, $state = [])
 * @method static Builder<static>|StabiDirigente query()
 *
 * @mixin \Eloquent
 */
class StabiDirigente extends PtvStabiDirigenteModel
{
    protected $connection = 'progressione';

    public function budgetAssegnato(): float
    {
        return (float) $this->benificiariProgressione->sum(
            static fn (Scheda $item): int|float => $item->costo_fascia_up * $item->ptime
        );
    }

    /** @return HasMany<Scheda, $this> */
    public function schede(): HasMany
    {
        return $this->hasMany(Scheda::class, 'valutatore_id', 'id');
    }

}
