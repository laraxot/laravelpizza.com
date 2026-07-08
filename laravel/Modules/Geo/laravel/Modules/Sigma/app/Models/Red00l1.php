<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Red00l1.
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
 * @method static Builder|Red00l1 newModelQuery()
 * @method static Builder|Red00l1 newQuery()
 * @method static Builder|Red00l1 query()
 * @method static Builder|Red00l1 whereDatend($value)
 * @method static Builder|Red00l1 whereDatstr($value)
 * @method static Builder|Red00l1 whereEnte($value)
 * @method static Builder|Red00l1 whereFlaga($value)
 * @method static Builder|Red00l1 whereId($value)
 * @method static Builder|Red00l1 whereMatr($value)
 * @method static Builder|Red00l1 whereNucleo($value)
 * @method static Builder|Red00l1 whereReddip($value)
 * @method static Builder|Red00l1 whereRedfam($value)
 * @method static Builder|Red00l1 whereStatoc($value)
 * @method static Builder|Red00l1 whereTipnuc($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Red00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Red00l1 extends BaseModel
{
    protected $table = 'red00l1';
}
