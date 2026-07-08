<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Tipmok1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $cont
 * @property string|null $tmotip
 * @property string|null $tmocod
 * @property string|null $tmodal
 * @property string|null $tmoal
 * @property string|null $tmoap
 * @property string|null $tmopes
 * @property string|null $tmoret
 * @property string|null $tmocf
 * @property string|null $tmorfr
 * @property string|null $tmocs
 * @property string|null $tmordf
 * @property string|null $tmoult
 * @property string|null $tmoann
 * @property string|null $tmoper
 * @property string|null $tretip
 * @property string|null $trecod
 * @property string|null $tmoseg
 * @property string|null $tmo2kd
 * @property string|null $tmo2ka
 * @property string|null $tmo001
 * @property string|null $tmo002
 * @property string|null $tmo003
 * @property string|null $tmo004
 * @property string|null $tmo005
 *
 * @method static Builder|Tipmok1 newModelQuery()
 * @method static Builder|Tipmok1 newQuery()
 * @method static Builder|Tipmok1 query()
 * @method static Builder|Tipmok1 whereCont($value)
 * @method static Builder|Tipmok1 whereEnte($value)
 * @method static Builder|Tipmok1 whereId($value)
 * @method static Builder|Tipmok1 whereTmo001($value)
 * @method static Builder|Tipmok1 whereTmo002($value)
 * @method static Builder|Tipmok1 whereTmo003($value)
 * @method static Builder|Tipmok1 whereTmo004($value)
 * @method static Builder|Tipmok1 whereTmo005($value)
 * @method static Builder|Tipmok1 whereTmo2ka($value)
 * @method static Builder|Tipmok1 whereTmo2kd($value)
 * @method static Builder|Tipmok1 whereTmoal($value)
 * @method static Builder|Tipmok1 whereTmoann($value)
 * @method static Builder|Tipmok1 whereTmoap($value)
 * @method static Builder|Tipmok1 whereTmocf($value)
 * @method static Builder|Tipmok1 whereTmocod($value)
 * @method static Builder|Tipmok1 whereTmocs($value)
 * @method static Builder|Tipmok1 whereTmodal($value)
 * @method static Builder|Tipmok1 whereTmoper($value)
 * @method static Builder|Tipmok1 whereTmopes($value)
 * @method static Builder|Tipmok1 whereTmordf($value)
 * @method static Builder|Tipmok1 whereTmoret($value)
 * @method static Builder|Tipmok1 whereTmorfr($value)
 * @method static Builder|Tipmok1 whereTmoseg($value)
 * @method static Builder|Tipmok1 whereTmotip($value)
 * @method static Builder|Tipmok1 whereTmoult($value)
 * @method static Builder|Tipmok1 whereTrecod($value)
 * @method static Builder|Tipmok1 whereTretip($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Tipmok1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Tipmok1 extends BaseModel
{
    protected $table = 'tipmok1';
}
