<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Gapstaf.
 *
 * @property int $id
 * @property string|null $qent1
 * @property string|null $qtip1
 * @property string|null $qstab
 * @property string|null $qrepa
 * @property string|null $qdes1
 * @property string|null $qabi1
 *
 * @method static Builder|Gapstaf newModelQuery()
 * @method static Builder|Gapstaf newQuery()
 * @method static Builder|Gapstaf query()
 * @method static Builder|Gapstaf whereId($value)
 * @method static Builder|Gapstaf whereQabi1($value)
 * @method static Builder|Gapstaf whereQdes1($value)
 * @method static Builder|Gapstaf whereQent1($value)
 * @method static Builder|Gapstaf whereQrepa($value)
 * @method static Builder|Gapstaf whereQstab($value)
 * @method static Builder|Gapstaf whereQtip1($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\GapstafFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Gapstaf extends BaseModel
{
    protected $table = 'gapstaf';
}
