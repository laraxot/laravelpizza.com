<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Eccez01l.
 *
 * @property int $id
 * @property string|null $ecannu
 * @property string|null $enteap
 * @property string|null $ecmatr
 * @property string|null $ecgior
 * @property string|null $ecsogl
 * @property string|null $ecsogd
 * @property string|null $ec0001
 * @property string|null $ec0002
 * @property string|null $ecmodp
 * @property string|null $ec0003
 * @property string|null $ecpers
 * @property string|null $ec0004
 * @property string|null $ec0005
 * @property string|null $ecaste
 * @property string|null $ecgipe
 * @property string|null $ec0006
 * @property string|null $ec0007
 * @property string|null $ecttur
 * @property string|null $ecpaui
 * @property string|null $ecpauf
 * @property string|null $ecpaum
 * @property string|null $ecpaus
 *
 * @method static Builder|Eccez01l newModelQuery()
 * @method static Builder|Eccez01l newQuery()
 * @method static Builder|Eccez01l query()
 * @method static Builder|Eccez01l whereEc0001($value)
 * @method static Builder|Eccez01l whereEc0002($value)
 * @method static Builder|Eccez01l whereEc0003($value)
 * @method static Builder|Eccez01l whereEc0004($value)
 * @method static Builder|Eccez01l whereEc0005($value)
 * @method static Builder|Eccez01l whereEc0006($value)
 * @method static Builder|Eccez01l whereEc0007($value)
 * @method static Builder|Eccez01l whereEcannu($value)
 * @method static Builder|Eccez01l whereEcaste($value)
 * @method static Builder|Eccez01l whereEcgior($value)
 * @method static Builder|Eccez01l whereEcgipe($value)
 * @method static Builder|Eccez01l whereEcmatr($value)
 * @method static Builder|Eccez01l whereEcmodp($value)
 * @method static Builder|Eccez01l whereEcpauf($value)
 * @method static Builder|Eccez01l whereEcpaui($value)
 * @method static Builder|Eccez01l whereEcpaum($value)
 * @method static Builder|Eccez01l whereEcpaus($value)
 * @method static Builder|Eccez01l whereEcpers($value)
 * @method static Builder|Eccez01l whereEcsogd($value)
 * @method static Builder|Eccez01l whereEcsogl($value)
 * @method static Builder|Eccez01l whereEcttur($value)
 * @method static Builder|Eccez01l whereEnteap($value)
 * @method static Builder|Eccez01l whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Eccez01lFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Eccez01l extends BaseModel
{
    protected $table = 'eccez01l';
}
