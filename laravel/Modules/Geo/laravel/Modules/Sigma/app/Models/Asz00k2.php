<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Asz00k2.
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
 * @property int $asztim
 * @property string $aszpro
 * @property int $aszprv
 * @property string $aszann
 * @property int $asz2kd
 * @property int $asz2ka
 * @property int $asz2kc
 * @property int $asz2kp
 * @property int $asz2kz
 * @property string $aszeup
 * @property int $asztin
 * @property int $asz001
 * @property string $asz002
 * @property string $asz003
 * @property int $asz004
 * @property int $asz005
 *
 * @method static Builder|Asz00k2 newModelQuery()
 * @method static Builder|Asz00k2 newQuery()
 * @method static Builder|Asz00k2 query()
 * @method static Builder|Asz00k2 whereAsz001($value)
 * @method static Builder|Asz00k2 whereAsz002($value)
 * @method static Builder|Asz00k2 whereAsz003($value)
 * @method static Builder|Asz00k2 whereAsz004($value)
 * @method static Builder|Asz00k2 whereAsz005($value)
 * @method static Builder|Asz00k2 whereAsz01($value)
 * @method static Builder|Asz00k2 whereAsz02($value)
 * @method static Builder|Asz00k2 whereAsz03($value)
 * @method static Builder|Asz00k2 whereAsz04($value)
 * @method static Builder|Asz00k2 whereAsz05($value)
 * @method static Builder|Asz00k2 whereAsz2ka($value)
 * @method static Builder|Asz00k2 whereAsz2kc($value)
 * @method static Builder|Asz00k2 whereAsz2kd($value)
 * @method static Builder|Asz00k2 whereAsz2kp($value)
 * @method static Builder|Asz00k2 whereAsz2kz($value)
 * @method static Builder|Asz00k2 whereAszal($value)
 * @method static Builder|Asz00k2 whereAszann($value)
 * @method static Builder|Asz00k2 whereAszcm($value)
 * @method static Builder|Asz00k2 whereAszcms($value)
 * @method static Builder|Asz00k2 whereAszcod($value)
 * @method static Builder|Asz00k2 whereAszcom($value)
 * @method static Builder|Asz00k2 whereAszdal($value)
 * @method static Builder|Asz00k2 whereAszdpr($value)
 * @method static Builder|Asz00k2 whereAszdur($value)
 * @method static Builder|Asz00k2 whereAszeup($value)
 * @method static Builder|Asz00k2 whereAszfin($value)
 * @method static Builder|Asz00k2 whereAszini($value)
 * @method static Builder|Asz00k2 whereAsznpr($value)
 * @method static Builder|Asz00k2 whereAszpes($value)
 * @method static Builder|Asz00k2 whereAszpro($value)
 * @method static Builder|Asz00k2 whereAszprv($value)
 * @method static Builder|Asz00k2 whereAsztim($value)
 * @method static Builder|Asz00k2 whereAsztin($value)
 * @method static Builder|Asz00k2 whereAsztip($value)
 * @method static Builder|Asz00k2 whereAsztpr($value)
 * @method static Builder|Asz00k2 whereAszumi($value)
 * @method static Builder|Asz00k2 whereCont($value)
 * @method static Builder|Asz00k2 whereEnte($value)
 * @method static Builder|Asz00k2 whereId($value)
 * @method static Builder|Asz00k2 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Asz00k2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Asz00k2 extends BaseModel
{
    protected $table = 'asz00k2';
}
