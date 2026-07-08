<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Anzianitum.
 *
 * @method static Builder|Anzianitum newModelQuery()
 * @method static Builder|Anzianitum newQuery()
 * @method static Builder|Anzianitum query()
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $liv
 * @property float|null $giorni
 * @property string|null $punt_anz
 * @property string|null $anno
 * @property string|null $giorni_in_fascia
 * @property string|null $giorni_in_pa
 *
 * @method static Builder|Anzianitum whereAnno($value)
 * @method static Builder|Anzianitum whereEnte($value)
 * @method static Builder|Anzianitum whereGiorni($value)
 * @method static Builder|Anzianitum whereGiorniInFascia($value)
 * @method static Builder|Anzianitum whereGiorniInPa($value)
 * @method static Builder|Anzianitum whereId($value)
 * @method static Builder|Anzianitum whereLiv($value)
 * @method static Builder|Anzianitum whereMatr($value)
 * @method static Builder|Anzianitum wherePosfun($value)
 * @method static Builder|Anzianitum wherePropro($value)
 * @method static Builder|Anzianitum wherePuntAnz($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AnzianitumFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Anzianitum extends BaseModel
{
    protected $table = 'anzianitum';
}
