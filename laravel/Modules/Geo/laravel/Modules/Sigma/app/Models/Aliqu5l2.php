<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Aliqu5l2.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $q32kd
 * @property string|null $q32ka
 * @property string|null $q32ka2
 * @property string|null $q32ka1
 * @property string|null $q3003
 * @property string|null $q3cont
 * @property string|null $q3pro
 * @property string|null $q3voc1
 * @property string|null $q3desc
 * @property string|null $q3des2
 * @property string|null $q3des3
 * @property string|null $q3004
 * @property string|null $dq3004
 * @property string|null $q3005
 * @property string|null $dq3005
 * @property string|null $strco1
 * @property string|null $desstr
 * @property string|null $sstco1
 * @property string|null $dessst
 * @property string|null $artco1
 * @property string|null $desart
 * @property string|null $lib001
 * @property string|null $lib002
 *
 * @method static Builder|Aliqu5l2 newModelQuery()
 * @method static Builder|Aliqu5l2 newQuery()
 * @method static Builder|Aliqu5l2 query()
 * @method static Builder|Aliqu5l2 whereArtco1($value)
 * @method static Builder|Aliqu5l2 whereConome($value)
 * @method static Builder|Aliqu5l2 whereDesart($value)
 * @method static Builder|Aliqu5l2 whereDessst($value)
 * @method static Builder|Aliqu5l2 whereDesstr($value)
 * @method static Builder|Aliqu5l2 whereDq3004($value)
 * @method static Builder|Aliqu5l2 whereDq3005($value)
 * @method static Builder|Aliqu5l2 whereEnte($value)
 * @method static Builder|Aliqu5l2 whereId($value)
 * @method static Builder|Aliqu5l2 whereLib001($value)
 * @method static Builder|Aliqu5l2 whereLib002($value)
 * @method static Builder|Aliqu5l2 whereMatr($value)
 * @method static Builder|Aliqu5l2 whereNome($value)
 * @method static Builder|Aliqu5l2 whereQ3003($value)
 * @method static Builder|Aliqu5l2 whereQ3004($value)
 * @method static Builder|Aliqu5l2 whereQ3005($value)
 * @method static Builder|Aliqu5l2 whereQ32ka($value)
 * @method static Builder|Aliqu5l2 whereQ32ka1($value)
 * @method static Builder|Aliqu5l2 whereQ32ka2($value)
 * @method static Builder|Aliqu5l2 whereQ32kd($value)
 * @method static Builder|Aliqu5l2 whereQ3cont($value)
 * @method static Builder|Aliqu5l2 whereQ3des2($value)
 * @method static Builder|Aliqu5l2 whereQ3des3($value)
 * @method static Builder|Aliqu5l2 whereQ3desc($value)
 * @method static Builder|Aliqu5l2 whereQ3pro($value)
 * @method static Builder|Aliqu5l2 whereQ3voc1($value)
 * @method static Builder|Aliqu5l2 whereSstco1($value)
 * @method static Builder|Aliqu5l2 whereStrco1($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Aliqu5l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Aliqu5l2 extends BaseModel
{
    protected $table = 'aliqu5l2';
}
