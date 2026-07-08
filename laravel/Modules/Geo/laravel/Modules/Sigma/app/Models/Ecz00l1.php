<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ecz00l1.
 *
 * @property int $id
 * @property string|null $eczann
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $ecztip
 * @property string|null $eczdal
 * @property string|null $eczal
 * @property string|null $eczpro
 * @property string|null $eczrec
 * @property string|null $eczrx
 * @property string|null $eczan
 * @property string|null $ecztor
 * @property string|null $ecz001
 * @property string|null $ecz002
 * @property string|null $ecz003
 * @property string|null $ecz004
 * @property string|null $ecz005
 * @property string|null $ecz011
 * @property string|null $ecz012
 * @property string|null $ecz013
 * @property string|null $ecz014
 * @property string|null $ecz015
 *
 * @method static Builder|Ecz00l1 newModelQuery()
 * @method static Builder|Ecz00l1 newQuery()
 * @method static Builder|Ecz00l1 query()
 * @method static Builder|Ecz00l1 whereEcz001($value)
 * @method static Builder|Ecz00l1 whereEcz002($value)
 * @method static Builder|Ecz00l1 whereEcz003($value)
 * @method static Builder|Ecz00l1 whereEcz004($value)
 * @method static Builder|Ecz00l1 whereEcz005($value)
 * @method static Builder|Ecz00l1 whereEcz011($value)
 * @method static Builder|Ecz00l1 whereEcz012($value)
 * @method static Builder|Ecz00l1 whereEcz013($value)
 * @method static Builder|Ecz00l1 whereEcz014($value)
 * @method static Builder|Ecz00l1 whereEcz015($value)
 * @method static Builder|Ecz00l1 whereEczal($value)
 * @method static Builder|Ecz00l1 whereEczan($value)
 * @method static Builder|Ecz00l1 whereEczann($value)
 * @method static Builder|Ecz00l1 whereEczdal($value)
 * @method static Builder|Ecz00l1 whereEczpro($value)
 * @method static Builder|Ecz00l1 whereEczrec($value)
 * @method static Builder|Ecz00l1 whereEczrx($value)
 * @method static Builder|Ecz00l1 whereEcztip($value)
 * @method static Builder|Ecz00l1 whereEcztor($value)
 * @method static Builder|Ecz00l1 whereEnte($value)
 * @method static Builder|Ecz00l1 whereId($value)
 * @method static Builder|Ecz00l1 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ecz00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ecz00l1 extends BaseModel
{
    protected $table = 'ecz00l1';
}
