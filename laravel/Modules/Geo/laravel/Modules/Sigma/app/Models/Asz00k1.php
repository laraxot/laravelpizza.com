<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Date;
use Modules\Sigma\Models\Traits\Extras\FunctionExtra;

/**
 * Modules\Sigma\Models\Asz00k1.
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
 * @property Codici|null $codici
 * @property string $ann
 * @property mixed $aszdescr
 * @property string $from_field
 * @property mixed $posfun
 * @property string|null $posizione_eco
 * @property mixed $propro
 * @property string $to_field
 * @property Collection<int, Qua00f> $qua00f
 * @property int|null $qua00f_count
 * @property Collection<int, Qua00f> $qua00fsimple
 * @property int|null $qua00fsimple_count
 *
 * @method static Builder|Asz00k1 newModelQuery()
 * @method static Builder|Asz00k1 newQuery()
 * @method static Builder|Asz00k1 ofCodici($lista_codici)
 * @method static Builder|Asz00k1 ofDate(int $date)
 * @method static Builder|Asz00k1 ofEnteYear(int $ente, int $year)
 * @method static Builder|Asz00k1 ofListaProproPosfun($lista_propro, $posfun = null)
 * @method static Builder|Asz00k1 ofListaTipoCodice(string $lista_tipo_codice)
 * @method static Builder|Asz00k1 ofQuarter(int $quarter, int $year)
 * @method static Builder|Asz00k1 ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Asz00k1 ofYear(int $year)
 * @method static Builder|Asz00k1 query()
 * @method static Builder|Asz00k1 whereAsz001($value)
 * @method static Builder|Asz00k1 whereAsz002($value)
 * @method static Builder|Asz00k1 whereAsz003($value)
 * @method static Builder|Asz00k1 whereAsz004($value)
 * @method static Builder|Asz00k1 whereAsz005($value)
 * @method static Builder|Asz00k1 whereAsz01($value)
 * @method static Builder|Asz00k1 whereAsz02($value)
 * @method static Builder|Asz00k1 whereAsz03($value)
 * @method static Builder|Asz00k1 whereAsz04($value)
 * @method static Builder|Asz00k1 whereAsz05($value)
 * @method static Builder|Asz00k1 whereAsz2ka($value)
 * @method static Builder|Asz00k1 whereAsz2kc($value)
 * @method static Builder|Asz00k1 whereAsz2kd($value)
 * @method static Builder|Asz00k1 whereAsz2kp($value)
 * @method static Builder|Asz00k1 whereAsz2kz($value)
 * @method static Builder|Asz00k1 whereAszal($value)
 * @method static Builder|Asz00k1 whereAszann($value)
 * @method static Builder|Asz00k1 whereAszcm($value)
 * @method static Builder|Asz00k1 whereAszcms($value)
 * @method static Builder|Asz00k1 whereAszcod($value)
 * @method static Builder|Asz00k1 whereAszcom($value)
 * @method static Builder|Asz00k1 whereAszdal($value)
 * @method static Builder|Asz00k1 whereAszdpr($value)
 * @method static Builder|Asz00k1 whereAszdur($value)
 * @method static Builder|Asz00k1 whereAszeup($value)
 * @method static Builder|Asz00k1 whereAszfin($value)
 * @method static Builder|Asz00k1 whereAszini($value)
 * @method static Builder|Asz00k1 whereAsznpr($value)
 * @method static Builder|Asz00k1 whereAszpes($value)
 * @method static Builder|Asz00k1 whereAszpro($value)
 * @method static Builder|Asz00k1 whereAszprv($value)
 * @method static Builder|Asz00k1 whereAsztim($value)
 * @method static Builder|Asz00k1 whereAsztin($value)
 * @method static Builder|Asz00k1 whereAsztip($value)
 * @method static Builder|Asz00k1 whereAsztpr($value)
 * @method static Builder|Asz00k1 whereAszumi($value)
 * @method static Builder|Asz00k1 whereCont($value)
 * @method static Builder|Asz00k1 whereEnte($value)
 * @method static Builder|Asz00k1 whereId($value)
 * @method static Builder|Asz00k1 whereMatr($value)
 * @method static Builder|Asz00k1 withDays(int $date_min, int $date_max)
 * @method static Builder|Asz00k1 ofEnte(int $ente)
 * @method static Builder<static>|Asz00k1 ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 *
 * @mixin \Eloquent
 */
