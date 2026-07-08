<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\CriteriMaggiorazione.
 *
 * @property int $id
 * @property int $anno
 * @property int|null $min_valutaz_perf_ind
 * @property int|null $maggiorazione_perc
 * @property int|null $aventi_diritto_perc
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @method static Builder|CriteriMaggiorazione newModelQuery()
 * @method static Builder|CriteriMaggiorazione newQuery()
 * @method static Builder|CriteriMaggiorazione query()
 * @method static Builder|CriteriMaggiorazione whereAnno($value)
 * @method static Builder|CriteriMaggiorazione whereAventiDirittoPerc($value)
 * @method static Builder|CriteriMaggiorazione whereCreatedAt($value)
 * @method static Builder|CriteriMaggiorazione whereCreatedBy($value)
 * @method static Builder|CriteriMaggiorazione whereId($value)
 * @method static Builder|CriteriMaggiorazione whereMaggiorazionePerc($value)
 * @method static Builder|CriteriMaggiorazione whereMinValutazPerfInd($value)
 * @method static Builder|CriteriMaggiorazione whereUpdatedAt($value)
 * @method static Builder|CriteriMaggiorazione whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class CriteriMaggiorazione extends BaseModel
{
    protected $fillable = ['id', 'anno', 'min_valutaz_perf_ind', 'maggiorazione_perc', 'aventi_diritto_perc', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    protected $table = 'criteri_maggiorazione';

    // use Updater;
    // protected $connection = 'performance'; // this will use the specified database connection
    // public $timestamps= false;
    /*
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    */

    // end search
    // -------------------------
}// end class
