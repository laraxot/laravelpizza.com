<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ced51f.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property int|null $dal
 * @property int|null $al
 * @property string|null $co1
 * @property string|null $co2
 * @property string|null $co3
 * @property string|null $co4
 * @property string|null $co5
 * @property string|null $co6
 * @property string|null $co7
 * @property string|null $co8
 * @property string|null $co9
 *
 * @method static Builder|Ced51f newModelQuery()
 * @method static Builder|Ced51f newQuery()
 * @method static Builder|Ced51f query()
 * @method static Builder|Ced51f whereAl($value)
 * @method static Builder|Ced51f whereCo1($value)
 * @method static Builder|Ced51f whereCo2($value)
 * @method static Builder|Ced51f whereCo3($value)
 * @method static Builder|Ced51f whereCo4($value)
 * @method static Builder|Ced51f whereCo5($value)
 * @method static Builder|Ced51f whereCo6($value)
 * @method static Builder|Ced51f whereCo7($value)
 * @method static Builder|Ced51f whereCo8($value)
 * @method static Builder|Ced51f whereCo9($value)
 * @method static Builder|Ced51f whereDal($value)
 * @method static Builder|Ced51f whereEnte($value)
 * @method static Builder|Ced51f whereId($value)
 * @method static Builder|Ced51f whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ced51fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ced51f extends BaseModel
{
    protected $table = 'ced51f';
}
