<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Pro00f.
 *
 * @property int $id
 * @property string|null $UTENTE
 * @property string|null $ENTE
 *
 * @method static Builder|Pro00f newModelQuery()
 * @method static Builder|Pro00f newQuery()
 * @method static Builder|Pro00f query()
 * @method static Builder|Pro00f whereENTE($value)
 * @method static Builder|Pro00f whereId($value)
 * @method static Builder|Pro00f whereUTENTE($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Pro00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Pro00f extends BaseModel
{
    protected $table = 'pro00f';
}
