<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Asp00f.
 *
 * @property int $id
 * @property string|null $ENTE
 * @property string|null $MATR
 * @property string|null $TIPASP
 * @property string|null $ASPANN
 * @property string|null $ASP2KI
 * @property string|null $ASP2KF
 * @property string|null $ASP2KC
 * @property string|null $ASP2KP
 *
 * @method static Builder|Asp00f newModelQuery()
 * @method static Builder|Asp00f newQuery()
 * @method static Builder|Asp00f query()
 * @method static Builder|Asp00f whereASP2KC($value)
 * @method static Builder|Asp00f whereASP2KF($value)
 * @method static Builder|Asp00f whereASP2KI($value)
 * @method static Builder|Asp00f whereASP2KP($value)
 * @method static Builder|Asp00f whereASPANN($value)
 * @method static Builder|Asp00f whereENTE($value)
 * @method static Builder|Asp00f whereId($value)
 * @method static Builder|Asp00f whereMATR($value)
 * @method static Builder|Asp00f whereTIPASP($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Asp00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Asp00f extends BaseModel
{
    protected $table = 'asp00f';
}