class Asz00k1 extends BaseDateRangeModel
{
    // use SigmaModelTrait;
    use FunctionExtra;

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

    // protected $table = 'asz00k1';
    protected $table = 'asz00f'; // !!! finche' abbiamo solo questa tabella da webservice

    // -------------------------------------------------------------------------
    public const FROM_FIELD = 'asz2kd';

    public const TO_FIELD = 'asz2ka';

    public const ANN_FIELD = 'aszann';

    public static string $from_field = 'asz2kd';

    public static string $to_field = 'asz2ka';

    public static string $ann_field = 'aszann';

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

    // -------------------------------------------------------------------------

    /**
     * @return HasOne<Codici, $this>
     */
    public function codici(): HasOne
    {
        // echo $obj->toSql();
        return $this->hasOne(Codici::class, 'tipo', 'asztip')->where('codice', $this->aszcod);
    }

    // end class codici
    // ------------------------------------------------------------
    /**
     * @return HasMany<Qua00f, $this>
     */
    public function qua00fsimple(): HasMany
    {
        $table = (new Qua00f)->getTable();

        return $this->hasManyByEnteMatr(Qua00f::class)
            ->where($table.'.quaann', '')
            ->select(['id', 'matr', 'ente', 'qua2kd', 'qua2ka', 'propro', 'posfun', 'posiz']);
    }

    /**
     * @return HasMany<Qua00f, $this>
     */
    public function qua00f(): HasMany
    {
        $table = (new Qua00f)->getTable();

        return $this->hasManyByEnteMatr(Qua00f::class)
            ->where($table.'.quaann', '');
    }

