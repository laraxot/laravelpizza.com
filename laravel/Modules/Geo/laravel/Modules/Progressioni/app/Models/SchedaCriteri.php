<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models;

// ------ Traits -------
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Progressioni\Database\Factories\SchedaCriteriFactory;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Models\Traits\SigmaModelTrait;

/**
 * Modules\Progressioni\Models\SchedaCriteri.
 *
 * @property int $id
 * @property string|null $criterio
 * @property int|null $peso
 * @property string|null $descr
 * @property int|null $is_editable
 * @property string|null $field_name
 * @property int|null $anno
 * @property int|null $pos
 * @property int|null $converted_in
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static SchedaCriteriFactory factory($count = null, $state = [])
 * @method static Builder|SchedaCriteri newModelQuery()
 * @method static Builder|SchedaCriteri newQuery()
 * @method static Builder|SchedaCriteri ofDate(int $date)
 * @method static Builder|SchedaCriteri ofEnteYear(int $ente, int $year)
 * @method static Builder|SchedaCriteri ofQuarter(int $quarter, int $year)
 * @method static Builder|SchedaCriteri ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|SchedaCriteri ofYear(int $year)
 * @method static Builder|SchedaCriteri query()
 * @method static Builder|SchedaCriteri whereAnno($value)
 * @method static Builder|SchedaCriteri whereConvertedIn($value)
 * @method static Builder|SchedaCriteri whereCreatedAt($value)
 * @method static Builder|SchedaCriteri whereCreatedBy($value)
 * @method static Builder|SchedaCriteri whereCriterio($value)
 * @method static Builder|SchedaCriteri whereDescr($value)
 * @method static Builder|SchedaCriteri whereFieldName($value)
 * @method static Builder|SchedaCriteri whereId($value)
 * @method static Builder|SchedaCriteri whereIsEditable($value)
 * @method static Builder|SchedaCriteri wherePeso($value)
 * @method static Builder|SchedaCriteri wherePos($value)
 * @method static Builder|SchedaCriteri whereUpdatedAt($value)
 * @method static Builder|SchedaCriteri whereUpdatedBy($value)
 * @method static Builder|SchedaCriteri withDays(int $date_min, int $date_max)
 *
 * @mixin Builder<self>
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read string $from_field
 * @property-read string $to_field
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|SchedaCriteri ofEnte(int $ente)
 * @method static Builder<static>|SchedaCriteri ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 *
 * @mixin \Eloquent
 */
class SchedaCriteri extends BaseModel
{
    use SigmaModelTrait;

    protected $connection = 'progressione';

    // this will use the specified database connection
    protected $table = 'scheda_criteri';

    public int $n_perf_ind = 3;

    public string $from_field = 'dal';

    public string $to_field = 'al';

    protected function rangeFromField(): string
    {
        return 'dal';
    }

    protected function rangeToField(): string
    {
        return 'al';
    }

    protected function annFieldName(): string
    {
        return 'anno';
    }

    /*
    public $valutaz_fields=['esperienza_acquisita','risultati_ottenuti',
            'arricchimento_professionale','impegno','qualita_prestazione'];
    public array $xls_fields=['ente','matr','cognome','nome','propro','posfun','categoria_ecoval','posfunval','stabi','repar','anno',
            'email','esperienza_acquisita','risultati_ottenuti',
            'arricchimento_professionale','impegno','qualita_prestazione','totale','totale_pond','ha_diritto','motivo'];
    */
    protected $fillable = ['id', 'criterio', 'peso', 'descr', 'is_editable', 'field_name', 'anno', 'pos', 'converted_in'];

    /** @var array<int|string, string> */
    public static $converted_in_opts = [
        '1' => 'max 10 valutatore',
        '2' => 'se stesso',
        '3' => 'da 4 a 10',
        '4' => 'div 10',
        '5' => 'fino 10 anni',
    ];
}
