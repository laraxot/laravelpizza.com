<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ripo00l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $ripaa
 * @property string|null $riprip
 * @property string|null $ripaut
 * @property string|null $ripfes
 * @property string|null $ripflg
 * @property string|null $ripann
 *
 * @method static Builder|Ripo00l1 newModelQuery()
 * @method static Builder|Ripo00l1 newQuery()
 * @method static Builder|Ripo00l1 query()
 * @method static Builder|Ripo00l1 whereEnte($value)
 * @method static Builder|Ripo00l1 whereId($value)
 * @method static Builder|Ripo00l1 whereMatr($value)
 * @method static Builder|Ripo00l1 whereRipaa($value)
 * @method static Builder|Ripo00l1 whereRipann($value)
 * @method static Builder|Ripo00l1 whereRipaut($value)
 * @method static Builder|Ripo00l1 whereRipfes($value)
 * @method static Builder|Ripo00l1 whereRipflg($value)
 * @method static Builder|Ripo00l1 whereRiprip($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ripo00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ripo00l1 extends BaseModel
{
    protected $table = 'ripo00l1';
}
