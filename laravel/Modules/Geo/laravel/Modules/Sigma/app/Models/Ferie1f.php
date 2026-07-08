<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ferie1f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $f1aa
 * @property string|null $f1tip
 * @property string|null $f1dat1
 * @property string|null $f1ora1
 * @property string|null $f1dat2
 * @property string|null $f1ora2
 * @property string|null $f1dat3
 * @property string|null $f1fas
 * @property string|null $f1ann
 *
 * @method static Builder|Ferie1f newModelQuery()
 * @method static Builder|Ferie1f newQuery()
 * @method static Builder|Ferie1f query()
 * @method static Builder|Ferie1f whereEnte($value)
 * @method static Builder|Ferie1f whereF1aa($value)
 * @method static Builder|Ferie1f whereF1ann($value)
 * @method static Builder|Ferie1f whereF1dat1($value)
 * @method static Builder|Ferie1f whereF1dat2($value)
 * @method static Builder|Ferie1f whereF1dat3($value)
 * @method static Builder|Ferie1f whereF1fas($value)
 * @method static Builder|Ferie1f whereF1ora1($value)
 * @method static Builder|Ferie1f whereF1ora2($value)
 * @method static Builder|Ferie1f whereF1tip($value)
 * @method static Builder|Ferie1f whereId($value)
 * @method static Builder|Ferie1f whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ferie1fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ferie1f extends BaseModel
{
    protected $table = 'ferie1f';
}
