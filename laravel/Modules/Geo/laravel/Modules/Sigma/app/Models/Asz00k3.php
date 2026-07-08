<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Asz00k3.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $cont
 * @property string|null $matr
 * @property string|null $asztip
 * @property string|null $aszcod
 * @property string|null $aszdal
 * @property string|null $aszal
 * @property string|null $aszini
 * @property string|null $aszfin
 * @property string|null $aszcom
 * @property string|null $asztpr
 * @property string|null $aszdpr
 * @property string|null $asznpr
 * @property string|null $aszumi
 * @property string|null $aszpes
 * @property string|null $aszdur
 * @property string|null $asz01
 * @property string|null $asz02
 * @property string|null $asz03
 * @property string|null $asz04
 * @property string|null $asz05
 * @property string|null $aszcm
 * @property string|null $aszcms
 * @property string|null $asztim
 * @property string|null $aszpro
 * @property string|null $aszprv
 * @property string|null $aszann
 * @property string|null $asz2kd
 * @property string|null $asz2ka
 * @property string|null $asz2kc
 * @property string|null $asz2kp
 * @property string|null $asz2kz
 * @property string|null $aszeup
 * @property string|null $asztin
 * @property string|null $asz001
 * @property string|null $asz002
 * @property string|null $asz003
 * @property string|null $asz004
 * @property string|null $asz005
 *
 * @method static Builder|Asz00k3 newModelQuery()
 * @method static Builder|Asz00k3 newQuery()
 * @method static Builder|Asz00k3 query()
 * @method static Builder|Asz00k3 whereAsz001($value)
 * @method static Builder|Asz00k3 whereAsz002($value)
 * @method static Builder|Asz00k3 whereAsz003($value)
 * @method static Builder|Asz00k3 whereAsz004($value)
 * @method static Builder|Asz00k3 whereAsz005($value)
 * @method static Builder|Asz00k3 whereAsz01($value)
 * @method static Builder|Asz00k3 whereAsz02($value)
 * @method static Builder|Asz00k3 whereAsz03($value)
 * @method static Builder|Asz00k3 whereAsz04($value)
 * @method static Builder|Asz00k3 whereAsz05($value)
 * @method static Builder|Asz00k3 whereAsz2ka($value)
 * @method static Builder|Asz00k3 whereAsz2kc($value)
 * @method static Builder|Asz00k3 whereAsz2kd($value)
 * @method static Builder|Asz00k3 whereAsz2kp($value)
 * @method static Builder|Asz00k3 whereAsz2kz($value)
 * @method static Builder|Asz00k3 whereAszal($value)
 * @method static Builder|Asz00k3 whereAszann($value)
 * @method static Builder|Asz00k3 whereAszcm($value)
 * @method static Builder|Asz00k3 whereAszcms($value)
 * @method static Builder|Asz00k3 whereAszcod($value)
 * @method static Builder|Asz00k3 whereAszcom($value)
 * @method static Builder|Asz00k3 whereAszdal($value)
 * @method static Builder|Asz00k3 whereAszdpr($value)
 * @method static Builder|Asz00k3 whereAszdur($value)
 * @method static Builder|Asz00k3 whereAszeup($value)
 * @method static Builder|Asz00k3 whereAszfin($value)
 * @method static Builder|Asz00k3 whereAszini($value)
 * @method static Builder|Asz00k3 whereAsznpr($value)
 * @method static Builder|Asz00k3 whereAszpes($value)
 * @method static Builder|Asz00k3 whereAszpro($value)
 * @method static Builder|Asz00k3 whereAszprv($value)
 * @method static Builder|Asz00k3 whereAsztim($value)
 * @method static Builder|Asz00k3 whereAsztin($value)
 * @method static Builder|Asz00k3 whereAsztip($value)
 * @method static Builder|Asz00k3 whereAsztpr($value)
 * @method static Builder|Asz00k3 whereAszumi($value)
 * @method static Builder|Asz00k3 whereCont($value)
 * @method static Builder|Asz00k3 whereEnte($value)
 * @method static Builder|Asz00k3 whereId($value)
 * @method static Builder|Asz00k3 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Asz00k3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Asz00k3 extends BaseModel
{
    protected $table = 'asz00k3';
}
