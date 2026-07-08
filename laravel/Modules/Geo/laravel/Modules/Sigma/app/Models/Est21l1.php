<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est21l1.
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
 * @method static Builder|Est21l1 newModelQuery()
 * @method static Builder|Est21l1 newQuery()
 * @method static Builder|Est21l1 query()
 * @method static Builder|Est21l1 whereAlor21($value)
 * @method static Builder|Est21l1 whereAnn21($value)
 * @method static Builder|Est21l1 whereAuto1c($value)
 * @method static Builder|Est21l1 whereAuto2c($value)
 * @method static Builder|Est21l1 whereAuto3c($value)
 * @method static Builder|Est21l1 whereCodcom($value)
 * @method static Builder|Est21l1 whereDalo21($value)
 * @method static Builder|Est21l1 whereData21($value)
 * @method static Builder|Est21l1 whereDesc21($value)
 * @method static Builder|Est21l1 whereElab21($value)
 * @method static Builder|Est21l1 whereEnte($value)
 * @method static Builder|Est21l1 whereGetto($value)
 * @method static Builder|Est21l1 whereId($value)
 * @method static Builder|Est21l1 whereImp1c($value)
 * @method static Builder|Est21l1 whereImp2c($value)
 * @method static Builder|Est21l1 whereImp3c($value)
 * @method static Builder|Est21l1 whereImp4c($value)
 * @method static Builder|Est21l1 whereImpfor($value)
 * @method static Builder|Est21l1 whereMatr($value)
 * @method static Builder|Est21l1 whereMese21($value)
 * @method static Builder|Est21l1 whereNum1c($value)
 * @method static Builder|Est21l1 whereNum2c($value)
 * @method static Builder|Est21l1 whereNum3c($value)
 * @method static Builder|Est21l1 whereProf21($value)
 * @method static Builder|Est21l1 whereTar1c($value)
 * @method static Builder|Est21l1 whereTar2c($value)
 * @method static Builder|Est21l1 whereTar3c($value)
 * @method static Builder|Est21l1 whereVoce1c($value)
 * @method static Builder|Est21l1 whereVoce2c($value)
 * @method static Builder|Est21l1 whereVoce3c($value)
 * @method static Builder|Est21l1 whereVoce4c($value)
 * @method static Builder|Est21l1 whereVocfor($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est21l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est21l1 extends BaseModel
{
    protected $table = 'est21l1';
}
