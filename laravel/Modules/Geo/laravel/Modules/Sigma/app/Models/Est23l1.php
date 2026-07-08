<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est23l1.
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
 * @method static Builder|Est23l1 newModelQuery()
 * @method static Builder|Est23l1 newQuery()
 * @method static Builder|Est23l1 query()
 * @method static Builder|Est23l1 whereAl($value)
 * @method static Builder|Est23l1 whereAnn23($value)
 * @method static Builder|Est23l1 whereAuto1s($value)
 * @method static Builder|Est23l1 whereAuto2s($value)
 * @method static Builder|Est23l1 whereAuto3s($value)
 * @method static Builder|Est23l1 whereDal($value)
 * @method static Builder|Est23l1 whereDesc23($value)
 * @method static Builder|Est23l1 whereElab23($value)
 * @method static Builder|Est23l1 whereEnte($value)
 * @method static Builder|Est23l1 whereId($value)
 * @method static Builder|Est23l1 whereImp1s($value)
 * @method static Builder|Est23l1 whereImp2s($value)
 * @method static Builder|Est23l1 whereImp3s($value)
 * @method static Builder|Est23l1 whereMatr($value)
 * @method static Builder|Est23l1 whereMese23($value)
 * @method static Builder|Est23l1 whereNum1s($value)
 * @method static Builder|Est23l1 whereNum2s($value)
 * @method static Builder|Est23l1 whereNum3s($value)
 * @method static Builder|Est23l1 whereProf23($value)
 * @method static Builder|Est23l1 whereRimbo($value)
 * @method static Builder|Est23l1 whereSede($value)
 * @method static Builder|Est23l1 whereSeqs($value)
 * @method static Builder|Est23l1 whereTar1s($value)
 * @method static Builder|Est23l1 whereTar2s($value)
 * @method static Builder|Est23l1 whereTar3s($value)
 * @method static Builder|Est23l1 whereVoce1s($value)
 * @method static Builder|Est23l1 whereVoce2s($value)
 * @method static Builder|Est23l1 whereVoce3s($value)
 * @method static Builder|Est23l1 whereVoce4s($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est23l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est23l1 extends BaseModel
{
    protected $table = 'est23l1';
}
