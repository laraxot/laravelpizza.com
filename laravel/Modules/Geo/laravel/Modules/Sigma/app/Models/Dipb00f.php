<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Dipb00f.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $dbannu
 * @property string|null $dbmatr
 * @property string|null $dbbadg
 * @property string|null $dbdal
 * @property string|null $dbal
 * @property string|null $dbcom1
 * @property string|null $dbcom2
 * @property string|null $dbcom3
 * @property string|null $dbcom4
 *
 * @method static Builder|Dipb00f newModelQuery()
 * @method static Builder|Dipb00f newQuery()
 * @method static Builder|Dipb00f query()
 * @method static Builder|Dipb00f whereDbal($value)
 * @method static Builder|Dipb00f whereDbannu($value)
 * @method static Builder|Dipb00f whereDbbadg($value)
 * @method static Builder|Dipb00f whereDbcom1($value)
 * @method static Builder|Dipb00f whereDbcom2($value)
 * @method static Builder|Dipb00f whereDbcom3($value)
 * @method static Builder|Dipb00f whereDbcom4($value)
 * @method static Builder|Dipb00f whereDbdal($value)
 * @method static Builder|Dipb00f whereDbmatr($value)
 * @method static Builder|Dipb00f whereEnteap($value)
 * @method static Builder|Dipb00f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Dipb00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Dipb00f extends BaseModel
{
    protected $table = 'dipb00f';
}
