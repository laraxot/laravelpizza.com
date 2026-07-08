<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wcon02l2.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $w2oann
 * @property string|null $w2omat
 * @property string|null $w2ddat
 * @property string|null $w2ogiu
 * @property string|null $w2olet
 * @property string|null $w2oora
 * @property string|null $w2oass
 *
 * @method static Builder|Wcon02l2 newModelQuery()
 * @method static Builder|Wcon02l2 newQuery()
 * @method static Builder|Wcon02l2 query()
 * @method static Builder|Wcon02l2 whereEnteap($value)
 * @method static Builder|Wcon02l2 whereId($value)
 * @method static Builder|Wcon02l2 whereW2ddat($value)
 * @method static Builder|Wcon02l2 whereW2oann($value)
 * @method static Builder|Wcon02l2 whereW2oass($value)
 * @method static Builder|Wcon02l2 whereW2ogiu($value)
 * @method static Builder|Wcon02l2 whereW2olet($value)
 * @method static Builder|Wcon02l2 whereW2omat($value)
 * @method static Builder|Wcon02l2 whereW2oora($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Wcon02l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wcon02l2 extends BaseModel
{
    protected $table = 'wcon02l2';
}
