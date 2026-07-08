<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Sto00k1.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property int|null $stass
 * @property int|null $stdim
 * @property int|null $stupd
 * @property int|null $tipass
 * @property int|null $tipdim
 * @property string|null $stann
 * @property int|null $stotia
 * @property int|null $stotil
 * @property int|null $stodaa
 * @property int|null $stodal
 * @property string|null $stonua
 * @property string|null $stonul
 * @property int|null $st2kas
 * @property int|null $st2kdi
 * @property int|null $st2ku
 * @property int|null $sto2ka
 * @property int|null $sto2kd
 * @property int|null $matina
 * @property int|null $sto001
 * @property string|null $sto002
 * @property string|null $sto003
 * @property int|null $sto004
 * @property int|null $sto005
 *
 * @method static Builder|Sto00k1 newModelQuery()
 * @method static Builder|Sto00k1 newQuery()
 * @method static Builder|Sto00k1 query()
 * @method static Builder|Sto00k1 whereEnte($value)
 * @method static Builder|Sto00k1 whereId($value)
 * @method static Builder|Sto00k1 whereMatina($value)
 * @method static Builder|Sto00k1 whereMatr($value)
 * @method static Builder|Sto00k1 whereSt2kas($value)
 * @method static Builder|Sto00k1 whereSt2kdi($value)
 * @method static Builder|Sto00k1 whereSt2ku($value)
 * @method static Builder|Sto00k1 whereStann($value)
 * @method static Builder|Sto00k1 whereStass($value)
 * @method static Builder|Sto00k1 whereStdim($value)
 * @method static Builder|Sto00k1 whereSto001($value)
 * @method static Builder|Sto00k1 whereSto002($value)
 * @method static Builder|Sto00k1 whereSto003($value)
 * @method static Builder|Sto00k1 whereSto004($value)
 * @method static Builder|Sto00k1 whereSto005($value)
 * @method static Builder|Sto00k1 whereSto2ka($value)
 * @method static Builder|Sto00k1 whereSto2kd($value)
 * @method static Builder|Sto00k1 whereStodaa($value)
 * @method static Builder|Sto00k1 whereStodal($value)
 * @method static Builder|Sto00k1 whereStonua($value)
 * @method static Builder|Sto00k1 whereStonul($value)
 * @method static Builder|Sto00k1 whereStotia($value)
 * @method static Builder|Sto00k1 whereStotil($value)
 * @method static Builder|Sto00k1 whereStupd($value)
 * @method static Builder|Sto00k1 whereTipass($value)
 * @method static Builder|Sto00k1 whereTipdim($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Sto00k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Sto00k1 extends BaseModel
{
    protected $table = 'sto00k1';
}