    /**
     * @param  Builder<Asz00k1>  $query0
     * @return Builder<Asz00k1>
     */
    protected function scopeOfListaProproPosfun(
        Builder $query0,
        string $lista_propro,
        ?string $posfun = null,
    ): Builder {
        // dddx($this);
        // dddx($query0);
        /*
         * return $query0->whereHas('qua00fsimple',function ($query) use($query0){
         * //dddx($query0);
         * $query->where('ente',$this->ente);
         * $sql='(
         * (
         * ('.$this->asz2kd.' between qua2kd and qua2ka) or
         * ('.$this->asz2kd.' >= qua2kd and qua2ka=0)
         * ) or
         * (
         * (qua2kd between '.$this->asz2kd.' and '.$this->asz2ka.')
         * )
         * )';
         * $query->whereRaw($sql);
         *
         * });
         */
        $table = $this->getTable();
        /* @var string $table */

        return $query0->join('qua00f', static function (JoinClause $join) use ($lista_propro, $posfun, $table): void {
            $join
                ->on('qua00f.ente', '=', $table.'.ente')
                ->on('qua00f.matr', '=', $table.'.matr')
                ->where('qua00f.quaann', '')
                ->whereRaw('find_in_set(qua00f.propro, ?)', [$lista_propro])
                ->whereRaw(
                    '(
(asz2kd BETWEEN qua2kd AND qua2ka)
OR
(asz2kd >= qua2kd AND qua2ka=0)
OR
(qua2kd BETWEEN asz2kd AND asz2ka)
)',
                );
            if (isset($posfun)) {
                $join->whereRaw('SUBSTR(posfun,-1,1)=?', [substr($posfun, -1, 1)]);
            }
        });
    }

    /**
     * @param  Builder<self>  $query
     */
    protected function scopeOfListaTipoCodice(Builder $query, string $lista_tipo_codice): void
    {
        $query->whereRaw('find_in_set(concat(asztip,"-",aszcod), ?)', [$lista_tipo_codice]);
    }

    // ------------------------------------------------------------
    /**
     * Calcola giorni assenza nel periodo specificato.
     *
     * @param  array<string, mixed>|null  $params  Parametri con date_min, date_max, lista_propro, posfun
     * @return float Giorni calcolati
     *
     * @throws \Exception Se date_max non è definito
     */
    public function gg(?array $params = null): float
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        // ✅ FIX PHPStan: Accesso esplicito invece di extract()
        $dateMax = $params['date_max'] ?? null;
        $dateMin = $params['date_min'] ?? null;
        $listaPropro = $params['lista_propro'] ?? null;
        $posfun = $params['posfun'] ?? null;

        if ($dateMax === null) {
            throw new \Exception('date_max is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        // Normalizza date_max se è oggetto Carbon
        if ($dateMax instanceof Carbon) {
            $dateMax = (int) $dateMax->format('Ymd');
        }

        // Calcola date_from
        $dateFrom = null;
        if ($dateMin !== null && $this->attributes['asz2kd'] < $dateMin) {
            $dateFrom = Date::createFromFormat('Ymd H:i', (string) $dateMin.' 00:00');
        } else {
            $dateFrom = Date::createFromFormat('Ymd H:i', (string) $this->attributes['asz2kd'].' 00:00');
        }

        // Calcola date_to
        $dateTo = null;
        if ($this->attributes['asz2ka'] === 0 || $this->attributes['asz2ka'] > $dateMax) {
            $dateTo = Date::createFromFormat('Ymd H:i', (string) $dateMax.' 00:00');
        } else {
            try {
                $dateTo = Date::createFromFormat('Ymd H:i', (string) $this->attributes['asz2ka'].' 00:00');
            } catch (\Exception $e) {
                dddx([
                    'message' => $e->getMessage(),
                    'asz2ka' => $this->attributes['asz2ka'],
                ]);

                return 0.0;
            }
        }

        // Ensure $date_to is not null before comparison
        if (! $dateTo instanceof Carbon) {
            return 0.0;
        }

        // Se è a ore o date_from > date_to, ritorna 0
        if ($dateFrom > $dateTo || $this->attributes['aszumi'] === 'O') {
            return 0.0;
        }

        // Filtro lista_propro
        if ($listaPropro !== null && ! \in_array($this->propro, explode(',', (string) $listaPropro), false)) {
            return 0.0;
        }

        // Filtro posfun
        if ($posfun !== null && substr((string) $this->posfun, -1, 1) !== substr((string) $posfun, -1, 1)) {
            return 0.0;
        }

        $value = $dateTo->diffInDays($dateFrom, true) + 1;
        if ((int) $value === 366) {
            dddx([
                'params' => $params,
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
                'date_max' => $dateMax,
                'asz2kd' => $this->attributes['asz2kd'],
                'asz2ka' => $this->attributes['asz2ka'],
            ]);
        }

        return $value;
    }

    /**
     * @param  array<string, mixed>|null  $params
     */
    public function hhDecimal(?array $params = null): float
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        if ($this->attributes['aszumi'] === 'G') {
            return 0.0;
        }

        $aszdur = $this->aszdur;
        $aszdur_arr = explode('.', (string) $aszdur);

        return (float) ($aszdur_arr[0] ?? 0) + ((float) ($aszdur_arr[1] ?? 0) / 60);

        /*
         * extract($params);
         * if ($this->attributes['asz2kd']<$date_min) {
         * $date_from=new Carbon($date_min);
         * } else {
         * $date_from=new Carbon($this->attributes['asz2kd']);
         * }
         * if ($this->attributes['asz2ka']==0 || $this->attributes['asz2ka']>$date_max) {
         * $date_to=new Carbon($date_max);
         * } else {
         * $date_to=new Carbon($this->attributes['asz2ka']);
         * }
         * //$st2kdi=new Carbon('19870202');
         * if ($date_from>$date_to || $this->attributes['aszumi']=='G') { //se e' a giorni
         * return 0;
         * }
         * //if($this->aszini!='0.00'){
         * //$hh_start = Carbon::createFromTimeString(str_replace('.',':',$this->aszini), 'Europe/London');
         * //dddx($hh_start);
         * $date_from=Carbon::createFromFormat('Ymd H.s',$date_from->format('Ymd').' '.$this->aszini);
         * $date_to=Carbon::createFromFormat('Ymd H.s',$date_to->format('Ymd').' '.$this->aszfin);
         * //dddx($date_from);
         * //}
         * return $date_to->diffInMinutes($date_from);
         */
    }

    // ---------------------------------------------------------------------

    /*
     * public function codiciAspettativeProgressioni(): \Illuminate\Database\Eloquent\Relations\HasOne {
     * return $this->hasOne(\Modules\Progressioni\Models\CodiciAspettative::class, 'tipo', 'asztip')->whereRaw('codice="'.$this->aszcod.'"');
     * //return \Modules\Progressioni\Models\CodiciAspettative::where('tipo',$this->asztip)->where('codice',$this->aszcod);
     * }
     */

    // -------------- MUTATORS ---------------
    protected function getFromFieldAttribute(?string $value): string
    {
        return 'asz2kd';
    }

    protected function getToFieldAttribute(?string $value): string
    {
        return 'asz2ka';
    }

    /**
     * Get ann attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    protected function getAnnAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_string($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculateAnn();
    }

    /**
     * Calcola ann.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateAnn(): string
    {
        return 'aszann';
    }

    /**
     * Get aszdescr attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    protected function getAszdescrAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_string($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculateAszdescr();
    }

    /**
     * Calcola aszdescr.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculateAszdescr(): string
    {
        $codici = $this->codici;
        if (! \is_object($codici)) {
            return '-- no set --';
        }

        return $codici->desc1;
    }

    protected function getPosizioneEcoAttribute(?string $value): ?string
    {
        $qua00f = $this->qua00f;
        $qua00f_first = $qua00f->first();

        /* @var Qua00f|null $qua00f_first */
        return $qua00f_first?->posizione_eco;
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
    protected function scopeOfCodici(Builder $query, array|string $lista_codici): Builder
    {
        if (\is_array($lista_codici)) {
            $lista_codici = implode(',', array_map(static fn (mixed $codice): string => (string) $codice, $lista_codici));
        }

        return $query->whereRaw('find_in_set(concat(asztip,"-",aszcod), ?)', [$lista_codici]);
    }

    // ----------------------------------------------------------------------
    /**
     * Get propro attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    protected function getProproAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_string($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculatePropro();
    }

    /**
     * Calcola propro.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculatePropro(): ?string
    {
        $qua00f = $this->qua00f();
        if ($qua00f->count() > 1) {
            $html = '';
            $html .= '<table>';
            foreach ($qua00f->get() as $row) {
                /** @var Qua00f $row */
                $propro = (string) ($row->getAttribute('propro') ?? '');
                $posfun = (string) ($row->getAttribute('posfun') ?? '');
                $qua2kd = (string) ($row->getAttribute('qua2kd') ?? '');
                $qua2ka = (string) ($row->getAttribute('qua2ka') ?? '');
                $html .=
                    '<tr><td>'
                    .$propro
                    .'</td><td>'
                    .$posfun
                    .'</td><td>'
                    .$qua2kd
                    .'</td><td>'
                    .$qua2ka
                    .'</td></tr>';
            }

            $html .= '</table>';
        }

        $first = $qua00f->first();

        return $first ? (string) $first->getAttribute('propro') : null;
    }

    // ----------------------------------------------------------------------
    /**
     * Get posfun attribute.
     *
     * Pattern del Livello 4 (Maestro Supremo):
     * 1. Controllo se il valore esiste già dal DB
     * 2. Se NULL, delego il calcolo a un metodo separato
     * 3. Mantengo l'accessore pulito e leggibile
     */
    protected function getPosfunAttribute(?string $value): ?string
    {
        // ✅ Livello 4: Controllo se il valore esiste già dal DB
        if (is_string($value)) {
            return $value;
        }

        // ✅ Livello 4: Delego il calcolo a metodo separato
        return $this->calculatePosfun();
    }

    /**
     * Calcola posfun.
     *
     * Metodo separato per il calcolo complesso.
     */
    protected function calculatePosfun(): ?string
    {
        $qua00f = $this->qua00f();
        $first = $qua00f->first();

        return $first ? (string) $first->getAttribute('posfun') : null;
    }

    // ----------------------------------------------------------------------
}
