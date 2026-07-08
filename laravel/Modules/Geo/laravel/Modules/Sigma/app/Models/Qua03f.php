<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Date;
use Modules\Progressioni\Models\CategoriaPropro;
use Modules\Sigma\Models\Traits\Extras\FunctionExtra;

// ----------traits ---

/**
 * Modules\Sigma\Models\Qua03f.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $q3tipo
 * @property int $q3dal
 * @property int $q3al
 * @property string $q3desc
 * @property string $q3des2
 * @property string $q3des3
 * @property int $q3cont
 * @property int $q3pro
 * @property int $q3fun
 * @property int $q3man
 * @property int $q3dis
 * @property int $q3voc1
 * @property int $q3anz1
 * @property int $q3imp1
 * @property string $q3eur1
 * @property int $q3voc2
 * @property int $q3anz2
 * @property int $q3imp2
 * @property string $q3eur2
 * @property int $q3voc3
 * @property int $q3anz3
 * @property int $q3imp3
 * @property string $q3eur3
 * @property int $q3voc4
 * @property int $q3anz4
 * @property int $q3imp4
 * @property string $q3eur4
 * @property int $q3voc5
 * @property int $q3anz5
 * @property int $q3imp5
 * @property string $q3eur5
 * @property int $q3tip
 * @property int $q3dat
 * @property string $q3num
 * @property string $q3ann
 * @property int $q32kd
 * @property int $q32ka
 * @property int $q32ka1
 * @property int $q32ka2
 * @property int $q32ka3
 * @property int $q32ka4
 * @property int $q32ka5
 * @property int $q32k
 * @property int $q3001
 * @property string $q3002
 * @property string $q3003
 * @property int $q3004
 * @property int $q3005
 * @property-read Tqu00f|null $Tqu00f
 * @property-read string|null $categoria_eco
 *
 * @method static Builder|Qua03f newModelQuery()
 * @method static Builder|Qua03f newQuery()
 * @method static Builder|Qua03f query()
 * @method static Builder|Qua03f whereEnte($value)
 * @method static Builder|Qua03f whereId($value)
 * @method static Builder|Qua03f whereMatr($value)
 * @method static Builder|Qua03f whereQ3001($value)
 * @method static Builder|Qua03f whereQ3002($value)
 * @method static Builder|Qua03f whereQ3003($value)
 * @method static Builder|Qua03f whereQ3004($value)
 * @method static Builder|Qua03f whereQ3005($value)
 * @method static Builder|Qua03f whereQ32k($value)
 * @method static Builder|Qua03f whereQ32ka($value)
 * @method static Builder|Qua03f whereQ32ka1($value)
 * @method static Builder|Qua03f whereQ32ka2($value)
 * @method static Builder|Qua03f whereQ32ka3($value)
 * @method static Builder|Qua03f whereQ32ka4($value)
 * @method static Builder|Qua03f whereQ32ka5($value)
 * @method static Builder|Qua03f whereQ32kd($value)
 * @method static Builder|Qua03f whereQ3al($value)
 * @method static Builder|Qua03f whereQ3ann($value)
 * @method static Builder|Qua03f whereQ3anz1($value)
 * @method static Builder|Qua03f whereQ3anz2($value)
 * @method static Builder|Qua03f whereQ3anz3($value)
 * @method static Builder|Qua03f whereQ3anz4($value)
 * @method static Builder|Qua03f whereQ3anz5($value)
 * @method static Builder|Qua03f whereQ3cont($value)
 * @method static Builder|Qua03f whereQ3dal($value)
 * @method static Builder|Qua03f whereQ3dat($value)
 * @method static Builder|Qua03f whereQ3des2($value)
 * @method static Builder|Qua03f whereQ3des3($value)
 * @method static Builder|Qua03f whereQ3desc($value)
 * @method static Builder|Qua03f whereQ3dis($value)
 * @method static Builder|Qua03f whereQ3eur1($value)
 * @method static Builder|Qua03f whereQ3eur2($value)
 * @method static Builder|Qua03f whereQ3eur3($value)
 * @method static Builder|Qua03f whereQ3eur4($value)
 * @method static Builder|Qua03f whereQ3eur5($value)
 * @method static Builder|Qua03f whereQ3fun($value)
 * @method static Builder|Qua03f whereQ3imp1($value)
 * @method static Builder|Qua03f whereQ3imp2($value)
 * @method static Builder|Qua03f whereQ3imp3($value)
 * @method static Builder|Qua03f whereQ3imp4($value)
 * @method static Builder|Qua03f whereQ3imp5($value)
 * @method static Builder|Qua03f whereQ3man($value)
 * @method static Builder|Qua03f whereQ3num($value)
 * @method static Builder|Qua03f whereQ3pro($value)
 * @method static Builder|Qua03f whereQ3tip($value)
 * @method static Builder|Qua03f whereQ3tipo($value)
 * @method static Builder|Qua03f whereQ3voc1($value)
 * @method static Builder|Qua03f whereQ3voc2($value)
 * @method static Builder|Qua03f whereQ3voc3($value)
 * @method static Builder|Qua03f whereQ3voc4($value)
 * @method static Builder|Qua03f whereQ3voc5($value)
 *
 * @mixin \Eloquent
 */
