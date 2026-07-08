<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Date;
use Modules\Progressioni\Models\CategoriaPropro;
use Modules\Sigma\Models\Traits\Extras\FunctionExtra;

/**
 * Modules\Sigma\Models\Qua00f.
 *
 * @property int $id
 * @property int $ente
 * @property int $cont
 * @property int $matr
 * @property int $tipco
 * @property int $rapp
 * @property int $ruolo
 * @property int $propro
 * @property int $posfun
 * @property int $codqua
 * @property int $qudal
 * @property int $qual
 * @property int $quanz
 * @property int $posiz
 * @property int $sipco
 * @property int $sapp
 * @property int $suolo
 * @property int $sropro
 * @property int $sosfun
 * @property int $sodqua
 * @property int $annise
 * @property int $prvtip
 * @property int $prvdat
 * @property string $prvnum
 * @property int $datpas
 * @property string $serviz
 * @property int $disci1
 * @property int $disci2
 * @property string $oree
 * @property string $oret
 * @property int $aapens
 * @property string $quaann
 * @property int $qua2kd
 * @property int $qua2ka
 * @property int $qua2kz
 * @property string|null $propro_sup
 * @property int $prv2kd
 * @property int $dat2kp
 * @property int $qua001
 * @property string $qua002
 * @property string $qua003
 * @property int $qua004
 * @property int $qua005
 * @property Ana10f|null $ana10f
 * @property Collection<int, Ana02f> $ana02f
 * @property Collection<int, Dipt00f> $dipt00f
 * @property int|null $dipt00f_count
 * @property mixed $categoria_eco
 * @property string|null $cognome
 * @property string|null $email
 * @property string $from_field
 * @property string|null $nome
 * @property string|null $posizione_eco
 * @property string $to_field
 * @property mixed $turno
 * @property Tqu00f|null $tqu00f
 *
 * @method static Builder|Qua00f newModelQuery()
 * @method static Builder|Qua00f newQuery()
 * @method static Builder|Qua00f ofDate(int $date)
 * @method static Builder|Qua00f ofEnteYear(int $ente, int $year)
 * @method static Builder|Qua00f ofPosiz(?mixed $posiz)
 * @method static Builder|Qua00f ofQuarter(int $quarter, int $year)
 * @method static Builder|Qua00f ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Qua00f ofYear(int $year)
 * @method static Builder|Qua00f query()
 * @method static Builder|Qua00f whereAapens($value)
 * @method static Builder|Qua00f whereAnnise($value)
 * @method static Builder|Qua00f whereCodqua($value)
 * @method static Builder|Qua00f whereCont($value)
 * @method static Builder|Qua00f whereDat2kp($value)
 * @method static Builder|Qua00f whereDatpas($value)
 * @method static Builder|Qua00f whereDisci1($value)
 * @method static Builder|Qua00f whereDisci2($value)
 * @method static Builder|Qua00f whereEnte($value)
 * @method static Builder|Qua00f whereId($value)
 * @method static Builder|Qua00f whereMatr($value)
 * @method static Builder|Qua00f whereOree($value)
 * @method static Builder|Qua00f whereOret($value)
 * @method static Builder|Qua00f wherePosfun($value)
 * @method static Builder|Qua00f wherePosiz($value)
 * @method static Builder|Qua00f wherePropro($value)
 * @method static Builder|Qua00f wherePrv2kd($value)
 * @method static Builder|Qua00f wherePrvdat($value)
 * @method static Builder|Qua00f wherePrvnum($value)
 * @method static Builder|Qua00f wherePrvtip($value)
 * @method static Builder|Qua00f whereQua001($value)
 * @method static Builder|Qua00f whereQua002($value)
 * @method static Builder|Qua00f whereQua003($value)
 * @method static Builder|Qua00f whereQua004($value)
 * @method static Builder|Qua00f whereQua005($value)
 * @method static Builder|Qua00f whereQua2ka($value)
 * @method static Builder|Qua00f whereQua2kd($value)
 * @method static Builder|Qua00f whereQua2kz($value)
 * @method static Builder|Qua00f whereQuaann($value)
 * @method static Builder|Qua00f whereQual($value)
 * @method static Builder|Qua00f whereQuanz($value)
 * @method static Builder|Qua00f whereQudal($value)
 * @method static Builder|Qua00f whereRapp($value)
 * @method static Builder|Qua00f whereRuolo($value)
 * @method static Builder|Qua00f whereSapp($value)
 * @method static Builder|Qua00f whereServiz($value)
 * @method static Builder|Qua00f whereSipco($value)
 * @method static Builder|Qua00f whereSodqua($value)
 * @method static Builder|Qua00f whereSosfun($value)
 * @method static Builder|Qua00f whereSropro($value)
 * @method static Builder|Qua00f whereSuolo($value)
 * @method static Builder|Qua00f whereTipco($value)
 * @method static Builder|Qua00f withDays(int $date_min, int $date_max)
 * @method static Builder|Qua00f withPercPtime()
 * @method static Builder|Qua00f ofEnte(int $ente)
 *
 * @property-read int|null $ana02f_count
 *
 * @method static Builder<static>|Qua00f ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 *
 * @property-read Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 *
 * @mixin \Eloquent
 */
