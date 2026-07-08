<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est23f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $dal
 * @property string|null $al
 * @property string|null $seqs
 * @property string|null $sede
 * @property string|null $num1s
 * @property string|null $num2s
 * @property string|null $num3s
 * @property string|null $tar1s
 * @property string|null $tar2s
 * @property string|null $tar3s
 * @property string|null $imp1s
 * @property string|null $imp2s
 * @property string|null $imp3s
 * @property string|null $auto1s
 * @property string|null $auto2s
 * @property string|null $auto3s
 * @property string|null $voce1s
 * @property string|null $voce2s
 * @property string|null $voce3s
 * @property string|null $rimbo
 * @property string|null $voce4s
 * @property string|null $desc23
 * @property string|null $prof23
 * @property string|null $elab23
 * @property string|null $mese23
 * @property string|null $ann23
 *
 * @method static Builder|Est23f newModelQuery()
 * @method static Builder|Est23f newQuery()
 * @method static Builder|Est23f query()
 * @method static Builder|Est23f whereAl($value)
 * @method static Builder|Est23f whereAnn23($value)
 * @method static Builder|Est23f whereAuto1s($value)
 * @method static Builder|Est23f whereAuto2s($value)
 * @method static Builder|Est23f whereAuto3s($value)
 * @method static Builder|Est23f whereDal($value)
 * @method static Builder|Est23f whereDesc23($value)
 * @method static Builder|Est23f whereElab23($value)
 * @method static Builder|Est23f whereEnte($value)
 * @method static Builder|Est23f whereId($value)
 * @method static Builder|Est23f whereImp1s($value)
 * @method static Builder|Est23f whereImp2s($value)
 * @method static Builder|Est23f whereImp3s($value)
 * @method static Builder|Est23f whereMatr($value)
 * @method static Builder|Est23f whereMese23($value)
 * @method static Builder|Est23f whereNum1s($value)
 * @method static Builder|Est23f whereNum2s($value)
 * @method static Builder|Est23f whereNum3s($value)
 * @method static Builder|Est23f whereProf23($value)
 * @method static Builder|Est23f whereRimbo($value)
 * @method static Builder|Est23f whereSede($value)
 * @method static Builder|Est23f whereSeqs($value)
 * @method static Builder|Est23f whereTar1s($value)
 * @method static Builder|Est23f whereTar2s($value)
 * @method static Builder|Est23f whereTar3s($value)
 * @method static Builder|Est23f whereVoce1s($value)
 * @method static Builder|Est23f whereVoce2s($value)
 * @method static Builder|Est23f whereVoce3s($value)
 * @method static Builder|Est23f whereVoce4s($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est23fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est23f extends BaseModel
{
    protected $table = 'est23f';
}
