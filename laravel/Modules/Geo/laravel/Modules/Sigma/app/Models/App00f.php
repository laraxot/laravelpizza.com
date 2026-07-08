<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\App00f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $anzdal
 * @property string|null $anzal
 * @property string|null $anzvoc
 * @property string|null $anzini
 * @property string|null $anzfin
 * @property string|null $anznv
 * @property string|null $anzdif
 * @property string|null $anzeur
 *
 * @method static Builder|App00f newModelQuery()
 * @method static Builder|App00f newQuery()
 * @method static Builder|App00f query()
 * @method static Builder|App00f whereAnzal($value)
 * @method static Builder|App00f whereAnzdal($value)
 * @method static Builder|App00f whereAnzdif($value)
 * @method static Builder|App00f whereAnzeur($value)
 * @method static Builder|App00f whereAnzfin($value)
 * @method static Builder|App00f whereAnzini($value)
 * @method static Builder|App00f whereAnznv($value)
 * @method static Builder|App00f whereAnzvoc($value)
 * @method static Builder|App00f whereEnte($value)
 * @method static Builder|App00f whereId($value)
 * @method static Builder|App00f whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\App00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class App00f extends BaseModel
{
    protected $table = 'app00f';
}
