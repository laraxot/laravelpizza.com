<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est21f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $data21
 * @property string|null $dalo21
 * @property string|null $alor21
 * @property string|null $codcom
 * @property string|null $num1c
 * @property string|null $num2c
 * @property string|null $num3c
 * @property string|null $tar1c
 * @property string|null $tar2c
 * @property string|null $tar3c
 * @property string|null $imp1c
 * @property string|null $imp2c
 * @property string|null $imp3c
 * @property string|null $auto1c
 * @property string|null $auto2c
 * @property string|null $auto3c
 * @property string|null $voce1c
 * @property string|null $voce2c
 * @property string|null $voce3c
 * @property string|null $getto
 * @property string|null $imp4c
 * @property string|null $voce4c
 * @property string|null $impfor
 * @property string|null $vocfor
 * @property string|null $desc21
 * @property string|null $prof21
 * @property string|null $elab21
 * @property string|null $mese21
 * @property string|null $ann21
 *
 * @method static Builder|Est21f newModelQuery()
 * @method static Builder|Est21f newQuery()
 * @method static Builder|Est21f query()
 * @method static Builder|Est21f whereAlor21($value)
 * @method static Builder|Est21f whereAnn21($value)
 * @method static Builder|Est21f whereAuto1c($value)
 * @method static Builder|Est21f whereAuto2c($value)
 * @method static Builder|Est21f whereAuto3c($value)
 * @method static Builder|Est21f whereCodcom($value)
 * @method static Builder|Est21f whereDalo21($value)
 * @method static Builder|Est21f whereData21($value)
 * @method static Builder|Est21f whereDesc21($value)
 * @method static Builder|Est21f whereElab21($value)
 * @method static Builder|Est21f whereEnte($value)
 * @method static Builder|Est21f whereGetto($value)
 * @method static Builder|Est21f whereId($value)
 * @method static Builder|Est21f whereImp1c($value)
 * @method static Builder|Est21f whereImp2c($value)
 * @method static Builder|Est21f whereImp3c($value)
 * @method static Builder|Est21f whereImp4c($value)
 * @method static Builder|Est21f whereImpfor($value)
 * @method static Builder|Est21f whereMatr($value)
 * @method static Builder|Est21f whereMese21($value)
 * @method static Builder|Est21f whereNum1c($value)
 * @method static Builder|Est21f whereNum2c($value)
 * @method static Builder|Est21f whereNum3c($value)
 * @method static Builder|Est21f whereProf21($value)
 * @method static Builder|Est21f whereTar1c($value)
 * @method static Builder|Est21f whereTar2c($value)
 * @method static Builder|Est21f whereTar3c($value)
 * @method static Builder|Est21f whereVoce1c($value)
 * @method static Builder|Est21f whereVoce2c($value)
 * @method static Builder|Est21f whereVoce3c($value)
 * @method static Builder|Est21f whereVoce4c($value)
 * @method static Builder|Est21f whereVocfor($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est21fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est21f extends BaseModel
{
    protected $table = 'est21f';
}
