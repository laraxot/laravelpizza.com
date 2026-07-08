<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\App00l1.
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
 * @method static Builder|App00l1 newModelQuery()
 * @method static Builder|App00l1 newQuery()
 * @method static Builder|App00l1 query()
 * @method static Builder|App00l1 whereAnzal($value)
 * @method static Builder|App00l1 whereAnzdal($value)
 * @method static Builder|App00l1 whereAnzdif($value)
 * @method static Builder|App00l1 whereAnzeur($value)
 * @method static Builder|App00l1 whereAnzfin($value)
 * @method static Builder|App00l1 whereAnzini($value)
 * @method static Builder|App00l1 whereAnznv($value)
 * @method static Builder|App00l1 whereAnzvoc($value)
 * @method static Builder|App00l1 whereEnte($value)
 * @method static Builder|App00l1 whereId($value)
 * @method static Builder|App00l1 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\App00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class App00l1 extends BaseModel
{
    protected $table = 'app00l1';
}
