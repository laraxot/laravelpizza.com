<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Mod00k1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $moddal
 * @property string|null $modal
 * @property string|null $orario
 * @property string|null $oraeff
 * @property string|null $oraann
 * @property string|null $mod2kd
 * @property string|null $mod2ka
 * @property string|null $mod001
 * @property string|null $mod002
 * @property string|null $mod003
 * @property string|null $mod004
 * @property string|null $mod005
 *
 * @method static Builder|Mod00k1 newModelQuery()
 * @method static Builder|Mod00k1 newQuery()
 * @method static Builder|Mod00k1 query()
 * @method static Builder|Mod00k1 whereEnte($value)
 * @method static Builder|Mod00k1 whereId($value)
 * @method static Builder|Mod00k1 whereMatr($value)
 * @method static Builder|Mod00k1 whereMod001($value)
 * @method static Builder|Mod00k1 whereMod002($value)
 * @method static Builder|Mod00k1 whereMod003($value)
 * @method static Builder|Mod00k1 whereMod004($value)
 * @method static Builder|Mod00k1 whereMod005($value)
 * @method static Builder|Mod00k1 whereMod2ka($value)
 * @method static Builder|Mod00k1 whereMod2kd($value)
 * @method static Builder|Mod00k1 whereModal($value)
 * @method static Builder|Mod00k1 whereModdal($value)
 * @method static Builder|Mod00k1 whereOraann($value)
 * @method static Builder|Mod00k1 whereOraeff($value)
 * @method static Builder|Mod00k1 whereOrario($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Mod00k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Mod00k1 extends BaseModel
{
    protected $table = 'mod00k1';
}