class Qua03f extends BaseDateRangeModel
{
    // use SigmaModelTrait;
    use FunctionExtra;

    protected $fillable = [
        'id',
        'ente',
        'matr',
        'q3tipo',
        'q3dal',
        'q3al',
        'q3desc',
        'q3des2',
        'q3des3',
        'q3cont',
        'q3pro',
        'q3fun',
        'q3man',
        'q3dis',
        'q3voc1',
        'q3anz1',
        'q3imp1',
        'q3eur1',
        'q3voc2',
        'q3anz2',
        'q3imp2',
        'q3eur2',
        'q3voc3',
        'q3anz3',
        'q3imp3',
        'q3eur3',
        'q3voc4',
        'q3anz4',
        'q3imp4',
        'q3eur4',
        'q3voc5',
        'q3anz5',
        'q3imp5',
        'q3eur5',
        'q3tip',
        'q3dat',
        'q3num',
        'q3ann',
        'q32kd',
        'q32ka',
        'q32ka1',
        'q32ka2',
        'q32ka3',
        'q32ka4',
        'q32ka5',
        'q32k',
        'q3001',
        'q3002',
        'q3003',
        'q3004',
        'q3005',
    ];

    protected $table = 'qua03f';

    // -------------------------------------------------------------------------
    public static string $from_field = 'q32kd';

    public static string $to_field = 'q32ka';

    public static string $ann_field = 'q3ann';

    public function rangeFromField(): string
    {
        return 'q32kd';
    }

    public function rangeToField(): string
    {
        return 'q32ka';
    }

    public function annFieldName(): string
    {
        return 'q3ann';
    }

    // -------------------------------------------------------------------------
    /**
     * @return HasOne<Tqu00f, $this>
     */
    public function Tqu00f(): HasOne
    {
        return $this->hasOne(Tqu00f::class, 'propro', 'q3pro')->where('posfun', $this->q3fun);

        // ->where('codqua',$this->codqua)
        // ->where('cont',$this->cont)
        // ->where('tipco',$this->tipco)
        // ->where('ruolo',$this->ruolo)
    }

    // /------------------------------------------
    /**
     * @param  array<string, mixed>|null  $params
     */
    public function giorni(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        $q32kdValue = $this->attributes['q32kd'] ?? null;
        if (! is_numeric($q32kdValue)) {
            throw new \InvalidArgumentException('q32kd must be numeric');
        }
        /** @var numeric-string $q32kdStr */
        $q32kdStr = (string) $q32kdValue;
        $carbon = new Carbon($q32kdStr);

        $anno = $params['anno'] ?? null;
        if (! is_numeric($anno)) {
            throw new \InvalidArgumentException('anno must be numeric');
        }
        /** @var numeric-string $annoStr */
        $annoStr = (string) $anno;

        $q32kaValue = $this->attributes['q32ka'] ?? 0;
        $q32kaInt = is_numeric($q32kaValue) ? (int) $q32kaValue : 0;
        $al = $q32kaInt === 0 ? new Carbon($annoStr.'1231') : new Carbon((string) $q32kaInt);

        return (int) ($al->diffInDays($carbon, true) + 1);
    }

