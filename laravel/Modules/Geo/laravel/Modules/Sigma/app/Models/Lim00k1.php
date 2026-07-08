<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Lim00k1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $tipa
 * @property string|null $coda
 * @property string|null $lidal
 * @property string|null $lial
 * @property string|null $lquant
 * @property string|null $ltlim
 * @property string|null $limpum
 * @property string|null $lim01
 * @property string|null $lim02
 * @property string|null $lmpann
 * @property string|null $li2kd
 * @property string|null $li2ka
 * @property string|null $li001
 * @property string|null $li002
 * @property string|null $li003
 * @property string|null $li004
 * @property string|null $li005
 *
 * @method static Builder|Lim00k1 newModelQuery()
 * @method static Builder|Lim00k1 newQuery()
 * @method static Builder|Lim00k1 query()
 * @method static Builder|Lim00k1 whereCoda($value)
 * @method static Builder|Lim00k1 whereEnte($value)
 * @method static Builder|Lim00k1 whereId($value)
 * @method static Builder|Lim00k1 whereLi001($value)
 * @method static Builder|Lim00k1 whereLi002($value)
 * @method static Builder|Lim00k1 whereLi003($value)
 * @method static Builder|Lim00k1 whereLi004($value)
 * @method static Builder|Lim00k1 whereLi005($value)
 * @method static Builder|Lim00k1 whereLi2ka($value)
 * @method static Builder|Lim00k1 whereLi2kd($value)
 * @method static Builder|Lim00k1 whereLial($value)
 * @method static Builder|Lim00k1 whereLidal($value)
 * @method static Builder|Lim00k1 whereLim01($value)
 * @method static Builder|Lim00k1 whereLim02($value)
 * @method static Builder|Lim00k1 whereLimpum($value)
 * @method static Builder|Lim00k1 whereLmpann($value)
 * @method static Builder|Lim00k1 whereLquant($value)
 * @method static Builder|Lim00k1 whereLtlim($value)
 * @method static Builder|Lim00k1 whereMatr($value)
 * @method static Builder|Lim00k1 whereTipa($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Lim00k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Lim00k1 extends BaseModel
{
    protected $table = 'lim00k1';
}
