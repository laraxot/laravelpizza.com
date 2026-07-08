<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Mico0f.
 *
 * @property int $id
 * @property string|null $contm
 * @property string|null $tipoco
 * @property string|null $livm
 * @property string|null $imp
 * @property string|null $impoeu
 * @property string|null $dal
 * @property string|null $al
 *
 * @method static Builder|Mico0f newModelQuery()
 * @method static Builder|Mico0f newQuery()
 * @method static Builder|Mico0f query()
 * @method static Builder|Mico0f whereAl($value)
 * @method static Builder|Mico0f whereContm($value)
 * @method static Builder|Mico0f whereDal($value)
 * @method static Builder|Mico0f whereId($value)
 * @method static Builder|Mico0f whereImp($value)
 * @method static Builder|Mico0f whereImpoeu($value)
 * @method static Builder|Mico0f whereLivm($value)
 * @method static Builder|Mico0f whereTipoco($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Mico0fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Mico0f extends BaseModel
{
    protected $table = 'mico0f';
}
