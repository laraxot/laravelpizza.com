<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Tabo00l2.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $tablet
 * @property string|null $tabora
 * @property string|null $tabsta
 * @property string|null $tabrep
 * @property string|null $tabdai
 * @property string|null $tabdaf
 * @property string|null $tabco1
 * @property string|null $tabco2
 * @property string|null $tabco3
 * @property string|null $tabco4
 *
 * @method static Builder|Tabo00l2 newModelQuery()
 * @method static Builder|Tabo00l2 newQuery()
 * @method static Builder|Tabo00l2 query()
 * @method static Builder|Tabo00l2 whereEnteap($value)
 * @method static Builder|Tabo00l2 whereId($value)
 * @method static Builder|Tabo00l2 whereTabco1($value)
 * @method static Builder|Tabo00l2 whereTabco2($value)
 * @method static Builder|Tabo00l2 whereTabco3($value)
 * @method static Builder|Tabo00l2 whereTabco4($value)
 * @method static Builder|Tabo00l2 whereTabdaf($value)
 * @method static Builder|Tabo00l2 whereTabdai($value)
 * @method static Builder|Tabo00l2 whereTablet($value)
 * @method static Builder|Tabo00l2 whereTabora($value)
 * @method static Builder|Tabo00l2 whereTabrep($value)
 * @method static Builder|Tabo00l2 whereTabsta($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Tabo00l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Tabo00l2 extends BaseModel
{
    protected $table = 'tabo00l2';
}
