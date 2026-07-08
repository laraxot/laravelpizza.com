<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Dip00f.
 *
 * @property int $id
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $codqua
 * @property string|null $liv
 * @property string|null $qualif
 *
 * @method static Builder|Dip00f newModelQuery()
 * @method static Builder|Dip00f newQuery()
 * @method static Builder|Dip00f query()
 * @method static Builder|Dip00f whereCodqua($value)
 * @method static Builder|Dip00f whereId($value)
 * @method static Builder|Dip00f whereLiv($value)
 * @method static Builder|Dip00f wherePosfun($value)
 * @method static Builder|Dip00f wherePropro($value)
 * @method static Builder|Dip00f whereQualif($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Dip00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Dip00f extends BaseModel
{
    protected $table = 'dip00f';
}
