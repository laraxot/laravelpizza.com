<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Pers01f.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $pepgm
 * @property string|null $periga
 * @property string|null $peprov
 * @property string|null $pepers
 * @property string|null $pedal
 * @property string|null $peal
 *
 * @method static Builder|Pers01f newModelQuery()
 * @method static Builder|Pers01f newQuery()
 * @method static Builder|Pers01f query()
 * @method static Builder|Pers01f whereEnteap($value)
 * @method static Builder|Pers01f whereId($value)
 * @method static Builder|Pers01f wherePeal($value)
 * @method static Builder|Pers01f wherePedal($value)
 * @method static Builder|Pers01f wherePepers($value)
 * @method static Builder|Pers01f wherePepgm($value)
 * @method static Builder|Pers01f wherePeprov($value)
 * @method static Builder|Pers01f wherePeriga($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Pers01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Pers01f extends BaseModel
{
    protected $table = 'pers01f';
}
