<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wcon01l1.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $wcdtda
 * @property string|null $wcdta
 * @property string|null $wcmatr
 * @property string|null $wccom1
 *
 * @method static Builder|Wcon01l1 newModelQuery()
 * @method static Builder|Wcon01l1 newQuery()
 * @method static Builder|Wcon01l1 query()
 * @method static Builder|Wcon01l1 whereEnteap($value)
 * @method static Builder|Wcon01l1 whereId($value)
 * @method static Builder|Wcon01l1 whereWccom1($value)
 * @method static Builder|Wcon01l1 whereWcdta($value)
 * @method static Builder|Wcon01l1 whereWcdtda($value)
 * @method static Builder|Wcon01l1 whereWcmatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wcon01l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wcon01l1 extends BaseModel
{
    protected $table = 'wcon01l1';
}
