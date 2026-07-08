<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Dipb00l1.
 *
 * @property int $id
 * @property int|null $enteap
 * @property string|null $dbannu
 * @property int|null $dbmatr
 * @property int|null $dbbadg
 * @property int|null $dbdal
 * @property int|null $dbal
 * @property string|null $dbcom1
 * @property string|null $dbcom2
 * @property int|null $dbcom3
 * @property int|null $dbcom4
 *
 * @method static Builder|Dipb00l1 newModelQuery()
 * @method static Builder|Dipb00l1 newQuery()
 * @method static Builder|Dipb00l1 query()
 * @method static Builder|Dipb00l1 whereDbal($value)
 * @method static Builder|Dipb00l1 whereDbannu($value)
 * @method static Builder|Dipb00l1 whereDbbadg($value)
 * @method static Builder|Dipb00l1 whereDbcom1($value)
 * @method static Builder|Dipb00l1 whereDbcom2($value)
 * @method static Builder|Dipb00l1 whereDbcom3($value)
 * @method static Builder|Dipb00l1 whereDbcom4($value)
 * @method static Builder|Dipb00l1 whereDbdal($value)
 * @method static Builder|Dipb00l1 whereDbmatr($value)
 * @method static Builder|Dipb00l1 whereEnteap($value)
 * @method static Builder|Dipb00l1 whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Dipb00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Dipb00l1 extends BaseModel
{
    protected $table = 'dipb00l1';
}
