<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Irp20l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $irpdal
 * @property string|null $irpal
 * @property string|null $iprod
 * @property string|null $iprof1
 * @property string|null $iprof2
 * @property string|null $rifrca
 * @property string|null $rifrag
 * @property string|null $rifrco
 * @property string|null $iproda
 * @property string|null $iprodb
 * @property string|null $rifpro
 * @property string|null $iconi
 * @property string|null $iprfi
 * @property string|null $riffig
 * @property string|null $faliq
 * @property string|null $assfis
 * @property string|null $assali
 * @property string|null $ipdedu
 * @property string|null $iprite
 * @property string|null $ipaddr
 * @property string|null $ipaddc
 * @property string|null $ipdetl
 * @property string|null $ipdetc
 * @property string|null $ipdetf
 * @property string|null $ipdeta
 * @property string|null $idisab
 * @property string|null $comest
 * @property string|null $iflgad
 * @property string|null $iann20
 * @property string|null $campo1
 * @property string|null $campo2
 * @property string|null $campo3
 * @property string|null $vuo1
 * @property string|null $vuo2
 * @property string|null $vuo3
 *
 * @method static Builder|Irp20l1 newModelQuery()
 * @method static Builder|Irp20l1 newQuery()
 * @method static Builder|Irp20l1 query()
 * @method static Builder|Irp20l1 whereAssali($value)
 * @method static Builder|Irp20l1 whereAssfis($value)
 * @method static Builder|Irp20l1 whereCampo1($value)
 * @method static Builder|Irp20l1 whereCampo2($value)
 * @method static Builder|Irp20l1 whereCampo3($value)
 * @method static Builder|Irp20l1 whereComest($value)
 * @method static Builder|Irp20l1 whereEnte($value)
 * @method static Builder|Irp20l1 whereFaliq($value)
 * @method static Builder|Irp20l1 whereIann20($value)
 * @method static Builder|Irp20l1 whereIconi($value)
 * @method static Builder|Irp20l1 whereId($value)
 * @method static Builder|Irp20l1 whereIdisab($value)
 * @method static Builder|Irp20l1 whereIflgad($value)
 * @method static Builder|Irp20l1 whereIpaddc($value)
 * @method static Builder|Irp20l1 whereIpaddr($value)
 * @method static Builder|Irp20l1 whereIpdedu($value)
 * @method static Builder|Irp20l1 whereIpdeta($value)
 * @method static Builder|Irp20l1 whereIpdetc($value)
 * @method static Builder|Irp20l1 whereIpdetf($value)
 * @method static Builder|Irp20l1 whereIpdetl($value)
 * @method static Builder|Irp20l1 whereIprfi($value)
 * @method static Builder|Irp20l1 whereIprite($value)
 * @method static Builder|Irp20l1 whereIprod($value)
 * @method static Builder|Irp20l1 whereIproda($value)
 * @method static Builder|Irp20l1 whereIprodb($value)
 * @method static Builder|Irp20l1 whereIprof1($value)
 * @method static Builder|Irp20l1 whereIprof2($value)
 * @method static Builder|Irp20l1 whereIrpal($value)
 * @method static Builder|Irp20l1 whereIrpdal($value)
 * @method static Builder|Irp20l1 whereMatr($value)
 * @method static Builder|Irp20l1 whereRiffig($value)
 * @method static Builder|Irp20l1 whereRifpro($value)
 * @method static Builder|Irp20l1 whereRifrag($value)
 * @method static Builder|Irp20l1 whereRifrca($value)
 * @method static Builder|Irp20l1 whereRifrco($value)
 * @method static Builder|Irp20l1 whereVuo1($value)
 * @method static Builder|Irp20l1 whereVuo2($value)
 * @method static Builder|Irp20l1 whereVuo3($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Irp20l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Irp20l1 extends BaseModel
{
    protected $table = 'irp20l1';
}
