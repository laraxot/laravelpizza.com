<?php

declare(strict_types=1);

namespace Modules\Incentivi\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Incentivi\Database\Factories\CapitalPercentageFactory;
use Modules\Ptv\Models\Profile;

/**
 * @property int $id
 * @property string $nome
 * @property string $descrizione
 * @property string $valore
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $created_by
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @method static CapitalPercentageFactory factory($count = null, $state = [])
 * @method static Builder|CapitalPercentage newModelQuery()
 * @method static Builder|CapitalPercentage newQuery()
 * @method static Builder|CapitalPercentage query()
 * @method static Builder|CapitalPercentage whereCreatedAt($value)
 * @method static Builder|CapitalPercentage whereCreatedBy($value)
 * @method static Builder|CapitalPercentage whereDescrizione($value)
 * @method static Builder|CapitalPercentage whereId($value)
 * @method static Builder|CapitalPercentage whereNome($value)
 * @method static Builder|CapitalPercentage whereUpdatedAt($value)
 * @method static Builder|CapitalPercentage whereUpdatedBy($value)
 * @method static Builder|CapitalPercentage whereValore($value)
 * @property string $tipologia
 * @property numeric $da
 * @property numeric $a
 * @property-read Profile|null $deleter
 * @method static Builder<static>|CapitalPercentage whereA($value)
 * @method static Builder<static>|CapitalPercentage whereDa($value)
 * @method static Builder<static>|CapitalPercentage whereTipologia($value)
 * @mixin \Eloquent
 */
class CapitalPercentage extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['nome', 'descrizione', 'valore', 'tipologia', 'da', 'a'];
}
