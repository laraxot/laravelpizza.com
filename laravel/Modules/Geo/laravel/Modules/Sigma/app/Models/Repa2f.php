<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repa2f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $stabi
 * @property string|null $repar
 * @property string|null $liv1
 * @property string|null $liv2
 * @property string|null $liv3
 * @property string|null $liv4
 * @property string|null $liv5
 * @property string|null $liv6
 * @property string|null $liv7
 * @property string|null $liv8
 * @property string|null $liv9
 * @property string|null $liv10
 * @property string|null $liv11
 * @property string|null $coirap
 *
 * @method static Builder|Repa2f newModelQuery()
 * @method static Builder|Repa2f newQuery()
 * @method static Builder|Repa2f query()
 * @method static Builder|Repa2f whereCoirap($value)
 * @method static Builder|Repa2f whereEnte($value)
 * @method static Builder|Repa2f whereId($value)
 * @method static Builder|Repa2f whereLiv1($value)
 * @method static Builder|Repa2f whereLiv10($value)
 * @method static Builder|Repa2f whereLiv11($value)
 * @method static Builder|Repa2f whereLiv2($value)
 * @method static Builder|Repa2f whereLiv3($value)
 * @method static Builder|Repa2f whereLiv4($value)
 * @method static Builder|Repa2f whereLiv5($value)
 * @method static Builder|Repa2f whereLiv6($value)
 * @method static Builder|Repa2f whereLiv7($value)
 * @method static Builder|Repa2f whereLiv8($value)
 * @method static Builder|Repa2f whereLiv9($value)
 * @method static Builder|Repa2f whereRepar($value)
 * @method static Builder|Repa2f whereStabi($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repa2fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repa2f extends BaseModel
{
    protected $table = 'repa2f';
}
