<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Limitk1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $cont
 * @property string|null $limora
 * @property string|null $limtip
 * @property string|null $limcod
 * @property string|null $limrap
 * @property string|null $limdal
 * @property string|null $limal
 * @property string|null $limcup
 * @property string|null $limcum
 * @property string|null $effcup
 * @property string|null $effcum
 * @property string|null $limum
 * @property string|null $limper
 * @property string|null $limt1
 * @property string|null $limc1
 * @property string|null $limann
 * @property string|null $lim2kd
 * @property string|null $lim2ka
 * @property string|null $lim001
 * @property string|null $lim002
 * @property string|null $lim003
 * @property string|null $lim004
 * @property string|null $lim005
 *
 * @method static Builder|Limitk1 newModelQuery()
 * @method static Builder|Limitk1 newQuery()
 * @method static Builder|Limitk1 query()
 * @method static Builder|Limitk1 whereCont($value)
 * @method static Builder|Limitk1 whereEffcum($value)
 * @method static Builder|Limitk1 whereEffcup($value)
 * @method static Builder|Limitk1 whereEnte($value)
 * @method static Builder|Limitk1 whereId($value)
 * @method static Builder|Limitk1 whereLim001($value)
 * @method static Builder|Limitk1 whereLim002($value)
 * @method static Builder|Limitk1 whereLim003($value)
 * @method static Builder|Limitk1 whereLim004($value)
 * @method static Builder|Limitk1 whereLim005($value)
 * @method static Builder|Limitk1 whereLim2ka($value)
 * @method static Builder|Limitk1 whereLim2kd($value)
 * @method static Builder|Limitk1 whereLimal($value)
 * @method static Builder|Limitk1 whereLimann($value)
 * @method static Builder|Limitk1 whereLimc1($value)
 * @method static Builder|Limitk1 whereLimcod($value)
 * @method static Builder|Limitk1 whereLimcum($value)
 * @method static Builder|Limitk1 whereLimcup($value)
 * @method static Builder|Limitk1 whereLimdal($value)
 * @method static Builder|Limitk1 whereLimora($value)
 * @method static Builder|Limitk1 whereLimper($value)
 * @method static Builder|Limitk1 whereLimrap($value)
 * @method static Builder|Limitk1 whereLimt1($value)
 * @method static Builder|Limitk1 whereLimtip($value)
 * @method static Builder|Limitk1 whereLimum($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Limitk1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Limitk1 extends BaseModel
{
    protected $table = 'limitk1';
}
