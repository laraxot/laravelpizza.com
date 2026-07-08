<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Pro01f.
 *
 * @property int $id
 * @property string|null $utente
 * @property string|null $usta
 * @property string|null $urep
 *
 * @method static Builder|Pro01f newModelQuery()
 * @method static Builder|Pro01f newQuery()
 * @method static Builder|Pro01f query()
 * @method static Builder|Pro01f whereId($value)
 * @method static Builder|Pro01f whereUrep($value)
 * @method static Builder|Pro01f whereUsta($value)
 * @method static Builder|Pro01f whereUtente($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Pro01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Pro01f extends BaseModel
{
    protected $table = 'pro01f';
}
