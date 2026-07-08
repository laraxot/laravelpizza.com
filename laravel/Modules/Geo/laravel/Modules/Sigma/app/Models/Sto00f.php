<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Modules\Sigma\Models\Traits\Relationships\EnteMatrRelationship;
use Modules\Sigma\Models\Traits\Relationships\Qua00k1Relationship;

/**
 * Modules\Sigma\Models\Sto00f.
 *
 * @property int $id
 * @property int $ente
 * @property int $matr
 * @property int $stass
 * @property int $stdim
 * @property int $stupd
 * @property int $tipass
 * @property int $tipdim
 * @property string $stann
 * @property int $stotia
 * @property int $stotil
 * @property int $stodaa
 * @property int $stodal
 * @property string $stonua
 * @property string $stonul
 * @property int $st2kas
 * @property int $st2kdi
 * @property int $st2ku
 * @property int $sto2ka
 * @property int $sto2kd
 * @property int $matina
 * @property int $sto001
 * @property string $sto002
 * @property string $sto003
 * @property int $sto004
 * @property int $sto005
 * @property string|null $desctipass
 * @property string|null $desctipdim
 * @property string|null $tipoprovvass
 * @property string|null $tipoprovvdi
 * @property-read Collection<int, Qua00f> $qua00f
 * @property-read int|null $qua00f_count
 * @property-read Collection<int, Qua00k1> $qua00k1
 * @property-read int|null $qua00k1_count
 * @property-read Collection<int, Rep00f> $rep00f
 * @property-read int|null $rep00f_count
 * @property-read int|null $anno
 *
 * @method static Builder|Sto00f newModelQuery()
 * @method static Builder|Sto00f newQuery()
 * @method static Builder|Sto00f ofDate(int $date)
 * @method static Builder|Sto00f ofEnte(int $ente)
 * @method static Builder|Sto00f ofEnteYear(?int $ente, ?int $year)
 * @method static Builder|Sto00f ofFourMonthPeriod(int $fourMonthPeriod, int $year)
 * @method static Builder|Sto00f ofQuarter(int $quarter, int $year)
 * @method static Builder|Sto00f ofRangeDate(int $date_start, int $date_end)
 * @method static Builder|Sto00f ofYear(?int $year)
 * @method static Builder|Sto00f query()
 * @method static Builder|Sto00f whereDesctipass($value)
 * @method static Builder|Sto00f whereDesctipdim($value)
 * @method static Builder|Sto00f whereEnte($value)
 * @method static Builder|Sto00f whereId($value)
 * @method static Builder|Sto00f whereMatina($value)
 * @method static Builder|Sto00f whereMatr($value)
 * @method static Builder|Sto00f whereSt2kas($value)
 * @method static Builder|Sto00f whereSt2kdi($value)
 * @method static Builder|Sto00f whereSt2ku($value)
 * @method static Builder|Sto00f whereStann($value)
 * @method static Builder|Sto00f whereStass($value)
 * @method static Builder|Sto00f whereStdim($value)
 * @method static Builder|Sto00f whereSto001($value)
 * @method static Builder|Sto00f whereSto002($value)
 * @method static Builder|Sto00f whereSto003($value)
 * @method static Builder|Sto00f whereSto004($value)
 * @method static Builder|Sto00f whereSto005($value)
 * @method static Builder|Sto00f whereSto2ka($value)
 * @method static Builder|Sto00f whereSto2kd($value)
 * @method static Builder|Sto00f whereStodaa($value)
 * @method static Builder|Sto00f whereStodal($value)
 * @method static Builder|Sto00f whereStonua($value)
 * @method static Builder|Sto00f whereStonul($value)
 * @method static Builder|Sto00f whereStotia($value)
 * @method static Builder|Sto00f whereStotil($value)
 * @method static Builder|Sto00f whereStupd($value)
 * @method static Builder|Sto00f whereTipass($value)
 * @method static Builder|Sto00f whereTipdim($value)
 * @method static Builder|Sto00f whereTipoprovvass($value)
 * @method static Builder|Sto00f whereTipoprovvdi($value)
 *
 * @mixin \Eloquent
 */
