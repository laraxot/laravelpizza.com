<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cod01f.
 *
 * @property int $id
 * @property string|null $TIPO
 * @property string|null $CODICE
 * @property string|null $CODREG
 * @property string|null $CODIC1
 * @property string|null $CODIC2
 * @property string|null $CODIC3
 * @property string|null $CODIC4
 * @property string|null $CODIC5
 *
 * @method static Builder|Cod01f newModelQuery()
 * @method static Builder|Cod01f newQuery()
 * @method static Builder|Cod01f query()
 * @method static Builder|Cod01f whereCODIC1($value)
 * @method static Builder|Cod01f whereCODIC2($value)
 * @method static Builder|Cod01f whereCODIC3($value)
 * @method static Builder|Cod01f whereCODIC4($value)
 * @method static Builder|Cod01f whereCODIC5($value)
 * @method static Builder|Cod01f whereCODICE($value)
 * @method static Builder|Cod01f whereCODREG($value)
 * @method static Builder|Cod01f whereId($value)
 * @method static Builder|Cod01f whereTIPO($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cod01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cod01f extends BaseModel
{
    protected $table = 'cod01f';
}
