<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Valork1.
 *
 * @property int $id
 * @property string|null $ENTE
 * @property string|null $CONT
 * @property string|null $VALRAP
 * @property string|null $VALORA
 * @property string|null $VALDAL
 * @property string|null $VALAL
 * @property string|null $VALO
 * @property string|null $VALG
 * @property string|null $VALS
 * @property string|null $VALM
 * @property string|null $VALANN
 * @property string|null $VAL2KD
 * @property string|null $VAL2KA
 * @property string|null $VAL001
 * @property string|null $VAL002
 * @property string|null $VAL003
 * @property string|null $VAL004
 * @property string|null $VAL005
 *
 * @method static Builder|Valork1 newModelQuery()
 * @method static Builder|Valork1 newQuery()
 * @method static Builder|Valork1 query()
 * @method static Builder|Valork1 whereCONT($value)
 * @method static Builder|Valork1 whereENTE($value)
 * @method static Builder|Valork1 whereId($value)
 * @method static Builder|Valork1 whereVAL001($value)
 * @method static Builder|Valork1 whereVAL002($value)
 * @method static Builder|Valork1 whereVAL003($value)
 * @method static Builder|Valork1 whereVAL004($value)
 * @method static Builder|Valork1 whereVAL005($value)
 * @method static Builder|Valork1 whereVAL2KA($value)
 * @method static Builder|Valork1 whereVAL2KD($value)
 * @method static Builder|Valork1 whereVALAL($value)
 * @method static Builder|Valork1 whereVALANN($value)
 * @method static Builder|Valork1 whereVALDAL($value)
 * @method static Builder|Valork1 whereVALG($value)
 * @method static Builder|Valork1 whereVALM($value)
 * @method static Builder|Valork1 whereVALO($value)
 * @method static Builder|Valork1 whereVALORA($value)
 * @method static Builder|Valork1 whereVALRAP($value)
 * @method static Builder|Valork1 whereVALS($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Valork1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Valork1 extends BaseModel
{
    protected $table = 'valork1';
}
