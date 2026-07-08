<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\All02f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $ktipo
 * @property string|null $kcodic
 * @property string|null $kodreg
 * @property string|null $a01mm
 * @property string|null $a01aa
 * @property string|null $impmes
 * @property string|null $impneg
 * @property string|null $imppr1
 * @property string|null $imppr2
 *
 * @method static Builder|All02f newModelQuery()
 * @method static Builder|All02f newQuery()
 * @method static Builder|All02f query()
 * @method static Builder|All02f whereA01aa($value)
 * @method static Builder|All02f whereA01mm($value)
 * @method static Builder|All02f whereEnte($value)
 * @method static Builder|All02f whereId($value)
 * @method static Builder|All02f whereImpmes($value)
 * @method static Builder|All02f whereImpneg($value)
 * @method static Builder|All02f whereImppr1($value)
 * @method static Builder|All02f whereImppr2($value)
 * @method static Builder|All02f whereKcodic($value)
 * @method static Builder|All02f whereKodreg($value)
 * @method static Builder|All02f whereKtipo($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\All02fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class All02f extends BaseModel
{
    protected $table = 'all02f';
}
