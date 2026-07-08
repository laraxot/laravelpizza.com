<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Jprog01l.
 *
 * @property int $id
 * @property string|null $flanac
 * @property string|null $cdpgac
 * @property string|null $dspgac
 * @property string|null $flctac
 * @property string|null $flrvac
 * @property string|null $flpcac
 * @property string|null $flauac
 * @property string|null $fljhac
 * @property string|null $flcfac
 * @property string|null $nmpgac
 * @property string|null $tppgac
 * @property string|null $pfjbac
 * @property string|null $nmjqac
 * @property string|null $nmljac
 * @property string|null $nmoqac
 * @property string|null $nmlqac
 * @property string|null $pyjqac
 * @property string|null $grpgac
 * @property string|null $nmlhac
 * @property string|null $nmfhac
 * @property string|null $nmmhac
 * @property string|null $tpohac
 *
 * @method static Builder|Jprog01l newModelQuery()
 * @method static Builder|Jprog01l newQuery()
 * @method static Builder|Jprog01l query()
 * @method static Builder|Jprog01l whereCdpgac($value)
 * @method static Builder|Jprog01l whereDspgac($value)
 * @method static Builder|Jprog01l whereFlanac($value)
 * @method static Builder|Jprog01l whereFlauac($value)
 * @method static Builder|Jprog01l whereFlcfac($value)
 * @method static Builder|Jprog01l whereFlctac($value)
 * @method static Builder|Jprog01l whereFljhac($value)
 * @method static Builder|Jprog01l whereFlpcac($value)
 * @method static Builder|Jprog01l whereFlrvac($value)
 * @method static Builder|Jprog01l whereGrpgac($value)
 * @method static Builder|Jprog01l whereId($value)
 * @method static Builder|Jprog01l whereNmfhac($value)
 * @method static Builder|Jprog01l whereNmjqac($value)
 * @method static Builder|Jprog01l whereNmlhac($value)
 * @method static Builder|Jprog01l whereNmljac($value)
 * @method static Builder|Jprog01l whereNmlqac($value)
 * @method static Builder|Jprog01l whereNmmhac($value)
 * @method static Builder|Jprog01l whereNmoqac($value)
 * @method static Builder|Jprog01l whereNmpgac($value)
 * @method static Builder|Jprog01l wherePfjbac($value)
 * @method static Builder|Jprog01l wherePyjqac($value)
 * @method static Builder|Jprog01l whereTpohac($value)
 * @method static Builder|Jprog01l whereTppgac($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Jprog01lFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Jprog01l extends BaseModel
{
    protected $table = 'jprog01l';
}
