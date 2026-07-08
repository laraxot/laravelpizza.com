<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\OrganizzativaCatCoeff.
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
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property float|null $tot Total value
 * @method static Builder|OrganizzativaCatCoeff newModelQuery()
 * @method static Builder|OrganizzativaCatCoeff newQuery()
 * @method static Builder|OrganizzativaCatCoeff query()
 * @method static Builder|OrganizzativaCatCoeff whereAnno($value)
 * @method static Builder|OrganizzativaCatCoeff whereCoeff($value)
 * @method static Builder|OrganizzativaCatCoeff whereCreatedAt($value)
 * @method static Builder|OrganizzativaCatCoeff whereCreatedBy($value)
 * @method static Builder|OrganizzativaCatCoeff whereDescr($value)
 * @method static Builder|OrganizzativaCatCoeff whereId($value)
 * @method static Builder|OrganizzativaCatCoeff whereListaPropro($value)
 * @method static Builder|OrganizzativaCatCoeff whereQuotaTeorica($value)
 * @method static Builder|OrganizzativaCatCoeff whereTotGiorni($value)
 * @method static Builder|OrganizzativaCatCoeff whereTotGiorniPt($value)
 * @method static Builder|OrganizzativaCatCoeff whereTotGiorniPtCoeff($value)
 * @method static Builder|OrganizzativaCatCoeff whereUpdatedAt($value)
 * @method static Builder|OrganizzativaCatCoeff whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class OrganizzativaCatCoeff extends BaseModel
{
    protected $fillable = ['id', 'lista_propro', 'coeff', 'descr', 'tot_giorni', 'tot_giorni_pt', 'tot_giorni_pt_coeff', 'quota_teorica', 'anno', 'tot'];

    /*
    protected $connection = 'performance'; // this will use the specified database connection

    use Updater;
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    */
}
