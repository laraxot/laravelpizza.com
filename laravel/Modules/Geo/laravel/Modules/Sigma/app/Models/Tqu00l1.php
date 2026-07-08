<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Tqu00l1.
 *
 * @property int $id
 * @property string|null $cont
 * @property string|null $tipco
 * @property string|null $rapp
 * @property string|null $ruolo
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $codqua
 * @property string|null $codinq
 * @property string|null $desc1
 * @property string|null $desc2
 * @property string|null $liv
 * @property string|null $tqann
 *
 * @method static Builder|Tqu00l1 newModelQuery()
 * @method static Builder|Tqu00l1 newQuery()
 * @method static Builder|Tqu00l1 query()
 * @method static Builder|Tqu00l1 whereCodinq($value)
 * @method static Builder|Tqu00l1 whereCodqua($value)
 * @method static Builder|Tqu00l1 whereCont($value)
 * @method static Builder|Tqu00l1 whereDesc1($value)
 * @method static Builder|Tqu00l1 whereDesc2($value)
 * @method static Builder|Tqu00l1 whereId($value)
 * @method static Builder|Tqu00l1 whereLiv($value)
 * @method static Builder|Tqu00l1 wherePosfun($value)
 * @method static Builder|Tqu00l1 wherePropro($value)
 * @method static Builder|Tqu00l1 whereRapp($value)
 * @method static Builder|Tqu00l1 whereRuolo($value)
 * @method static Builder|Tqu00l1 whereTipco($value)
 * @method static Builder|Tqu00l1 whereTqann($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Tqu00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Tqu00l1 extends BaseModel
{
    protected $table = 'tqu00l1';
}
