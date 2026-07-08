<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\IndividualeCatCoeff.
 *
 * @property int $id
 * @property string|null $lista_propro
 * @property string|null $coeff
 * @property string|null $descr
 * @property string|null $tot_giorni
 * @property string|null $tot_giorni_pt
 * @property string|null $tot_giorni_pt_coeff
 * @property string|null $quota_teorica
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @method static Builder|IndividualeCatCoeff newModelQuery()
 * @method static Builder|IndividualeCatCoeff newQuery()
 * @method static Builder|IndividualeCatCoeff query()
 * @method static Builder|IndividualeCatCoeff whereAnno($value)
 * @method static Builder|IndividualeCatCoeff whereCoeff($value)
 * @method static Builder|IndividualeCatCoeff whereCreatedAt($value)
 * @method static Builder|IndividualeCatCoeff whereCreatedBy($value)
 * @method static Builder|IndividualeCatCoeff whereDescr($value)
 * @method static Builder|IndividualeCatCoeff whereId($value)
 * @method static Builder|IndividualeCatCoeff whereListaPropro($value)
 * @method static Builder|IndividualeCatCoeff whereQuotaTeorica($value)
 * @method static Builder|IndividualeCatCoeff whereTotGiorni($value)
 * @method static Builder|IndividualeCatCoeff whereTotGiorniPt($value)
 * @method static Builder|IndividualeCatCoeff whereTotGiorniPtCoeff($value)
 * @method static Builder|IndividualeCatCoeff whereUpdatedAt($value)
 * @method static Builder|IndividualeCatCoeff whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property mixed $tot Dynamic property from selectRaw queries
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class IndividualeCatCoeff extends BaseModel
{
    protected $fillable = [
        'id', 'lista_propro', 'coeff', 'descr',
        'tot_giorni', 'tot_giorni_pt', 'tot_giorni_pt_coeff',
        'quota_teorica', 'anno',
    ];

    protected $table = 'individuale_cat_coeffs';

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

    // ---------------------------------------------------------------------------

    // ------------------------------------------------------------------------------
} // end class
