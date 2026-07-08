<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est22f.
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
 * @method static Builder|Est22f newModelQuery()
 * @method static Builder|Est22f newQuery()
 * @method static Builder|Est22f query()
 * @method static Builder|Est22f whereAl($value)
 * @method static Builder|Est22f whereAlora($value)
 * @method static Builder|Est22f whereAnn22($value)
 * @method static Builder|Est22f whereAuto1e($value)
 * @method static Builder|Est22f whereAuto1i($value)
 * @method static Builder|Est22f whereAuto2e($value)
 * @method static Builder|Est22f whereAuto2i($value)
 * @method static Builder|Est22f whereAuto3e($value)
 * @method static Builder|Est22f whereAuto3i($value)
 * @method static Builder|Est22f whereCamb1e($value)
 * @method static Builder|Est22f whereCamb2e($value)
 * @method static Builder|Est22f whereCamb3e($value)
 * @method static Builder|Est22f whereDal($value)
 * @method static Builder|Est22f whereDalora($value)
 * @method static Builder|Est22f whereData22($value)
 * @method static Builder|Est22f whereDesc22($value)
 * @method static Builder|Est22f whereDia1e($value)
 * @method static Builder|Est22f whereDia2e($value)
 * @method static Builder|Est22f whereDia3e($value)
 * @method static Builder|Est22f whereElab22($value)
 * @method static Builder|Est22f whereEnte($value)
 * @method static Builder|Est22f whereEstero($value)
 * @method static Builder|Est22f whereGg1e($value)
 * @method static Builder|Est22f whereGg2e($value)
 * @method static Builder|Est22f whereGg3e($value)
 * @method static Builder|Est22f whereId($value)
 * @method static Builder|Est22f whereImp15i($value)
 * @method static Builder|Est22f whereImp1e($value)
 * @method static Builder|Est22f whereImp1i($value)
 * @method static Builder|Est22f whereImp2e($value)
 * @method static Builder|Est22f whereImp2i($value)
 * @method static Builder|Est22f whereImp3e($value)
 * @method static Builder|Est22f whereImp3i($value)
 * @method static Builder|Est22f whereImp4ce($value)
 * @method static Builder|Est22f whereImp4de($value)
 * @method static Builder|Est22f whereImp4e($value)
 * @method static Builder|Est22f whereImp5ce($value)
 * @method static Builder|Est22f whereImp5de($value)
 * @method static Builder|Est22f whereImp5e($value)
 * @method static Builder|Est22f whereImp6ce($value)
 * @method static Builder|Est22f whereImp6de($value)
 * @method static Builder|Est22f whereImp6e($value)
 * @method static Builder|Est22f whereImpfoe($value)
 * @method static Builder|Est22f whereImpfoi($value)
 * @method static Builder|Est22f whereItalia($value)
 * @method static Builder|Est22f whereMatr($value)
 * @method static Builder|Est22f whereMese22($value)
 * @method static Builder|Est22f whereNum15i($value)
 * @method static Builder|Est22f whereNum1e($value)
 * @method static Builder|Est22f whereNum1i($value)
 * @method static Builder|Est22f whereNum2e($value)
 * @method static Builder|Est22f whereNum2i($value)
 * @method static Builder|Est22f whereNum3e($value)
 * @method static Builder|Est22f whereNum3i($value)
 * @method static Builder|Est22f whereProf22($value)
 * @method static Builder|Est22f whereRece($value)
 * @method static Builder|Est22f whereReci($value)
 * @method static Builder|Est22f whereRimbe($value)
 * @method static Builder|Est22f whereRimbi($value)
 * @method static Builder|Est22f whereTar1e($value)
 * @method static Builder|Est22f whereTar1i($value)
 * @method static Builder|Est22f whereTar2e($value)
 * @method static Builder|Est22f whereTar2i($value)
 * @method static Builder|Est22f whereTar3e($value)
 * @method static Builder|Est22f whereTar3i($value)
 * @method static Builder|Est22f whereVoc15i($value)
 * @method static Builder|Est22f whereVocd5e($value)
 * @method static Builder|Est22f whereVocd6e($value)
 * @method static Builder|Est22f whereVocd7e($value)
 * @method static Builder|Est22f whereVoce1e($value)
 * @method static Builder|Est22f whereVoce1i($value)
 * @method static Builder|Est22f whereVoce2e($value)
 * @method static Builder|Est22f whereVoce2i($value)
 * @method static Builder|Est22f whereVoce3e($value)
 * @method static Builder|Est22f whereVoce3i($value)
 * @method static Builder|Est22f whereVoce4e($value)
 * @method static Builder|Est22f whereVoce4i($value)
 * @method static Builder|Est22f whereVoce5e($value)
 * @method static Builder|Est22f whereVoce5i($value)
 * @method static Builder|Est22f whereVoce6e($value)
 * @method static Builder|Est22f whereVoce7e($value)
 * @method static Builder|Est22f whereVoce8e($value)
 * @method static Builder|Est22f whereVocfoe($value)
 * @method static Builder|Est22f whereVocfoi($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est22fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est22f extends BaseModel
{
    protected $table = 'est22f';
}
