<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Modules\Ptv\Models\Profile;
use Modules\Sigma\Models\Traits\SigmaModelTrait;

// ----------traits ---
/**
 * Modules\Sigma\Models\Asz00f.
 *
 * @property int $id
 * @property int $ente
 * @property int $cont
 * @property int $matr
 * @property int $asztip
 * @property int $aszcod
 * @property int $aszdal
 * @property int $aszal
 * @property string $aszini
 * @property string $aszfin
 * @property int $aszcom
 * @property int $asztpr
 * @property int $aszdpr
 * @property string $asznpr
 * @property string $aszumi
 * @property string $aszpes
 * @property string $aszdur
 * @property int $asz01
 * @property int $asz02
 * @property int $asz03
 * @property int $asz04
 * @property int $asz05
 * @property string $aszcm
 * @property string $aszcms
 * @property string $asztim
 * @property string $aszpro
 * @property int $aszprv
 * @property string $aszann
 * @property int $asz2kd
 * @property int $asz2ka
 * @property int $asz2kc
 * @property int $asz2kp
 * @property int $asz2kz
 * @property string $aszeup
 * @property string $asztin
 * @property int $asz001
 * @property string $asz002
 * @property string $asz003
 * @property int $asz004
 * @property int $asz005
 * @property-read Codici|null $codici
 * @property-read mixed $aszdescr
 *
 * @method static Builder|Asz00f newModelQuery()
 * @method static Builder|Asz00f newQuery()
 * @method static Builder|Asz00f ofCodici($lista_codici)
 * @method static Builder|Asz00f ofDate(int $date)
 * @method static Builder|Asz00f ofEnteYear(int $ente, int $year)
 * @method static Builder|Asz00f ofQuarter(int $quarter, int $year)
 * @method static Builder|Asz00f ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Asz00f ofYear(int $year)
 * @method static Builder|Asz00f query()
 * @method static Builder|Asz00f whereAsz001($value)
 * @method static Builder|Asz00f whereAsz002($value)
 * @method static Builder|Asz00f whereAsz003($value)
 * @method static Builder|Asz00f whereAsz004($value)
 * @method static Builder|Asz00f whereAsz005($value)
 * @method static Builder|Asz00f whereAsz01($value)
 * @method static Builder|Asz00f whereAsz02($value)
 * @method static Builder|Asz00f whereAsz03($value)
 * @method static Builder|Asz00f whereAsz04($value)
 * @method static Builder|Asz00f whereAsz05($value)
 * @method static Builder|Asz00f whereAsz2ka($value)
 * @method static Builder|Asz00f whereAsz2kc($value)
 * @method static Builder|Asz00f whereAsz2kd($value)
 * @method static Builder|Asz00f whereAsz2kp($value)
 * @method static Builder|Asz00f whereAsz2kz($value)
 * @method static Builder|Asz00f whereAszal($value)
 * @method static Builder|Asz00f whereAszann($value)
 * @method static Builder|Asz00f whereAszcm($value)
 * @method static Builder|Asz00f whereAszcms($value)
 * @method static Builder|Asz00f whereAszcod($value)
 * @method static Builder|Asz00f whereAszcom($value)
 * @method static Builder|Asz00f whereAszdal($value)
 * @method static Builder|Asz00f whereAszdpr($value)
 * @method static Builder|Asz00f whereAszdur($value)
 * @method static Builder|Asz00f whereAszeup($value)
 * @method static Builder|Asz00f whereAszfin($value)
 * @method static Builder|Asz00f whereAszini($value)
 * @method static Builder|Asz00f whereAsznpr($value)
 * @method static Builder|Asz00f whereAszpes($value)
 * @method static Builder|Asz00f whereAszpro($value)
 * @method static Builder|Asz00f whereAszprv($value)
 * @method static Builder|Asz00f whereAsztim($value)
 * @method static Builder|Asz00f whereAsztin($value)
 * @method static Builder|Asz00f whereAsztip($value)
 * @method static Builder|Asz00f whereAsztpr($value)
 * @method static Builder|Asz00f whereAszumi($value)
 * @method static Builder|Asz00f whereCont($value)
 * @method static Builder|Asz00f whereEnte($value)
 * @method static Builder|Asz00f whereId($value)
 * @method static Builder|Asz00f whereMatr($value)
 * @method static Builder|Asz00f withDays(int $date_min, int $date_max)
 * @method static Builder|Asz00f ofEnte(int $ente)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read string $from_field
 * @property-read string $to_field
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Asz00fFactory factory($count = null, $state = [])
 * @method static Builder<static>|Asz00f ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 *
 * @mixin \Eloquent
 */