class Qua00f extends BaseDateRangeModel
{
    // use SigmaModelTrait;
    use FunctionExtra;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'id',
        'ente',
        'cont',
        'matr',
        'tipco',
        'rapp',
        'ruolo',
        'propro',
        'posfun',
        'codqua',
        'qudal',
        'qual',
        'quanz',
        'posiz',
        'sipco',
        'sapp',
        'suolo',
        'sropro',
        'sosfun',
        'sodqua',
        'annise',
        'prvtip',
        'prvdat',
        'prvnum',
        'datpas',
        'serviz',
        'disci1',
        'disci2',
        'oree',
        'oret',
        'aapens',
        'quaann',
        'qua2kd',
        'qua2ka',
        'qua2kz',
        'prv2kd',
        'dat2kp',
        'qua001',
        'qua002',
        'qua003',
        'qua004',
        'qua005',
    ];

    protected $table = 'qua00f';

    // -----------------------------------------------
    public const FROM_FIELD = 'qua2kd';

    public const TO_FIELD = 'qua2ka';

    public const ANN_FIELD = 'quaann';

    public static string $from_field = 'qua2kd';

    public static string $to_field = 'qua2ka';

    public static string $ann_field = 'quaann';

    public function rangeFromField(): string
    {
        return 'qua2kd';
    }

    public function rangeToField(): string
    {
        return 'qua2ka';
    }

    public function annFieldName(): string
    {
        return 'quaann';
    }

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'qua2kd' => 'integer',
            'qua2ka' => 'integer',
        ];
    }

    /*
     * DIPT00F
     * where (dtannu="" or dtannu is null)
     * and DIPT00F.enteap=tipiorari_tmp.ente
     * and DIPT00F.dtmatr=tipiorari_tmp.matr
     */
    /**
     * @return HasMany<Dipt00f, Qua00f>
     */
    public function dipt00f(): HasMany
    {
        $qua2kd = (int) ($this->qua2kd ?? 0);
        $qua2ka = (int) ($this->qua2ka ?? 0);
        $dipt = new Dipt00f;

        /** @var HasMany<Dipt00f, Qua00f> $relation */
        $relation = $this->hasMany(Dipt00f::class, $dipt->matrField(), $this->matrField())
            ->where($dipt->enteField(), $this->{$this->enteField()})
            ->where('dtannu', '');

        if ($qua2ka === 0) {
            $relation->whereRaw(
                '((? between dtdal and dtal) or (? >= dtdal and dtal = 0) or (dtdal >= ?))',
                [$qua2kd, $qua2kd, $qua2kd],
            );
        } else {
            $relation->whereRaw(
                '((? between dtdal and dtal) or (? >= dtdal and dtal = 0) or (dtdal between ? and ?))',
                [$qua2kd, $qua2kd, $qua2kd, $qua2ka],
            );
        }

        return $relation;
    }

    /**
     * @return HasOne<Tqu00f, Qua00f>
     */
    public function tqu00f(): HasOne
    {
        /** @var HasOne<Tqu00f, Qua00f> $relation */
        $relation = $this->hasOne(Tqu00f::class, 'propro', 'propro')
            ->where('posfun', $this->posfun)
            ->where('codqua', $this->codqua)
            ->where('cont', $this->cont)
            ->where('tipco', $this->tipco)
            ->where('ruolo', $this->ruolo)
            ->where('tqann', '');

        return $relation;
    }

    /**
     * @return HasOne<Ana10f, Qua00f>
     */
    public function ana10f(): HasOne
    {
        /** @var HasOne<Ana10f, Qua00f> $relation */
        $relation = $this->hasOneByEnteMatr(Ana10f::class);

        return $relation;
    }

    /**
     * @return HasMany<Ana02f, Qua00f>
     */
    public function ana02f(): HasMany
    {
        /** @var HasMany<Ana02f, Qua00f> $relation */
        $relation = $this->hasManyByEnteMatr(Ana02f::class);

        return $relation;
    }

    /**
     * @return HasMany<Rep00f, Qua00f>
     */
    public function rep00f(): HasMany
    {
        /** @var HasMany<Rep00f, Qua00f> $relation */
        $relation = $this->hasManyByEnteMatr(Rep00f::class)
            ->where('repann', '')
            ->ofRangeDate($this->qua2kd, $this->qua2ka);

        return $relation;
    }

    public function categoriaProproProgressione(): void
    {
        dddx('aa');
    }

    // ------ SCOPES --------
    protected function scopeOfYear(Builder $query, ?int $year): Builder
    {
        return $query->where(static function (Builder $q) use ($year): void {
            $q->whereRaw('(? between year(qua2kd) and year(qua2ka))', [$year])
                ->orWhereRaw('(? >= year(qua2kd) and qua2ka = 0)', [$year]);
        });
    }

    protected function scopeOfEnteYear(Builder $query, ?int $ente, ?int $year): Builder
    {
        return $query
            ->where('ente', $ente)
            ->where('quaann', '')
            ->where(static function (Builder $q) use ($year): void {
                $q->whereRaw('(? between year(qua2kd) and year(qua2ka))', [$year])
                    ->orWhereRaw('(? >= year(qua2kd) and qua2ka = 0)', [$year]);
            });
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    protected function scopeWithDays(Builder $query, int $date_min, int $date_max): Builder
    {
        return $query->selectRaw(
            '*, greatest(datediff(if(qua2ka=0 or qua2ka>?, ?, qua2ka), if(qua2kd<?, ?, qua2kd))+1, 0) AS days',
            [$date_max, $date_max, $date_min, $date_min],
        );
    }

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    protected function scopeWithPercPtime(Builder $query): Builder
    {
        $perc = 'if(oree=0,36,oree)/if(oret=0,36,oret)';

        return $query->selectRaw($perc.' AS perc_ptime');
    }

    /*
     * public function scopeOfCategoriaEcoProgressione(): void {
     * $query->whereHas('categoria_eco_progressione',function (){
     *
     * })
     * }
     */
    /**
     * Filter records by posiz field.
     *
     * @param  Builder<self>  $query
     * @param  array<int|string, mixed>|int|string|null  $posiz
     * @return Builder<self>
     */
    protected function scopeOfPosiz(Builder $query, array|int|string|null $posiz): Builder
    {
        if ($posiz === null) {
            return $query;
        }

        if (! \is_array($posiz)) {
            /** @var array<int, int> $posiz */
            $posiz = \array_map('intval', \explode(',', (string) $posiz));
        }

        return $query->whereIn('posiz', $posiz);
    }

    // ---------------------------------------------------------------------
    /**
     * @param  array<int|string, mixed>|null  $params
     */
    public static function last_qua00f(?array $params = null): ?self
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        // echo '<pre>';print_r('last_propro');echo '</pre>'; die();
        // $qua00f=Qua00f::where('ente',$params['ente'])
        // $qua00f=self::where('ente',$params['ente'])
        $qua00f = self::where('ente', $params['ente'])
            ->where('matr', $params['matr'])
            ->orderBy('qua2kd', 'desc')
            ->first();

        return $qua00f;
    }

    // ------------------------------------------------------------

    /**
     * @param  array<int|string, mixed>|null  $params
     */
    public function gg(?array $params = null): float
    {
        // dddx($params);
        if ($params === null) {
            $params = getRouteParameters();
        }

        $date_min = $params['date_min'] ?? null;
        $date_max = $params['date_max'] ?? null;
        $propro = $params['propro'] ?? null;
        $categoria_eco = $params['categoria_eco'] ?? null;
        $lista_propro_sup = $params['lista_propro_sup'] ?? null;
        $lista_propro = $params['lista_propro'] ?? null;
        $posfun = $params['posfun'] ?? null;

        // if (! isset($date_min)) { // non e' obbligatorio
        //    throw new \Exception('!isset($date_min)');
        // }
        /*dddx(
         * [
         * 'class' => get_class($this),
         * 'qua2ka' => $this->attributes['qua2ka'],
         * ]
         * );*/
        if (! isset($date_max)) {
            throw new \Exception('!isset($date_max) ['.__LINE__.']['.class_basename(self::class).']');
        }

        if ($date_max instanceof Carbon) {
            $date_max = $date_max->format('Ymd') * 1;
        }

        if (isset($propro) && $propro !== $this->attributes['propro']) {
            return 0;
        }

        if (isset($categoria_eco) && $categoria_eco > $this->categoria_eco) {
            // caso mattara che era d poi tornata c
            return 0;
        }

        // dddx($lista_propro_sup);//"718,707"
        $is_propro_sup = false;
        if (isset($lista_propro_sup)) {
            if (! is_string($lista_propro_sup)) {
                throw new \InvalidArgumentException('lista_propro_sup must be string');
            }

            /** @var list<int> $array_propro_sup */
            $array_propro_sup = \array_map('intval', \explode(',', $lista_propro_sup));
            if (\in_array($this->attributes['propro'], $array_propro_sup, false)) {
                $is_propro_sup = true;
            }
        }

        if (isset($lista_propro)) {
            if (! is_string($lista_propro)) {
                throw new \InvalidArgumentException('lista_propro must be string');
            }

            /** @var list<int> $array_propro */
            $array_propro = \array_map('intval', \explode(',', $lista_propro));
            if (! \in_array($this->attributes['propro'], $array_propro, false) && ! $is_propro_sup) {
                return 0;
            }

            if (! $is_propro_sup && isset($posfun)) {
                if (! is_numeric($posfun)) {
                    throw new \InvalidArgumentException('posfun must be numeric');
                }

                $posfunInt = (int) $posfun;
                $modelPosfunInt = (int) $this->posfun;

                if ($posfunInt % 10 !== $modelPosfunInt % 10) {
                    return 0;
                }
            }
        }

        // caso bollini che era d poi tornata c
        // echo '<hr/>['.$categoria_eco.']['.$this->categoria_eco.']';
        if (isset($categoria_eco) && $categoria_eco >= $this->categoria_eco && isset($posfun)) {
            if (! is_numeric($posfun)) {
                throw new \InvalidArgumentException('posfun must be numeric');
            }

            $posfunInt = (int) $posfun;
            $modelPosfunInt = (int) $this->posfun;

            if ($posfunInt % 10 !== $modelPosfunInt % 10) {
                return 0;
            }
        }

        try {
            $qua2kdRaw = $this->attributes['qua2kd'] ?? null;
            if (! is_numeric($qua2kdRaw)) {
                throw new \InvalidArgumentException('qua2kd must be numeric');
            }
            /** @var numeric-string $qua2kdStr */
            $qua2kdStr = (string) $qua2kdRaw;
            $date_from = Date::createFromFormat('Ymd H:i', $qua2kdStr.' 00:00');
            if (! $date_from instanceof Carbon) {
                throw new \Exception('Invalid qua2kd format ['.__LINE__.']['.class_basename(self::class).']');
            }
        } catch (\Exception $e) {
            throw new \Exception('Invalid qua2kd format ['.__LINE__.']['.class_basename(self::class).']: '.$e->getMessage(), $e->getCode(), $e);
        }
        if (isset($date_min) && is_numeric($date_min) && $this->attributes['qua2kd'] < (int) $date_min) {
            // $date_from = new Carbon($date_min.'');
            try {
                /** @var numeric-string $dateMinStr */
                $dateMinStr = (string) $date_min;
                $date_from = Date::createFromFormat('Ymd H:i', $dateMinStr.' 00:00');
                if (! $date_from instanceof Carbon) {
                    throw new \Exception('Invalid date_min format ['.__LINE__.']['.class_basename(self::class).']');
                }
            } catch (\Exception $e) {
                throw new \Exception('Invalid date_min format ['.__LINE__.']['.class_basename(self::class).']: '.$e->getMessage(), $e->getCode(), $e);
            }
        }

        if (
            $this->attributes['qua2ka'] === 0
            || is_numeric($date_max) && $this->attributes['qua2ka'] > (int) $date_max
        ) {
            if ($date_max instanceof Carbon) {
                $date_to = $date_max;
            } else {
                try {
                    if (! is_numeric($date_max)) {
                        throw new \InvalidArgumentException('date_max must be numeric');
                    }
                    $dateMaxStr = (string) $date_max;
                    $date_to = Date::createFromFormat('Ymd H:i', $dateMaxStr.' 00:00');
                    if (! $date_to instanceof Carbon) {
                        throw new \Exception('Invalid date_max format ['.__LINE__.']['.class_basename(self::class).']');
                    }
                } catch (\Exception $e) {
                    throw new \Exception('Invalid date_max format ['.__LINE__.']['.class_basename(self::class).']: '.$e->getMessage(), $e->getCode(), $e);
                }
            }

            // $date_to = new Carbon($date_max.'');
        } else {
            // $date_to = new Carbon($this->attributes['qua2ka']);
            try {
                $qua2kaRaw = $this->attributes['qua2ka'] ?? null;
                if (! is_numeric($qua2kaRaw)) {
                    throw new \InvalidArgumentException('qua2ka must be numeric');
                }
                /** @var numeric-string $qua2kaStr */
                $qua2kaStr = (string) $qua2kaRaw;
                $date_to = Date::createFromFormat('Ymd H:i', $qua2kaStr.' 00:00');
                if (! $date_to instanceof Carbon) {
                    throw new \Exception('Invalid qua2ka format ['.__LINE__.']['.class_basename(self::class).']');
                }
            } catch (\Exception $e) {
                dddx([
                    'message' => $e->getMessage(),
                    'qua2ka' => $this->attributes['qua2ka'],
                ]);
                $date_to = Date::now();
            }
        }

        // $st2kdi=new Carbon('19870202');
        if ($date_from > $date_to) {
            return 0;
        }

        // dddx(['params'=>$params,'date_from'=>$date_from,'date_to'=>$date_to,'res'=>$res]);
        return $date_to->diffInDays($date_from, true) + 1;
    }

    // ----------------------------------------------------------

    // /-----------------------------------------------------------
    /**
     * @param  array<mixed>|null  $params
     */
    public function giorni(?array $params = null): int|float
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        if (! isset($params['anno']) || ! is_numeric($params['anno'])) {
            throw new \Exception('anno is not defined or invalid ['.__LINE__.']['.class_basename(self::class).']');
        }

        try {
            $qua2kdRaw = $this->attributes['qua2kd'] ?? null;
            if (! is_numeric($qua2kdRaw)) {
                throw new \InvalidArgumentException('qua2kd must be numeric');
            }
            /** @var numeric-string $qua2kdStr */
            $qua2kdStr = (string) $qua2kdRaw;
            $carbon = Date::createFromFormat('Ymd', $qua2kdStr);
            if (! $carbon instanceof Carbon) {
                throw new \Exception('Invalid qua2kd format ['.__LINE__.']['.class_basename(self::class).']');
            }
        } catch (\Exception $e) {
            throw new \Exception('Invalid qua2kd format ['.__LINE__.']['.class_basename(self::class).']: '.$e->getMessage(), $e->getCode(), $e);
        }
        try {
            $al = $this->attributes['qua2ka'] === 0
                ? Date::createFromFormat('Ymd', $params['anno'].'1231')
                : null;
            if ($al === null) {
                $qua2kaRaw = $this->attributes['qua2ka'] ?? null;
                if (! is_numeric($qua2kaRaw)) {
                    throw new \InvalidArgumentException('qua2ka must be numeric');
                }
                /** @var numeric-string $qua2kaStr */
                $qua2kaStr = (string) $qua2kaRaw;
                $al = Date::createFromFormat('Ymd', $qua2kaStr);
            }
            if (! $al instanceof Carbon) {
                throw new \Exception('Invalid date format ['.__LINE__.']['.class_basename(self::class).']');
            }
        } catch (\Exception $e) {
            throw new \Exception('Invalid date format ['.__LINE__.']['.class_basename(self::class).']: '.$e->getMessage(), $e->getCode(), $e);
        }
        // $st2kdi=new Carbon('19870202');

        return $al->diffInDays($carbon, true) + 1;
    }

    /**
     * @param  array<int|string, mixed>|null  $params
     */
    public function giorni_propro(?array $params = null): int|float
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        if (! isset($params['propro'])) {
            // $obj=clone($this)->first();
            // echo '<pre>';print_r($this->first()->toArray());echo '</pre>';
            // $obj=$obj->orderBy('qua2kd','desc')

            // echo '<pre>';print_r($obj->propro);echo '</pre>';
            // die('['.__LINE__.']');
            $last = static::last_qua00f();
            if (! $last instanceof Qua00f) {
                return 0;
            }
            $params['propro'] = $last->propro;

            // $params['propro']=$obj->propro;
        }

        if ($this->propro === $params['propro']) {
            return $this->giorni($params);
        }

        return 0;
    }

    /**
     * @param  array<string, mixed>|null  $params
     */
    public function giorni_propro_posfun(?array $params = null): int|float
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        $last = static::last_qua00f();
        if (! $last instanceof Qua00f) {
            return 0;
        }

        if (! isset($params['propro'])) {
            $params['propro'] = $last->propro;
        }

        if (! isset($params['posfun'])) {
            $params['posfun'] = $last->posfun;
        }

        if ($this->propro !== $params['propro']) {
            return 0;
        }
        if ($this->posfun !== $params['posfun']) {
            return 0;
        }

        return $this->giorni($params);
    }

    // -------------- MUTATORS ---------------
    /*
     * public function getQua2kdAttribute(): void {
     *
     * if(!is_object($value)){
     * $value=Carbon::parse($value);
     * }
     * return $value;
     * }
     *
     * public function getQua2kaAttribute(): void {
     * if($value==0) return $value;
     * if(!is_object($value)){
     * $value=Carbon::parse($value);
     * }
     * return $value;
     * }
     */

    protected function getFromFieldAttribute(?string $value): string
    {
        return 'qua2kd';
    }

    protected function getToFieldAttribute(?string $value): string
    {
        return 'qua2ka';
    }

    protected function getCognomeAttribute(?string $value): ?string
    {
        if (! $this->ana10f instanceof Ana10f) {
            return '---';
        }

        return $this->ana10f->conome;
    }

    protected function getNomeAttribute(?string $value): ?string
    {
        if (! $this->ana10f instanceof Ana10f) {
            // dddx($this); //4debug
            return '---';
        }

        return $this->ana10f->nome;
    }

    protected function getEmailAttribute(?string $value): ?string
    {
        $ana02f = $this->ana02f;
        if ($ana02f->isEmpty()) {
            // dddx($this); //4debug
            return '---';
        }

        $last = $ana02f->where('emaind', '!=', '')->last();
        if ($last === null || ! isset($last->emaind)) {
            return '---';
        }

        /** @var string $email */
        $email = $last->emaind;

        return $email;
    }

    protected function getTurnoAttribute(): string
    {
        $dipt00f = $this->dipt00f;
        if ($dipt00f->isEmpty()) {
            return 'Aggiornare tabella dipt00f';
        }

        $first = $dipt00f->first();
        if (! isset($first->dtturn)) {
            return 'Aggiornare tabella dipt00f';
        }

        /** @var string $turn */
        $turn = $first->dtturn;

        return $turn;
    }

    /**
     * { item_description }.
     */
    protected function getCategoriaEcoAttribute(): ?string
    {
        // *
        $row = CategoriaPropro::whereRaw('find_in_set(?, lista_propro)', [$this->propro])->first();
        if ($row === null) {
            echo '<h3>Aggiungi propro['.$this->propro.'] a CategoriaPropro</h3>';
            exit('['.__LINE__.']['.__FILE__.']');
        }

        return $row->categoria;

        // */
        /*
         * $pos_eco=trim($this->posizione_eco);
         * $cat_eco=substr($pos_eco,0,1);
         * if(!in_array($cat_eco,['A','B','C','D'])){
         * switch($this->propro){
         * case 700: return 'PREC';
         * case 703: return 'A';
         * case 704: return 'B';
         * case 705: return 'B3';
         *
         * }
         * dddx($this->propro.' '.$pos_eco);
         * }
         * return $cat_eco;
         */
    }

    protected function getPosizioneEcoAttribute(?string $value): ?string
    {
        $tqu00f = $this->tqu00f;
        if ($tqu00f === null || ! isset($tqu00f->desc1)) {
            return null;
        }

        $txt = (string) $tqu00f->desc1;

        return str_replace('Posizione economica ', '', $txt);
    }

    /**
     * @param  array<string, mixed>  $params
     * @return \Illuminate\Support\Collection<string, array<string, mixed>>
     */
    public static function posizioniEconomicheOfYearCollection(array $params): \Illuminate\Support\Collection
    {
        if (! isset($params['anno']) || ! is_numeric($params['anno'])) {
            throw new \Exception('anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        if (! isset($params['ente']) || ! is_numeric($params['ente'])) {
            throw new \Exception('ente is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $anno = (int) $params['anno'];
        $ente = (int) $params['ente'];

        $qua00f = self::query()
            ->ofYear($anno)
            ->where('quaann', '')
            ->where('ente', $ente)
            ->get();
        $group_by = ['ente', 'matr', 'propro', 'posfun', 'posiz', 'disci1'];

        /** @var \Illuminate\Support\Collection<int, array<string, mixed>> $qua00f_coll */
        $qua00f_coll = collect($qua00f->toArray())->map(static function (mixed $item) use ($anno, $group_by): array {
            if (! is_array($item)) {
                throw new \Exception('Invalid item type ['.__LINE__.']['.class_basename(self::class).']');
            }
            $tmp = new \stdClass;
            foreach ($group_by as $v) {
                $tmp->$v = $item[$v];
            }

            /*
             $tmp->ente      =$item['ente'];
             $tmp->matr      =$item['matr'];
             $tmp->propro     =$item['propro'];
             $tmp->posfun      =$item['posfun'];
             $tmp->posiz      =$item['posiz'];
             */
            $tmp->qua2kd = $item['qua2kd'];
            $tmp->qua2ka = $item['qua2ka'];
            // $tmp->posiz=$item['posiz']; //per tempo determinato o inde.. etc mi interessa collassare le righe
            // $tmp->disci1=$item['disci1']; //regionali etc
            $tmp->anno = $anno;

            return get_object_vars($tmp);
        });
        $qua00f_coll = $qua00f_coll->groupBy(static function (array $item) use ($group_by): string {
            /* .'-'.$item['posiz'] */
            // return $item['ente'].'-'.$item['matr'].'-'.$item['propro'].'-'.$item['posfun'].'-'.$item['disci1'];
            // *
            $tmp = [];
            foreach ($group_by as $v) {
                $tmp[] = (string) ($item[$v] ?? '');
            }

            return implode('-', $tmp);

            // */
        });

        /** @var \Illuminate\Support\Collection<string, array<string, mixed>> $result */
        $result = $qua00f_coll->map(static function (\Illuminate\Support\Collection $item) use ($group_by): array {
            /** @var array<string, mixed> $firstItem */
            $firstItem = $item->first();
            $ris = [];
            /*
             $ris['ente']=$firstItem['ente'];
             $ris['matr']=$firstItem['matr'];
             $ris['propro']=$firstItem['propro'];
             $ris['posfun']=$firstItem['posfun'];
             $ris['disci1']=$firstItem['disci1'];
             */
            foreach ($group_by as $v) {
                if (! isset($firstItem[$v])) {
                    throw new \Exception("Missing key {$v} in first item [".__LINE__.']['.class_basename(self::class).']');
                }
                $ris[$v] = $firstItem[$v];
            }
            // --- da aggiungere il controllo se non ci sono "buchi" in mezzo
            /** @var array<string, mixed>|null $firstKd */
            $firstKd = $item->sortBy('qua2kd')->first();
            /** @var array<string, mixed>|null $firstKa */
            $firstKa = $item->sortByDesc('qua2kd')->first();
            if (! is_array($firstKd) || ! isset($firstKd['qua2kd'])) {
                throw new \Exception('Invalid qua2kd ['.__LINE__.']['.class_basename(self::class).']');
            }
            if (! is_array($firstKa) || ! isset($firstKa['qua2ka'])) {
                throw new \Exception('Invalid qua2ka ['.__LINE__.']['.class_basename(self::class).']');
            }
            $ris['qua2kd'] = $firstKd['qua2kd'];
            $ris['qua2ka'] = $firstKa['qua2ka'];
            // $ris['posiz']=$firstItem['posiz']; // mi interessa collassare le righe
            if (! isset($firstItem['anno'])) {
                throw new \Exception('Missing anno in first item ['.__LINE__.']['.class_basename(self::class).']');
            }
            $ris['anno'] = $firstItem['anno'];

            return $ris;
        });

        return $result;
    }

    /*
     * https://dev.to/bertheyman/the-magic-of-query-scopes-in-laravel-pfp
     *
     *
     * protected static function boot()
     * {
     * parent::boot();
     *
     * // A global scope is applied to all queries on this model
     * // -> No need to specify visibility restraints on every query
     * static::addGlobalScope('visible', function (Builder $query) {
     * $query->where('visible', 1);
     * });
     * // Bonus: if multiple models are hideable, this behaviour might
     * // belong in a specific scope for easy reuse
     * }
     *
     */
}
