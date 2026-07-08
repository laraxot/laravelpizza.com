<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Asz00k10.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $cont
 * @property int|null $matr
 * @property int|null $asztip
 * @property int|null $aszcod
 * @property int|null $aszdal
 * @property int|null $aszal
 * @property string|null $aszini
 * @property string|null $aszfin
 * @property int|null $aszcom
 * @property int|null $asztpr
 * @property int|null $aszdpr
 * @property string|null $asznpr
 * @property string|null $aszumi
 * @property string|null $aszpes
 * @property string|null $aszdur
 * @property int|null $asz01
 * @property int|null $asz02
 * @property int|null $asz03
 * @property int|null $asz04
 * @property int|null $asz05
 * @property string|null $aszcm
 * @property string|null $aszcms
 * @property int|null $asztim
 * @property string|null $aszpro
 * @property int|null $aszprv
 * @property string|null $aszann
 * @property int|null $asz2kd
 * @property int|null $asz2ka
 * @property int|null $asz2kc
 * @property int|null $asz2kp
 * @property int|null $asz2kz
 * @property string|null $aszeup
 * @property int|null $asztin
 * @property int|null $asz001
 * @property string|null $asz002
 * @property string|null $asz003
 * @property int|null $asz004
 * @property int|null $asz005
 *
 * @method static Builder|Asz00k10 newModelQuery()
 * @method static Builder|Asz00k10 newQuery()
 * @method static Builder|Asz00k10 query()
 * @method static Builder|Asz00k10 whereAsz001($value)
 * @method static Builder|Asz00k10 whereAsz002($value)
 * @method static Builder|Asz00k10 whereAsz003($value)
 * @method static Builder|Asz00k10 whereAsz004($value)
 * @method static Builder|Asz00k10 whereAsz005($value)
 * @method static Builder|Asz00k10 whereAsz01($value)
 * @method static Builder|Asz00k10 whereAsz02($value)
 * @method static Builder|Asz00k10 whereAsz03($value)
 * @method static Builder|Asz00k10 whereAsz04($value)
 * @method static Builder|Asz00k10 whereAsz05($value)
 * @method static Builder|Asz00k10 whereAsz2ka($value)
 * @method static Builder|Asz00k10 whereAsz2kc($value)
 * @method static Builder|Asz00k10 whereAsz2kd($value)
 * @method static Builder|Asz00k10 whereAsz2kp($value)
 * @method static Builder|Asz00k10 whereAsz2kz($value)
 * @method static Builder|Asz00k10 whereAszal($value)
 * @method static Builder|Asz00k10 whereAszann($value)
 * @method static Builder|Asz00k10 whereAszcm($value)
 * @method static Builder|Asz00k10 whereAszcms($value)
 * @method static Builder|Asz00k10 whereAszcod($value)
 * @method static Builder|Asz00k10 whereAszcom($value)
 * @method static Builder|Asz00k10 whereAszdal($value)
 * @method static Builder|Asz00k10 whereAszdpr($value)
 * @method static Builder|Asz00k10 whereAszdur($value)
 * @method static Builder|Asz00k10 whereAszeup($value)
 * @method static Builder|Asz00k10 whereAszfin($value)
 * @method static Builder|Asz00k10 whereAszini($value)
 * @method static Builder|Asz00k10 whereAsznpr($value)
 * @method static Builder|Asz00k10 whereAszpes($value)
 * @method static Builder|Asz00k10 whereAszpro($value)
 * @method static Builder|Asz00k10 whereAszprv($value)
 * @method static Builder|Asz00k10 whereAsztim($value)
 * @method static Builder|Asz00k10 whereAsztin($value)
 * @method static Builder|Asz00k10 whereAsztip($value)
 * @method static Builder|Asz00k10 whereAsztpr($value)
 * @method static Builder|Asz00k10 whereAszumi($value)
 * @method static Builder|Asz00k10 whereCont($value)
 * @method static Builder|Asz00k10 whereEnte($value)
 * @method static Builder|Asz00k10 whereId($value)
 * @method static Builder|Asz00k10 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Asz00k10Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Asz00k10 extends BaseModel
{
    protected $table = 'asz00k10';
}
