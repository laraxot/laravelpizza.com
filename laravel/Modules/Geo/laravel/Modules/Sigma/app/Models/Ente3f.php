<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ente3f.
 *
 * @property int $id
 * @property string|null $ente3
 * @property string|null $en3dtp
 * @property string|null $en3dti
 * @property string|null $en3tel
 * @property string|null $en3fax
 * @property string|null $en3ema
 * @property string|null $tipent
 * @property string|null $valuta
 * @property string|null $arroto
 *
 * @method static Builder|Ente3f newModelQuery()
 * @method static Builder|Ente3f newQuery()
 * @method static Builder|Ente3f query()
 * @method static Builder|Ente3f whereArroto($value)
 * @method static Builder|Ente3f whereEn3dti($value)
 * @method static Builder|Ente3f whereEn3dtp($value)
 * @method static Builder|Ente3f whereEn3ema($value)
 * @method static Builder|Ente3f whereEn3fax($value)
 * @method static Builder|Ente3f whereEn3tel($value)
 * @method static Builder|Ente3f whereEnte3($value)
 * @method static Builder|Ente3f whereId($value)
 * @method static Builder|Ente3f whereTipent($value)
 * @method static Builder|Ente3f whereValuta($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ente3fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ente3f extends BaseModel
{
    protected $table = 'ente3f';
}
