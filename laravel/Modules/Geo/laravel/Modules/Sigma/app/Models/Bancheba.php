<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Bancheba.
 *
 * @property int $id
 * @property string|null $banca
 * @property string|null $agenz
 * @property string|null $desban
 *
 * @method static Builder|Bancheba newModelQuery()
 * @method static Builder|Bancheba newQuery()
 * @method static Builder|Bancheba query()
 * @method static Builder|Bancheba whereAgenz($value)
 * @method static Builder|Bancheba whereBanca($value)
 * @method static Builder|Bancheba whereDesban($value)
 * @method static Builder|Bancheba whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\BanchebaFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Bancheba extends BaseModel
{
    protected $table = 'bancheba';
}
