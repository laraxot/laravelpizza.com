<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Acp00f.
 *
 * @property int $id
 *
 * @method static Builder|Acp00f newModelQuery()
 * @method static Builder|Acp00f newQuery()
 * @method static Builder|Acp00f query()
 * @method static Builder|Acp00f whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Acp00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Acp00f extends BaseModel
{
    protected $table = 'acp00f';
}
