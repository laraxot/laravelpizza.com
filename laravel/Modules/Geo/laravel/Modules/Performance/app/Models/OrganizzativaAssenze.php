<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\OrganizzativaAssenze.
 *
 * @property int $id
 * @property int|null $tipo
 * @property int|null $codice
 * @property string|null $descr
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @method static Builder|OrganizzativaAssenze newModelQuery()
 * @method static Builder|OrganizzativaAssenze newQuery()
 * @method static Builder|OrganizzativaAssenze query()
 * @method static Builder|OrganizzativaAssenze whereAnno($value)
 * @method static Builder|OrganizzativaAssenze whereCodice($value)
 * @method static Builder|OrganizzativaAssenze whereCreatedAt($value)
 * @method static Builder|OrganizzativaAssenze whereCreatedBy($value)
 * @method static Builder|OrganizzativaAssenze whereDescr($value)
 * @method static Builder|OrganizzativaAssenze whereId($value)
 * @method static Builder|OrganizzativaAssenze whereTipo($value)
 * @method static Builder|OrganizzativaAssenze whereUpdatedAt($value)
 * @method static Builder|OrganizzativaAssenze whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class OrganizzativaAssenze extends BaseModel
{
    // use Updater;
    protected $fillable = ['id', 'tipo', 'codice', 'descr', 'anno'];

    protected $table = 'codici_assenze_organizzativa';

    // protected $connection = 'performance'; // this will use the specified database connection
    /*
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    */
}
