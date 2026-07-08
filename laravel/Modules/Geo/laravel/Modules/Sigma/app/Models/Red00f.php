<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Red00f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $datstr
 * @property string|null $datend
 * @property string|null $statoc
 * @property string|null $tipnuc
 * @property string|null $nucleo
 * @property string|null $redfam
 * @property string|null $reddip
 * @property string|null $flaga
 *
 * @method static Builder|Red00f newModelQuery()
 * @method static Builder|Red00f newQuery()
 * @method static Builder|Red00f query()
 * @method static Builder|Red00f whereDatend($value)
 * @method static Builder|Red00f whereDatstr($value)
 * @method static Builder|Red00f whereEnte($value)
 * @method static Builder|Red00f whereFlaga($value)
 * @method static Builder|Red00f whereId($value)
 * @method static Builder|Red00f whereMatr($value)
 * @method static Builder|Red00f whereNucleo($value)
 * @method static Builder|Red00f whereReddip($value)
 * @method static Builder|Red00f whereRedfam($value)
 * @method static Builder|Red00f whereStatoc($value)
 * @method static Builder|Red00f whereTipnuc($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Red00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Red00f extends BaseModel
{
    protected $table = 'red00f';
}
