<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\AssenzaFactory;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Models\Asz00f;

// use Modules\Xot\Services\ModelService; // DEPRECATED: Class not found
/**
 * Modules\Progressioni\Models\Assenza.
 *
 * @property int $id
 * @property int|null $tipo
 * @property int|null $codice
 * @property string|null $descr
 * @property int|null $anno
 * @property string|null $umi
 * @property string|null $dur
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Collection<int, Asz00f> $asz00fs
 * @property int|null $asz00fs_count
 *
 * @method static AssenzaFactory factory($count = null, $state = [])
 * @method static Builder|Assenza newModelQuery()
 * @method static Builder|Assenza newQuery()
 * @method static Builder|Assenza query()
 * @method static Builder|Assenza whereAnno($value)
 * @method static Builder|Assenza whereCodice($value)
 * @method static Builder|Assenza whereCreatedAt($value)
 * @method static Builder|Assenza whereCreatedBy($value)
 * @method static Builder|Assenza whereDescr($value)
 * @method static Builder|Assenza whereDur($value)
 * @method static Builder|Assenza whereId($value)
 * @method static Builder|Assenza whereTipo($value)
 * @method static Builder|Assenza whereUmi($value)
 * @method static Builder|Assenza whereUpdatedAt($value)
 * @method static Builder|Assenza whereUpdatedBy($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Assenza extends BaseModel
{
    protected $fillable = ['id', 'tipo', 'codice', 'descr', 'anno', 'umi', 'dur'];

    protected $table = 'codici_assenze_progressione';

    public function schedas(): void
    {
        // solo per prendere
        // dddx('WIP');
        // return $this->hasMany(Scheda::class);
        // dddx($this->asz00f);

        // return $this->hasManyThrough(Scheda::class, Asz00f::class);
    }

    /**
     * @return HasMany<\Modules\Sigma\Models\Asz00f, $this>
     */
    public function asz00fs(): HasMany
    {
        // ModelService::make()->setModel(app(Asz00f::class))->indexIfNotExists(['asztip', 'aszcod', 'aszann', 'asz2kd', 'asz2ka']);
        // TODO: Replace with proper index creation logic when ModelService is available

        return $this->hasMany(Asz00f::class, 'asztip', 'tipo')
            ->where('aszcod', $this->codice)
            ->where('aszann', '')
            ->ofYear((int) $this->anno);
    }
}
