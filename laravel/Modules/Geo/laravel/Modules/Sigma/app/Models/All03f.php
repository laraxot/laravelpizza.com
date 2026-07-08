<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\All03f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $ktipo
 * @property string|null $kcodic
 * @property string|null $kodreg
 * @property string|null $kodcom
 * @property string|null $a01mm
 * @property string|null $a01aa
 * @property string|null $impmes
 * @property string|null $impneg
 * @property string|null $imppr1
 * @property string|null $imppr2
 *
 * @method static Builder|All03f newModelQuery()
 * @method static Builder|All03f newQuery()
 * @method static Builder|All03f query()
 * @method static Builder|All03f whereA01aa($value)
 * @method static Builder|All03f whereA01mm($value)
 * @method static Builder|All03f whereEnte($value)
 * @method static Builder|All03f whereId($value)
 * @method static Builder|All03f whereImpmes($value)
 * @method static Builder|All03f whereImpneg($value)
 * @method static Builder|All03f whereImppr1($value)
 * @method static Builder|All03f whereImppr2($value)
 * @method static Builder|All03f whereKcodic($value)
 * @method static Builder|All03f whereKodcom($value)
 * @method static Builder|All03f whereKodreg($value)
 * @method static Builder|All03f whereKtipo($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\All03fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class All03f extends BaseModel
{
    protected $table = 'all03f';
}