class Sto00f extends BaseDateRangeModel
{
    use EnteMatrRelationship;
    use Qua00k1Relationship;

    protected $fillable = [
        'id',
        'ente',
        'matr',
        'stass',
        'stdim',
        'stupd',
        'tipass',
        'tipdim',
        'stann',
        'stotia',
        'stotil',
        'stodaa',
        'stodal',
        'stonua',
        'stonul',
        'st2kas',
        'st2kdi',
        'st2ku',
        'sto2ka',
        'sto2kd',
        'matina',
        'sto001',
        'sto002',
        'sto003',
        'sto004',
        'sto005',
    ];

    protected $table = 'sto00f';

    public const FROM_FIELD = 'st2kas';

    public const TO_FIELD = 'st2kdi';

    public const ANN_FIELD = 'stann';

    public function rangeFromField(): string
    {
        return 'st2kas';
    }

    public function rangeToField(): string
    {
        return 'st2kdi';
    }

    public function annFieldName(): string
    {
        return 'stann';
    }

    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'st2kas' => 'integer',
            'st2kdi' => 'integer',
        ]);
    }

    /**
     * @param  array<string, mixed>|null  $params
     */
    public function giorni(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        $st2kasValue = $this->attributes['st2kas'] ?? null;
        if ($st2kasValue === null || ! is_numeric($st2kasValue)) {
            return 0;
        }
        $st2kasStr = (string) $st2kasValue;
        $st2kas = new Carbon($st2kasStr);

        $anno = $params['anno'] ?? null;
        if (! is_numeric($anno)) {
            throw new \InvalidArgumentException('anno must be numeric');
        }
        /** @var numeric-string $annoStr */
        $annoStr = (string) $anno;

        $st2kdiValue = $this->attributes['st2kdi'] ?? 0;
        $st2kdiInt = is_numeric($st2kdiValue) ? (int) $st2kdiValue : 0;
        if ($st2kdiInt === 0) {
            $st2kdi = new Carbon($annoStr.'1231');
        } else {
            $st2kdiStr = (string) $st2kdiInt;
            $st2kdi = new Carbon($st2kdiStr);
        }

        return (int) ($st2kdi->diffInDays($st2kas, true) + 1);
    }

    /**
     * @param  array<string, mixed>|null  $params
     */
    public function gg(?array $params = null): int
    {
        if ($params === null) {
            $params = getRouteParameters();
        }

        $date_min = $params['date_min'] ?? null;
        $date_max = $params['date_max'] ?? null;

        if ($date_min === null) {
            throw new Exception('!isset($date_min)');
        }

        if ($date_max === null) {
            throw new Exception('!isset($date_max)');
        }

        $st2kasValue = $this->attributes['st2kas'] ?? null;
        $st2kasInt = is_numeric($st2kasValue) ? (int) $st2kasValue : 0;
        $dateMinInt = is_numeric($date_min) ? (int) $date_min : 0;
        if ($st2kasInt < $dateMinInt) {
            $dateMinStr = (string) $date_min;
            $st2kas = new Carbon($dateMinStr);
        } else {
            $st2kasStr = (string) $st2kasInt;
            $st2kas = new Carbon($st2kasStr);
        }

        $st2kdiValue = $this->attributes['st2kdi'] ?? 0;
        $st2kdiInt = is_numeric($st2kdiValue) ? (int) $st2kdiValue : 0;
        $dateMaxInt = is_numeric($date_max) ? (int) $date_max : 0;
        if ($st2kdiInt === 0 || $st2kdiInt > $dateMaxInt) {
            $dateMaxStr = (string) $date_max;
            $st2kdi = new Carbon($dateMaxStr);
        } else {
            $st2kdiStr = (string) $st2kdiInt;
            $st2kdi = new Carbon($st2kdiStr);
        }

        if ($st2kas > $st2kdi) {
            return 0;
        }

        return (int) ($st2kdi->diffInDays($st2kas, true) + 1);
    }
}