    // ---------------------------------------------------------
    /**
     * @param  array<int|string, mixed>|null  $params
     */
    public function gg(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        // Estrai variabili da $params senza extract()
        $propro = $params['propro'] ?? null;
        $categoria_eco = $params['categoria_eco'] ?? null;
        $posfun = $params['posfun'] ?? null;
        $lista_propro_sup = $params['lista_propro_sup'] ?? null;
        $lista_propro = $params['lista_propro'] ?? null;
        $date_min = $params['date_min'] ?? null;

        // if (! isset($date_min)) { // non e' obbligatorio
        //    throw new \Exception('!isset($date_min)');
        // }

        // if (! isset($date_max)) {

        //    throw new Exception('!isset($date_max)');
        // }

        $proproInt = is_numeric($propro) ? (int) $propro : null;
        if ($proproInt !== null && $proproInt !== $this->attributes['q3pro']) {
            return 0;
        }

        $categoriaEcoInt = is_numeric($categoria_eco) ? (int) $categoria_eco : null;
        if ($categoriaEcoInt !== null && $categoriaEcoInt !== $this->categoria_eco) {
            return 0;
        }

        $posfunInt = is_numeric($posfun) ? (int) $posfun : null;
        if ($posfunInt !== null && $posfunInt !== $this->attributes['q3fun']) {
            return 0;
        }

        $is_propro_sup = false;
        if ($lista_propro_sup !== null) {
            $array_propro_sup = explode(',', (string) $lista_propro_sup);
            if (\in_array($this->attributes['q3pro'], $array_propro_sup, false)) {
                $is_propro_sup = true;
            }
        }

        if ($lista_propro !== null) {
            $array_propro = explode(',', (string) $lista_propro);
            if (! \in_array($this->attributes['q3pro'], $array_propro, false) && ! $is_propro_sup) {
                return 0;
            }

            $posfunStr = is_numeric($posfun) || is_string($posfun) ? (string) $posfun : '';
            if (
                ! $is_propro_sup && (
                    $posfunStr !== ''
                    && substr($posfunStr, -1) !== substr((string) $this->attributes['q3fun'], -1)
                )
            ) {
                return 0;
            }
        }

        /*
         * if (stristr($this->attributes['q3desc'], 'ricongi')) {
         * return 0;
         * }
         * if (stristr($this->attributes['q3desc'], 'riscat')) {
         * return 0;
         * }
         */

        if (! \in_array($this->attributes['q3tipo'], ['101', '102', '103', '104', '105', '121'], false)) {
            return 0;
        }

        $q32kdValue = $this->attributes['q32kd'] ?? null;
        $q32kaValue = $this->attributes['q32ka'] ?? null;

        $date_from = null;
        if ($date_min !== null && is_numeric($q32kdValue) && (int) $q32kdValue < (int) $date_min) {
            $dateMinStr = is_numeric($date_min) ? (string) $date_min : '';
            if ($dateMinStr === '') {
                throw new \InvalidArgumentException('date_min must be numeric');
            }
            /** @var numeric-string $dateMinStr */
            $dateFromResult = Date::createFromFormat('Ymd H:i', $dateMinStr.' 00:00');
            if (! $dateFromResult instanceof Carbon) {
                throw new \InvalidArgumentException('Invalid date_min format');
            }
            $date_from = $dateFromResult;
        } else {
            $q32kdStr = is_numeric($q32kdValue) ? (string) $q32kdValue : '';
            if ($q32kdStr === '') {
                throw new \InvalidArgumentException('q32kd must be numeric');
            }
            /** @var numeric-string $q32kdStr */
            $dateFromResult = Date::createFromFormat('Ymd H:i', $q32kdStr.' 00:00');
            if (! $dateFromResult instanceof Carbon) {
                throw new \InvalidArgumentException('Invalid q32kd format');
            }
            $date_from = $dateFromResult;
        }

        $q32kaStr = is_numeric($q32kaValue) ? (string) $q32kaValue : '';
        if ($q32kaStr === '') {
            throw new \InvalidArgumentException('q32ka must be numeric');
        }
        /** @var numeric-string $q32kaStr */
        $dateToResult = Date::createFromFormat('Ymd H:i', $q32kaStr.' 00:00');
        if (! $dateToResult instanceof Carbon) {
            throw new \InvalidArgumentException('Invalid q32ka format');
        }
        $date_to = $dateToResult;

        /*
         * if (0 === $this->attributes['q32ka'] || $this->attributes['q32ka'] > $date_max) {
         * $date_to = new Carbon($date_max);
         * } else {
         * $date_to = new Carbon($this->attributes['q32ka']);
         * }
         */
        if (is_numeric($q32kaValue) && (int) $q32kaValue === 0) {
            dddx($this);
        }

        // echo '<br/>'.$date_from.'   '.$date_to;
        // PHPStan: $date_from e $date_to sono sempre Carbon dopo i controlli instanceof sopra
        if ($date_from > $date_to) {
            return 0;
        }

        // $st2kdi=new Carbon('19870202');
        return (int) ($date_to->diffInDays($date_from, true) + 1);
    }

    // ----------------------------------------------------------
    protected function getCategoriaEcoAttribute(?string $value): ?string
    {
        $row = CategoriaPropro::whereRaw('find_in_set(?, lista_propro)', [$this->q3pro])->first();
        if ($row === null) {
            echo '<h3> Aggiungi ['.$this->q3pro.'] a CategoriaPropro </h3>';

            // die('['.__LINE__.']['.__FILE__.']');
            return null;
        }

        return $row->categoria;
    }

    /*
     * public function getGgAttribute(?int $value): ?int {
     * return 666;
     * }
     */
}
