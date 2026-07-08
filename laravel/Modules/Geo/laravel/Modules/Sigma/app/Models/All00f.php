<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\All00f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $pmese
 * @property string|null $panno
 * @property string|null $pdata
 * @property string|null $pm00
 * @property string|null $pm98
 * @property string|null $pm96
 * @property string|null $pm99
 * @property string|null $pm95
 * @property string|null $pm94
 * @property string|null $pm93
 * @property string|null $pa00
 * @property string|null $pa98
 * @property string|null $pa96
 * @property string|null $pa99
 * @property string|null $pa95
 * @property string|null $pa94
 * @property string|null $pa93
 * @property string|null $pp00
 * @property string|null $pp98
 * @property string|null $pp96
 * @property string|null $pp99
 * @property string|null $pp95
 * @property string|null $pp94
 * @property string|null $pp93
 *
 * @method static Builder|All00f newModelQuery()
 * @method static Builder|All00f newQuery()
 * @method static Builder|All00f query()
 * @method static Builder|All00f whereEnte($value)
 * @method static Builder|All00f whereId($value)
 * @method static Builder|All00f wherePa00($value)
 * @method static Builder|All00f wherePa93($value)
 * @method static Builder|All00f wherePa94($value)
 * @method static Builder|All00f wherePa95($value)
 * @method static Builder|All00f wherePa96($value)
 * @method static Builder|All00f wherePa98($value)
 * @method static Builder|All00f wherePa99($value)
 * @method static Builder|All00f wherePanno($value)
 * @method static Builder|All00f wherePdata($value)
 * @method static Builder|All00f wherePm00($value)
 * @method static Builder|All00f wherePm93($value)
 * @method static Builder|All00f wherePm94($value)
 * @method static Builder|All00f wherePm95($value)
 * @method static Builder|All00f wherePm96($value)
 * @method static Builder|All00f wherePm98($value)
 * @method static Builder|All00f wherePm99($value)
 * @method static Builder|All00f wherePmese($value)
 * @method static Builder|All00f wherePp00($value)
 * @method static Builder|All00f wherePp93($value)
 * @method static Builder|All00f wherePp94($value)
 * @method static Builder|All00f wherePp95($value)
 * @method static Builder|All00f wherePp96($value)
 * @method static Builder|All00f wherePp98($value)
 * @method static Builder|All00f wherePp99($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\All00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class All00f extends BaseModel
{
    protected $table = 'all00f';
}
