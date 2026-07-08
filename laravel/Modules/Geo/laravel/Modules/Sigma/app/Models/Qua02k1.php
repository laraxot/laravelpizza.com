<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua02k1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $qudal
 * @property string|null $qual
 * @property string|null $ruo
 * @property string|null $pro
 * @property string|null $fun
 * @property string|null $anz
 * @property string|null $imp
 * @property string|null $impeur
 * @property string|null $s01
 * @property string|null $s02
 * @property string|null $s05
 * @property string|null $flga
 * @property string|null $qua2kd
 * @property string|null $qua2ka
 * @property string|null $anz2k
 * @property string|null $k01
 * @property string|null $k05
 * @property string|null $e02
 * @property string|null $e05
 * @property string|null $qua001
 * @property string|null $qua002
 * @property string|null $qua003
 * @property string|null $qua004
 * @property string|null $qua005
 *
 * @method static Builder|Qua02k1 newModelQuery()
 * @method static Builder|Qua02k1 newQuery()
 * @method static Builder|Qua02k1 query()
 * @method static Builder|Qua02k1 whereAnz($value)
 * @method static Builder|Qua02k1 whereAnz2k($value)
 * @method static Builder|Qua02k1 whereE02($value)
 * @method static Builder|Qua02k1 whereE05($value)
 * @method static Builder|Qua02k1 whereEnte($value)
 * @method static Builder|Qua02k1 whereFlga($value)
 * @method static Builder|Qua02k1 whereFun($value)
 * @method static Builder|Qua02k1 whereId($value)
 * @method static Builder|Qua02k1 whereImp($value)
 * @method static Builder|Qua02k1 whereImpeur($value)
 * @method static Builder|Qua02k1 whereK01($value)
 * @method static Builder|Qua02k1 whereK05($value)
 * @method static Builder|Qua02k1 whereMatr($value)
 * @method static Builder|Qua02k1 wherePro($value)
 * @method static Builder|Qua02k1 whereQua001($value)
 * @method static Builder|Qua02k1 whereQua002($value)
 * @method static Builder|Qua02k1 whereQua003($value)
 * @method static Builder|Qua02k1 whereQua004($value)
 * @method static Builder|Qua02k1 whereQua005($value)
 * @method static Builder|Qua02k1 whereQua2ka($value)
 * @method static Builder|Qua02k1 whereQua2kd($value)
 * @method static Builder|Qua02k1 whereQual($value)
 * @method static Builder|Qua02k1 whereQudal($value)
 * @method static Builder|Qua02k1 whereRuo($value)
 * @method static Builder|Qua02k1 whereS01($value)
 * @method static Builder|Qua02k1 whereS02($value)
 * @method static Builder|Qua02k1 whereS05($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua02k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua02k1 extends BaseModel
{
    protected $table = 'qua02k1';
}
