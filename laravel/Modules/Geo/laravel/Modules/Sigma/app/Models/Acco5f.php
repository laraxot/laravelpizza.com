<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Acco5f.
 *
 * @property int $id
 * @property int $rap
 * @property int $pro
 * @property int $pos
 * @property int $vocac5
 * @property int $datac5
 * @property int $impac5
 *
 * @method static Builder|Acco5f newModelQuery()
 * @method static Builder|Acco5f newQuery()
 * @method static Builder|Acco5f query()
 * @method static Builder|Acco5f whereDatac5($value)
 * @method static Builder|Acco5f whereId($value)
 * @method static Builder|Acco5f whereImpac5($value)
 * @method static Builder|Acco5f wherePos($value)
 * @method static Builder|Acco5f wherePro($value)
 * @method static Builder|Acco5f whereRap($value)
 * @method static Builder|Acco5f whereVocac5($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Acco5fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Acco5f extends BaseModel
{
    protected $table = 'acco5f';
}
