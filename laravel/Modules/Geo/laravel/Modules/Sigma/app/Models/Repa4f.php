<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Repa4f.
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
 * @property string|null $r4dai
 * @property string|null $r4daf
 *
 * @method static Builder|Repa4f newModelQuery()
 * @method static Builder|Repa4f newQuery()
 * @method static Builder|Repa4f query()
 * @method static Builder|Repa4f whereCoirap($value)
 * @method static Builder|Repa4f whereEnte($value)
 * @method static Builder|Repa4f whereId($value)
 * @method static Builder|Repa4f whereLiv1($value)
 * @method static Builder|Repa4f whereLiv10($value)
 * @method static Builder|Repa4f whereLiv11($value)
 * @method static Builder|Repa4f whereLiv2($value)
 * @method static Builder|Repa4f whereLiv3($value)
 * @method static Builder|Repa4f whereLiv4($value)
 * @method static Builder|Repa4f whereLiv5($value)
 * @method static Builder|Repa4f whereLiv6($value)
 * @method static Builder|Repa4f whereLiv7($value)
 * @method static Builder|Repa4f whereLiv8($value)
 * @method static Builder|Repa4f whereLiv9($value)
 * @method static Builder|Repa4f whereR4daf($value)
 * @method static Builder|Repa4f whereR4dai($value)
 * @method static Builder|Repa4f whereRepar($value)
 * @method static Builder|Repa4f whereStabi($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Repa4fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Repa4f extends BaseModel
{
    protected $table = 'repa4f';
}
