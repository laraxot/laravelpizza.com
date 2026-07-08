<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Irp11l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $impon1
 * @property string|null $impon2
 * @property string|null $aliq
 * @property string|null $aliq2
 * @property string|null $cumu99
 * @property string|null $cumu98
 * @property string|null $cumu96
 * @property string|null $cumu95
 * @property string|null $cumu94
 * @property string|null $cumu93
 * @property string|null $cumu97
 * @property string|null $cumpro
 * @property string|null $cumcon
 * @property string|null $cumfig
 * @property string|null $cumalt
 * @property string|null $cumass
 * @property string|null $ritadd
 * @property string|null $imppen
 * @property string|null $iirapt
 * @property string|null $iirap1
 * @property string|null $iirap2
 * @property string|null $iirap3
 * @property string|null $assvit
 * @property string|null $assinf
 * @property string|null $rasimp
 * @property string|null $rasrit
 * @property string|null $rasrim
 * @property string|null $rirap1
 * @property string|null $rirap2
 * @property string|null $rirap3
 * @property string|null $rirapt
 * @property string|null $cumuv1
 * @property string|null $cumuv2
 * @property string|null $cumuv3
 * @property string|null $cumuv4
 * @property string|null $irpann
 *
 * @method static Builder|Irp11l1 newModelQuery()
 * @method static Builder|Irp11l1 newQuery()
 * @method static Builder|Irp11l1 query()
 * @method static Builder|Irp11l1 whereAliq($value)
 * @method static Builder|Irp11l1 whereAliq2($value)
 * @method static Builder|Irp11l1 whereAssinf($value)
 * @method static Builder|Irp11l1 whereAssvit($value)
 * @method static Builder|Irp11l1 whereCumalt($value)
 * @method static Builder|Irp11l1 whereCumass($value)
 * @method static Builder|Irp11l1 whereCumcon($value)
 * @method static Builder|Irp11l1 whereCumfig($value)
 * @method static Builder|Irp11l1 whereCumpro($value)
 * @method static Builder|Irp11l1 whereCumu93($value)
 * @method static Builder|Irp11l1 whereCumu94($value)
 * @method static Builder|Irp11l1 whereCumu95($value)
 * @method static Builder|Irp11l1 whereCumu96($value)
 * @method static Builder|Irp11l1 whereCumu97($value)
 * @method static Builder|Irp11l1 whereCumu98($value)
 * @method static Builder|Irp11l1 whereCumu99($value)
 * @method static Builder|Irp11l1 whereCumuv1($value)
 * @method static Builder|Irp11l1 whereCumuv2($value)
 * @method static Builder|Irp11l1 whereCumuv3($value)
 * @method static Builder|Irp11l1 whereCumuv4($value)
 * @method static Builder|Irp11l1 whereEnte($value)
 * @method static Builder|Irp11l1 whereId($value)
 * @method static Builder|Irp11l1 whereIirap1($value)
 * @method static Builder|Irp11l1 whereIirap2($value)
 * @method static Builder|Irp11l1 whereIirap3($value)
 * @method static Builder|Irp11l1 whereIirapt($value)
 * @method static Builder|Irp11l1 whereImpon1($value)
 * @method static Builder|Irp11l1 whereImpon2($value)
 * @method static Builder|Irp11l1 whereImppen($value)
 * @method static Builder|Irp11l1 whereIrpann($value)
 * @method static Builder|Irp11l1 whereMatr($value)
 * @method static Builder|Irp11l1 whereRasimp($value)
 * @method static Builder|Irp11l1 whereRasrim($value)
 * @method static Builder|Irp11l1 whereRasrit($value)
 * @method static Builder|Irp11l1 whereRirap1($value)
 * @method static Builder|Irp11l1 whereRirap2($value)
 * @method static Builder|Irp11l1 whereRirap3($value)
 * @method static Builder|Irp11l1 whereRirapt($value)
 * @method static Builder|Irp11l1 whereRitadd($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Irp11l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Irp11l1 extends BaseModel
{
    protected $table = 'irp11l1';
}
