<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Pro10f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $promen
 * @property string|null $propar
 * @property string|null $proabi
 *
 * @method static Builder|Pro10f newModelQuery()
 * @method static Builder|Pro10f newQuery()
 * @method static Builder|Pro10f query()
 * @method static Builder|Pro10f whereEnte($value)
 * @method static Builder|Pro10f whereId($value)
 * @method static Builder|Pro10f whereProabi($value)
 * @method static Builder|Pro10f wherePromen($value)
 * @method static Builder|Pro10f wherePropar($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Pro10fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Pro10f extends BaseModel
{
    protected $table = 'pro10f';
}
