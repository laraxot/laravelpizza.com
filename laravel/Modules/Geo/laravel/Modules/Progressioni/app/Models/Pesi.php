<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\PesiFactory;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Progressioni\Models\Pesi.
 *
 * @property int $id
 * @property string|null $lista_propro
 * @property string|null $descr
 * @property int|null $peso_esperienza_acquisita
 * @property int|null $peso_risultati_ottenuti
 * @property int|null $peso_arricchimento_professionale
 * @property int|null $peso_impegno
 * @property int|null $peso_qualita_prestazione
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 *
 * @method static PesiFactory factory($count = null, $state = [])
 * @method static Builder|Pesi newModelQuery()
 * @method static Builder|Pesi newQuery()
 * @method static Builder|Pesi query()
 * @method static Builder|Pesi whereAnno($value)
 * @method static Builder|Pesi whereCreatedAt($value)
 * @method static Builder|Pesi whereCreatedBy($value)
 * @method static Builder|Pesi whereDescr($value)
 * @method static Builder|Pesi whereId($value)
 * @method static Builder|Pesi whereListaPropro($value)
 * @method static Builder|Pesi wherePesoArricchimentoProfessionale($value)
 * @method static Builder|Pesi wherePesoEsperienzaAcquisita($value)
 * @method static Builder|Pesi wherePesoImpegno($value)
 * @method static Builder|Pesi wherePesoQualitaPrestazione($value)
 * @method static Builder|Pesi wherePesoRisultatiOttenuti($value)
 * @method static Builder|Pesi whereUpdatedAt($value)
 * @method static Builder|Pesi whereUpdatedBy($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @mixin \Eloquent
 */
class Pesi extends BaseModel
{
    protected $table = 'peso';

    protected $fillable = ['id', 'lista_propro', 'descr',
        'peso_esperienza_acquisita',
        'peso_risultati_ottenuti',
        'peso_arricchimento_professionale',
        'peso_impegno',
        'peso_qualita_prestazione',
        'anno',
    ];

    public static function copyFromLastYear(): string
    {
        $anno = 0;
        $params = getRouteParameters();
        extract($params);
        $curr_rows = self::where('anno', $anno)->get();
        $prev_rows = self::where('anno', -1)->get();
        if ($curr_rows->count() !== 0) {
            return 'copiate righe da anno prec';
        }
        if ($prev_rows->count() <= 0) {
            return 'copiate righe da anno prec';
        }
        foreach ($prev_rows as $prev_row) {
            $clone_row = $prev_row->replicate();
            $clone_row->anno = $anno;
            $clone_row->save();
        }

        return 'copiate righe da anno prec';
    }

    // -----------------------------------------
}
