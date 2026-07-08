<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;

// ----------traits ---
/**
 * Modules\Sigma\Models\Qua00k1.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $cont
 * @property int|null $matr
 * @property int|null $tipco
 * @property int|null $rapp
 * @property int|null $ruolo
 * @property int|null $propro
 * @property int|null $posfun
 * @property int|null $codqua
 * @property int|null $qudal
 * @property int|null $qual
 * @property int|null $quanz
 * @property int|null $posiz
 * @property int|null $sipco
 * @property int|null $sapp
 * @property int|null $suolo
 * @property int|null $sropro
 * @property int|null $sosfun
 * @property int|null $sodqua
 * @property int|null $annise
 * @property int|null $prvtip
 * @property int|null $prvdat
 * @property string|null $prvnum
 * @property int|null $datpas
 * @property string|null $serviz
 * @property int|null $disci1
 * @property int|null $disci2
 * @property string|null $oree
 * @property string|null $oret
 * @property int|null $aapens
 * @property string|null $quaann
 * @property int|null $qua2kd
 * @property int|null $qua2ka
 * @property int|null $qua2kz
 * @property int|null $prv2kd
 * @property int|null $dat2kp
 * @property int|null $qua001
 * @property string|null $qua002
 * @property string|null $qua003
 * @property int|null $qua004
 * @property int|null $qua005
 * @property-read Tqu00f|null $Tqu00f
 *
 * @method static Builder|Qua00k1 newModelQuery()
 * @method static Builder|Qua00k1 newQuery()
 * @method static Builder|Qua00k1 query()
 * @method static Builder|Qua00k1 whereAapens($value)
 * @method static Builder|Qua00k1 whereAnnise($value)
 * @method static Builder|Qua00k1 whereCodqua($value)
 * @method static Builder|Qua00k1 whereCont($value)
 * @method static Builder|Qua00k1 whereDat2kp($value)
 * @method static Builder|Qua00k1 whereDatpas($value)
 * @method static Builder|Qua00k1 whereDisci1($value)
 * @method static Builder|Qua00k1 whereDisci2($value)
 * @method static Builder|Qua00k1 whereEnte($value)
 * @method static Builder|Qua00k1 whereId($value)
 * @method static Builder|Qua00k1 whereMatr($value)
 * @method static Builder|Qua00k1 whereOree($value)
 * @method static Builder|Qua00k1 whereOret($value)
 * @method static Builder|Qua00k1 wherePosfun($value)
 * @method static Builder|Qua00k1 wherePosiz($value)
 * @method static Builder|Qua00k1 wherePropro($value)
 * @method static Builder|Qua00k1 wherePrv2kd($value)
 * @method static Builder|Qua00k1 wherePrvdat($value)
 * @method static Builder|Qua00k1 wherePrvnum($value)
 * @method static Builder|Qua00k1 wherePrvtip($value)
 * @method static Builder|Qua00k1 whereQua001($value)
 * @method static Builder|Qua00k1 whereQua002($value)
 * @method static Builder|Qua00k1 whereQua003($value)
 * @method static Builder|Qua00k1 whereQua004($value)
 * @method static Builder|Qua00k1 whereQua005($value)
 * @method static Builder|Qua00k1 whereQua2ka($value)
 * @method static Builder|Qua00k1 whereQua2kd($value)
 * @method static Builder|Qua00k1 whereQua2kz($value)
 * @method static Builder|Qua00k1 whereQuaann($value)
 * @method static Builder|Qua00k1 whereQual($value)
 * @method static Builder|Qua00k1 whereQuanz($value)
 * @method static Builder|Qua00k1 whereQudal($value)
 * @method static Builder|Qua00k1 whereRapp($value)
 * @method static Builder|Qua00k1 whereRuolo($value)
 * @method static Builder|Qua00k1 whereSapp($value)
 * @method static Builder|Qua00k1 whereServiz($value)
 * @method static Builder|Qua00k1 whereSipco($value)
 * @method static Builder|Qua00k1 whereSodqua($value)
 * @method static Builder|Qua00k1 whereSosfun($value)
 * @method static Builder|Qua00k1 whereSropro($value)
 * @method static Builder|Qua00k1 whereSuolo($value)
 * @method static Builder|Qua00k1 whereTipco($value)
 *
 * @mixin \Eloquent
 */
class Qua00k1 extends BaseModel
{
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

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'qua00k1';

    public $timestamps = false;

    /**
     * @return HasOne<Tqu00f, $this>
     */
    public function Tqu00f(): HasOne
    {
        return $this->hasOne(Tqu00f::class, 'propro', 'propro')
            ->where('posfun', $this->posfun)
            ->where('codqua', $this->codqua)
            ->where('cont', $this->cont)
            ->where('tipco', $this->tipco)
            ->where('ruolo', $this->ruolo);
    }

    // ---------------------------------------------------------------------
    /**
     * @param  array<string, mixed>|null  $params
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

    // /------------------------------------------
    /**
     * @param  array<string, mixed>|null  $params
     */
    public function giorni(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        $qua2kdValue = $this->attributes['qua2kd'] ?? null;
        if (! is_numeric($qua2kdValue)) {
            throw new \InvalidArgumentException('qua2kd must be numeric');
        }
        /** @var numeric-string $qua2kdStr */
        $qua2kdStr = (string) $qua2kdValue;
        $carbon = new Carbon($qua2kdStr);

        $anno = $params['anno'] ?? null;
        if (! is_numeric($anno)) {
            throw new \InvalidArgumentException('anno must be numeric');
        }
        /** @var numeric-string $annoStr */
        $annoStr = (string) $anno;

        $qua2kaValue = $this->attributes['qua2ka'] ?? 0;
        $qua2kaInt = is_numeric($qua2kaValue) ? (int) $qua2kaValue : 0;
        $al = $qua2kaInt === 0 ? new Carbon($annoStr.'1231') : new Carbon((string) $qua2kaInt);

        return (int) ($al->diffInDays($carbon, true) + 1);
    }

    /**
     * @param  array<string, mixed>|null  $params
     */
    public function giorni_propro(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        if (! isset($params['propro'])) {
            $lastQua00f = static::last_qua00f();
            /** @var int|string|null $proproValue */
            $proproValue = $lastQua00f?->propro;
            $params['propro'] = $proproValue;
        }

        $proproParam = $params['propro'] ?? null;
        $proproParamInt = is_numeric($proproParam) ? (int) $proproParam : null;
        if ($this->propro === $proproParamInt) {
            return $this->giorni($params);
        }

        return 0;
    }

    /**
     * @param  array<string, mixed>|null  $params
     */
    public function giorni_propro_posfun(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        if (! isset($params['propro'])) {
            $lastQua00f = static::last_qua00f();
            /** @var int|string|null $proproValue */
            $proproValue = $lastQua00f?->propro;
            $params['propro'] = $proproValue;
        }

        if (! isset($params['posfun'])) {
            $lastQua00f = static::last_qua00f();
            /** @var int|string|null $posfunValue */
            $posfunValue = $lastQua00f?->posfun;
            $params['posfun'] = $posfunValue;
        }

        $proproParam = $params['propro'] ?? null;
        $posfunParam = $params['posfun'] ?? null;

        $proproParamInt = is_numeric($proproParam) ? (int) $proproParam : null;
        $posfunParamInt = is_numeric($posfunParam) ? (int) $posfunParam : null;

        if ($this->propro !== $proproParamInt) {
            return 0;
        }
        if ($this->posfun !== $posfunParamInt) {
            return 0;
        }

        return $this->giorni($params);
    }

    // --------------------------------------------------------------------
}