class Asz00f extends BaseDateRangeModel
{
    use SigmaModelTrait;

    protected $fillable = [
        'id',
        'ente',
        'cont',
        'matr',
        'asztip',
        'aszcod',
        'aszdal',
        'aszal',
        'aszini',
        'aszfin',
        'aszcom',
        'asztpr',
        'aszdpr',
        'asznpr',
        'aszumi',
        'aszpes',
        'aszdur',
        'asz01',
        'asz02',
        'asz03',
        'asz04',
        'asz05',
        'aszcm',
        'aszcms',
        'asztim',
        'aszpro',
        'aszprv',
        'aszann',
        'asz2kd',
        'asz2ka',
        'asz2kc',
        'asz2kp',
        'asz2kz',
        'aszeup',
        'asztin',
        'asz001',
        'asz002',
        'asz003',
        'asz004',
        'asz005',
    ];

    // protected $connection = 'generale'; // this will use the specified database connection
    protected $table = 'asz00f';

    // public $timestamps = false;

    public const FROM_FIELD = 'asz2kd';

    public const TO_FIELD = 'asz2ka';

    public const ANN_FIELD = 'aszann';

    public string $from_field = 'asz2kd';

    public string $to_field = 'asz2ka';

    public function rangeFromField(): string
    {
        return 'asz2kd';
    }

    public function rangeToField(): string
    {
        return 'asz2ka';
    }

    public function annFieldName(): string
    {
        return 'aszann';
    }

    /**
     * @return HasOne<Codici, $this>
     */
    public function codici(): HasOne
    {
        // echo $obj->toSql();
        return $this->hasOne(Codici::class, 'tipo', 'asztip')->where('codice', $this->aszcod);
    }

    // end class codici

    // ----  mutators ---
    protected function getAszdescrAttribute(): ?string
    {
        $codici = $this->codici;

        if (! is_object($codici)) {
            return null;
        }

        return $codici->desc1;
    }

    // ------ SCOPES --------
    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    protected function scopeWithDays(Builder $query, ?int $date_min, ?int $date_max): Builder
    {
        if ($date_min === null || $date_max === null) {
            return $query;
        }

        return $query->selectRaw(
            'greatest(datediff(if(asz2ka=0 or asz2ka>?, ?, asz2ka), if(asz2kd<?, ?, asz2kd))+1, 0) AS days',
            [$date_max, $date_max, $date_min, $date_min],
        );
    }

    /**
     * @param  Builder<self>  $query
     * @param  array<int, string>|string  $lista_codici
     * @return Builder<self>
     */
    protected function scopeOfCodici(Builder $query, array|string $lista_codici = []): Builder
    {
        if (\is_array($lista_codici)) {
            $lista_codici = implode(',', array_map(static fn (mixed $codice): string => (string) $codice, $lista_codici));
        }

        return $query->whereRaw('find_in_set(concat(asztip,"-",aszcod), ?)', [$lista_codici]);
    }

    /*
     * public function scopeOfYear(Builder $query, int $year):Builder {
     * return $query;
     * }
     */
    public function xls(): string
    {
        return 'aaaa';
    }

    public static function xlsStatic(): string
    {
        return 'bbbb';
    }

    /**
     * The "booted" method of the model.
     */
    #[\Override]
    protected static function booted(): void
    {
        static::addGlobalScope('ann', static function (Builder $builder) {
            $builder->where('aszann', '');
        });
    }
}

// end class asz00f
