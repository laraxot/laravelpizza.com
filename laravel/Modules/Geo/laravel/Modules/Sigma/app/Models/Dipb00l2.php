<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Dipb00l2.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $dbannu
 * @property string|null $dbmatr
 * @property string|null $dbbadg
 * @property string|null $dbdal
 * @property string|null $dbal
 * @property string|null $dbcom1
 * @property string|null $dbcom2
 * @property string|null $dbcom3
 * @property string|null $dbcom4
 *
 * @method static Builder|Dipb00l2 newModelQuery()
 * @method static Builder|Dipb00l2 newQuery()
 * @method static Builder|Dipb00l2 query()
 * @method static Builder|Dipb00l2 whereDbal($value)
 * @method static Builder|Dipb00l2 whereDbannu($value)
 * @method static Builder|Dipb00l2 whereDbbadg($value)
 * @method static Builder|Dipb00l2 whereDbcom1($value)
 * @method static Builder|Dipb00l2 whereDbcom2($value)
 * @method static Builder|Dipb00l2 whereDbcom3($value)
 * @method static Builder|Dipb00l2 whereDbcom4($value)
 * @method static Builder|Dipb00l2 whereDbdal($value)
 * @method static Builder|Dipb00l2 whereDbmatr($value)
 * @method static Builder|Dipb00l2 whereEnteap($value)
 * @method static Builder|Dipb00l2 whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Dipb00l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Dipb00l2 extends BaseModel
{
    protected $table = 'dipb00l2';
}
