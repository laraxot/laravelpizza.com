<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est22l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $dal
 * @property string|null $al
 * @property string|null $data22
 * @property string|null $dalora
 * @property string|null $alora
 * @property string|null $italia
 * @property string|null $estero
 * @property string|null $num1e
 * @property string|null $num2e
 * @property string|null $num3e
 * @property string|null $tar1e
 * @property string|null $tar2e
 * @property string|null $tar3e
 * @property string|null $imp1e
 * @property string|null $imp2e
 * @property string|null $imp3e
 * @property string|null $auto1e
 * @property string|null $auto2e
 * @property string|null $auto3e
 * @property string|null $voce1e
 * @property string|null $voce2e
 * @property string|null $voce3e
 * @property string|null $gg1e
 * @property string|null $dia1e
 * @property string|null $camb1e
 * @property string|null $imp4e
 * @property string|null $imp4ce
 * @property string|null $imp4de
 * @property string|null $voce5e
 * @property string|null $vocd5e
 * @property string|null $gg2e
 * @property string|null $dia2e
 * @property string|null $camb2e
 * @property string|null $imp5e
 * @property string|null $imp5ce
 * @property string|null $imp5de
 * @property string|null $voce6e
 * @property string|null $vocd6e
 * @property string|null $gg3e
 * @property string|null $dia3e
 * @property string|null $camb3e
 * @property string|null $imp6e
 * @property string|null $imp6ce
 * @property string|null $imp6de
 * @property string|null $voce7e
 * @property string|null $vocd7e
 * @property string|null $voce4e
 * @property string|null $voce8e
 * @property string|null $rimbe
 * @property string|null $rece
 * @property string|null $impfoe
 * @property string|null $vocfoe
 * @property string|null $num15i
 * @property string|null $num1i
 * @property string|null $num2i
 * @property string|null $num3i
 * @property string|null $tar1i
 * @property string|null $tar2i
 * @property string|null $tar3i
 * @property string|null $imp15i
 * @property string|null $imp1i
 * @property string|null $imp2i
 * @property string|null $imp3i
 * @property string|null $auto1i
 * @property string|null $auto2i
 * @property string|null $auto3i
 * @property string|null $voc15i
 * @property string|null $voce1i
 * @property string|null $voce2i
 * @property string|null $voce3i
 * @property string|null $voce4i
 * @property string|null $voce5i
 * @property string|null $rimbi
 * @property string|null $reci
 * @property string|null $impfoi
 * @property string|null $vocfoi
 * @property string|null $desc22
 * @property string|null $prof22
 * @property string|null $elab22
 * @property string|null $mese22
 * @property string|null $ann22
 *
 * @method static Builder|Est22l1 newModelQuery()
 * @method static Builder|Est22l1 newQuery()
 * @method static Builder|Est22l1 query()
 * @method static Builder|Est22l1 whereAl($value)
 * @method static Builder|Est22l1 whereAlora($value)
 * @method static Builder|Est22l1 whereAnn22($value)
 * @method static Builder|Est22l1 whereAuto1e($value)
 * @method static Builder|Est22l1 whereAuto1i($value)
 * @method static Builder|Est22l1 whereAuto2e($value)
 * @method static Builder|Est22l1 whereAuto2i($value)
 * @method static Builder|Est22l1 whereAuto3e($value)
 * @method static Builder|Est22l1 whereAuto3i($value)
 * @method static Builder|Est22l1 whereCamb1e($value)
 * @method static Builder|Est22l1 whereCamb2e($value)
 * @method static Builder|Est22l1 whereCamb3e($value)
 * @method static Builder|Est22l1 whereDal($value)
 * @method static Builder|Est22l1 whereDalora($value)
 * @method static Builder|Est22l1 whereData22($value)
 * @method static Builder|Est22l1 whereDesc22($value)
 * @method static Builder|Est22l1 whereDia1e($value)
 * @method static Builder|Est22l1 whereDia2e($value)
 * @method static Builder|Est22l1 whereDia3e($value)
 * @method static Builder|Est22l1 whereElab22($value)
 * @method static Builder|Est22l1 whereEnte($value)
 * @method static Builder|Est22l1 whereEstero($value)
 * @method static Builder|Est22l1 whereGg1e($value)
 * @method static Builder|Est22l1 whereGg2e($value)
 * @method static Builder|Est22l1 whereGg3e($value)
 * @method static Builder|Est22l1 whereId($value)
 * @method static Builder|Est22l1 whereImp15i($value)
 * @method static Builder|Est22l1 whereImp1e($value)
 * @method static Builder|Est22l1 whereImp1i($value)
 * @method static Builder|Est22l1 whereImp2e($value)
 * @method static Builder|Est22l1 whereImp2i($value)
 * @method static Builder|Est22l1 whereImp3e($value)
 * @method static Builder|Est22l1 whereImp3i($value)
 * @method static Builder|Est22l1 whereImp4ce($value)
 * @method static Builder|Est22l1 whereImp4de($value)
 * @method static Builder|Est22l1 whereImp4e($value)
 * @method static Builder|Est22l1 whereImp5ce($value)
 * @method static Builder|Est22l1 whereImp5de($value)
 * @method static Builder|Est22l1 whereImp5e($value)
 * @method static Builder|Est22l1 whereImp6ce($value)
 * @method static Builder|Est22l1 whereImp6de($value)
 * @method static Builder|Est22l1 whereImp6e($value)
 * @method static Builder|Est22l1 whereImpfoe($value)
 * @method static Builder|Est22l1 whereImpfoi($value)
 * @method static Builder|Est22l1 whereItalia($value)
 * @method static Builder|Est22l1 whereMatr($value)
 * @method static Builder|Est22l1 whereMese22($value)
 * @method static Builder|Est22l1 whereNum15i($value)
 * @method static Builder|Est22l1 whereNum1e($value)
 * @method static Builder|Est22l1 whereNum1i($value)
 * @method static Builder|Est22l1 whereNum2e($value)
 * @method static Builder|Est22l1 whereNum2i($value)
 * @method static Builder|Est22l1 whereNum3e($value)
 * @method static Builder|Est22l1 whereNum3i($value)
 * @method static Builder|Est22l1 whereProf22($value)
 * @method static Builder|Est22l1 whereRece($value)
 * @method static Builder|Est22l1 whereReci($value)
 * @method static Builder|Est22l1 whereRimbe($value)
 * @method static Builder|Est22l1 whereRimbi($value)
 * @method static Builder|Est22l1 whereTar1e($value)
 * @method static Builder|Est22l1 whereTar1i($value)
 * @method static Builder|Est22l1 whereTar2e($value)
 * @method static Builder|Est22l1 whereTar2i($value)
 * @method static Builder|Est22l1 whereTar3e($value)
 * @method static Builder|Est22l1 whereTar3i($value)
 * @method static Builder|Est22l1 whereVoc15i($value)
 * @method static Builder|Est22l1 whereVocd5e($value)
 * @method static Builder|Est22l1 whereVocd6e($value)
 * @method static Builder|Est22l1 whereVocd7e($value)
 * @method static Builder|Est22l1 whereVoce1e($value)
 * @method static Builder|Est22l1 whereVoce1i($value)
 * @method static Builder|Est22l1 whereVoce2e($value)
 * @method static Builder|Est22l1 whereVoce2i($value)
 * @method static Builder|Est22l1 whereVoce3e($value)
 * @method static Builder|Est22l1 whereVoce3i($value)
 * @method static Builder|Est22l1 whereVoce4e($value)
 * @method static Builder|Est22l1 whereVoce4i($value)
 * @method static Builder|Est22l1 whereVoce5e($value)
 * @method static Builder|Est22l1 whereVoce5i($value)
 * @method static Builder|Est22l1 whereVoce6e($value)
 * @method static Builder|Est22l1 whereVoce7e($value)
 * @method static Builder|Est22l1 whereVoce8e($value)
 * @method static Builder|Est22l1 whereVocfoe($value)
 * @method static Builder|Est22l1 whereVocfoi($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est22l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est22l1 extends BaseModel
{
    protected $table = 'est22l1';
}
