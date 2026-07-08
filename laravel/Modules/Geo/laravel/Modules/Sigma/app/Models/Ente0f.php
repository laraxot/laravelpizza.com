<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ente0f.
 *
 * @property int $id
 * @property string|null $ENTE
 * @property string|null $ENDES
 * @property string|null $ENIND
 * @property string|null $ENCAP
 * @property string|null $ENLOC
 * @property string|null $ENPRO
 * @property string|null $ENTDPO
 * @property string|null $ENTDP3
 * @property string|null $SCAD01
 * @property string|null $SCAD02
 * @property string|null $SCAD03
 * @property string|null $ENTPRE
 * @property string|null $ENTMAT
 * @property string|null $D019I1
 * @property string|null $D019I2
 * @property string|null $D019I3
 * @property string|null $D019I4
 * @property string|null $D019F1
 * @property string|null $D019F2
 * @property string|null $D019F3
 * @property string|null $D019F4
 * @property string|null $D019F5
 * @property string|null $D019F6
 * @property string|null $ENANNO
 * @property string|null $SMCOD
 * @property string|null $SMCAT
 * @property string|null $SMDEN
 * @property string|null $SMIND
 * @property string|null $SMLOC
 * @property string|null $SMRL1
 * @property string|null $SMRL2
 * @property string|null $DES101
 * @property string|null $IND101
 * @property string|null $ATI101
 * @property string|null $DOM101
 * @property string|null $SED101
 * @property string|null $PRO101
 * @property string|null $CAP101
 * @property string|null $RAP101
 * @property string|null $FIR101
 * @property string|null $CAT101
 * @property string|null $CF101
 * @property string|null $PIV101
 * @property string|null $M01
 * @property string|null $M02
 * @property string|null $M03
 * @property string|null $M04
 * @property string|null $M05
 * @property string|null $M06
 * @property string|null $M07
 * @property string|null $M08
 * @property string|null $D246I1
 * @property string|null $D246I2
 * @property string|null $D246I3
 * @property string|null $D246I4
 * @property string|null $D246I5
 * @property string|null $D246I6
 * @property string|null $D246I7
 * @property string|null $D246I8
 * @property string|null $D246F1
 * @property string|null $D246F2
 * @property string|null $D246F3
 * @property string|null $DVP001
 * @property string|null $DVP002
 * @property string|null $DVP003
 * @property string|null $DVP004
 * @property string|null $M350P1
 * @property string|null $M350P2
 * @property string|null $DINQ01
 * @property string|null $DINQ02
 * @property string|null $DINQ03
 * @property string|null $DINQ11
 * @property string|null $DINQ12
 * @property string|null $DINQ13
 * @property string|null $DINQ21
 * @property string|null $DINQ22
 * @property string|null $DINQ23
 * @property string|null $MIS001
 * @property string|null $MIS002
 * @property string|null $MIS003
 * @property string|null $MIS011
 * @property string|null $MIS012
 * @property string|null $MIS013
 * @property string|null $RUR001
 * @property string|null $RUR002
 * @property string|null $RUR003
 * @property string|null $RUR004
 * @property string|null $RUR011
 * @property string|null $RUR012
 * @property string|null $RUR013
 * @property string|null $RUR021
 * @property string|null $RUR022
 * @property string|null $RUR023
 * @property string|null $ENANN
 * @property string|null $DESTA
 * @property string|null $TIPSTA
 * @property string|null $CODSTA
 * @property string|null $FNOM
 * @property string|null $FCON
 * @property string|null $FQUA
 * @property string|null $FTEL
 * @property string|null $RNOM
 * @property string|null $RCON
 * @property string|null $RTEL
 * @property string|null $RUFF
 * @property string|null $RIND
 * @property string|null $C00001
 * @property string|null $C00002
 * @property string|null $C00003
 * @property string|null $C00004
 * @property string|null $C00005
 * @property string|null $C00006
 * @property string|null $C00007
 * @property string|null $C00008
 * @property string|null $C00009
 * @property string|null $C00010
 *
 * @method static Builder|Ente0f newModelQuery()
 * @method static Builder|Ente0f newQuery()
 * @method static Builder|Ente0f query()
 * @method static Builder|Ente0f whereATI101($value)
 * @method static Builder|Ente0f whereC00001($value)
 * @method static Builder|Ente0f whereC00002($value)
 * @method static Builder|Ente0f whereC00003($value)
 * @method static Builder|Ente0f whereC00004($value)
 * @method static Builder|Ente0f whereC00005($value)
 * @method static Builder|Ente0f whereC00006($value)
 * @method static Builder|Ente0f whereC00007($value)
 * @method static Builder|Ente0f whereC00008($value)
 * @method static Builder|Ente0f whereC00009($value)
 * @method static Builder|Ente0f whereC00010($value)
 * @method static Builder|Ente0f whereCAP101($value)
 * @method static Builder|Ente0f whereCAT101($value)
 * @method static Builder|Ente0f whereCF101($value)
 * @method static Builder|Ente0f whereCODSTA($value)
 * @method static Builder|Ente0f whereD019F1($value)
 * @method static Builder|Ente0f whereD019F2($value)
 * @method static Builder|Ente0f whereD019F3($value)
 * @method static Builder|Ente0f whereD019F4($value)
 * @method static Builder|Ente0f whereD019F5($value)
 * @method static Builder|Ente0f whereD019F6($value)
 * @method static Builder|Ente0f whereD019I1($value)
 * @method static Builder|Ente0f whereD019I2($value)
 * @method static Builder|Ente0f whereD019I3($value)
 * @method static Builder|Ente0f whereD019I4($value)
 * @method static Builder|Ente0f whereD246F1($value)
 * @method static Builder|Ente0f whereD246F2($value)
 * @method static Builder|Ente0f whereD246F3($value)
 * @method static Builder|Ente0f whereD246I1($value)
 * @method static Builder|Ente0f whereD246I2($value)
 * @method static Builder|Ente0f whereD246I3($value)
 * @method static Builder|Ente0f whereD246I4($value)
 * @method static Builder|Ente0f whereD246I5($value)
 * @method static Builder|Ente0f whereD246I6($value)
 * @method static Builder|Ente0f whereD246I7($value)
 * @method static Builder|Ente0f whereD246I8($value)
 * @method static Builder|Ente0f whereDES101($value)
 * @method static Builder|Ente0f whereDESTA($value)
 * @method static Builder|Ente0f whereDINQ01($value)
 * @method static Builder|Ente0f whereDINQ02($value)
 * @method static Builder|Ente0f whereDINQ03($value)
 * @method static Builder|Ente0f whereDINQ11($value)
 * @method static Builder|Ente0f whereDINQ12($value)
 * @method static Builder|Ente0f whereDINQ13($value)
 * @method static Builder|Ente0f whereDINQ21($value)
 * @method static Builder|Ente0f whereDINQ22($value)
 * @method static Builder|Ente0f whereDINQ23($value)
 * @method static Builder|Ente0f whereDOM101($value)
 * @method static Builder|Ente0f whereDVP001($value)
 * @method static Builder|Ente0f whereDVP002($value)
 * @method static Builder|Ente0f whereDVP003($value)
 * @method static Builder|Ente0f whereDVP004($value)
 * @method static Builder|Ente0f whereENANN($value)
 * @method static Builder|Ente0f whereENANNO($value)
 * @method static Builder|Ente0f whereENCAP($value)
 * @method static Builder|Ente0f whereENDES($value)
 * @method static Builder|Ente0f whereENIND($value)
 * @method static Builder|Ente0f whereENLOC($value)
 * @method static Builder|Ente0f whereENPRO($value)
 * @method static Builder|Ente0f whereENTDP3($value)
 * @method static Builder|Ente0f whereENTDPO($value)
 * @method static Builder|Ente0f whereENTE($value)
 * @method static Builder|Ente0f whereENTMAT($value)
 * @method static Builder|Ente0f whereENTPRE($value)
 * @method static Builder|Ente0f whereFCON($value)
 * @method static Builder|Ente0f whereFIR101($value)
 * @method static Builder|Ente0f whereFNOM($value)
 * @method static Builder|Ente0f whereFQUA($value)
 * @method static Builder|Ente0f whereFTEL($value)
 * @method static Builder|Ente0f whereIND101($value)
 * @method static Builder|Ente0f whereId($value)
 * @method static Builder|Ente0f whereM01($value)
 * @method static Builder|Ente0f whereM02($value)
 * @method static Builder|Ente0f whereM03($value)
 * @method static Builder|Ente0f whereM04($value)
 * @method static Builder|Ente0f whereM05($value)
 * @method static Builder|Ente0f whereM06($value)
 * @method static Builder|Ente0f whereM07($value)
 * @method static Builder|Ente0f whereM08($value)
 * @method static Builder|Ente0f whereM350P1($value)
 * @method static Builder|Ente0f whereM350P2($value)
 * @method static Builder|Ente0f whereMIS001($value)
 * @method static Builder|Ente0f whereMIS002($value)
 * @method static Builder|Ente0f whereMIS003($value)
 * @method static Builder|Ente0f whereMIS011($value)
 * @method static Builder|Ente0f whereMIS012($value)
 * @method static Builder|Ente0f whereMIS013($value)
 * @method static Builder|Ente0f wherePIV101($value)
 * @method static Builder|Ente0f wherePRO101($value)
 * @method static Builder|Ente0f whereRAP101($value)
 * @method static Builder|Ente0f whereRCON($value)
 * @method static Builder|Ente0f whereRIND($value)
 * @method static Builder|Ente0f whereRNOM($value)
 * @method static Builder|Ente0f whereRTEL($value)
 * @method static Builder|Ente0f whereRUFF($value)
 * @method static Builder|Ente0f whereRUR001($value)
 * @method static Builder|Ente0f whereRUR002($value)
 * @method static Builder|Ente0f whereRUR003($value)
 * @method static Builder|Ente0f whereRUR004($value)
 * @method static Builder|Ente0f whereRUR011($value)
 * @method static Builder|Ente0f whereRUR012($value)
 * @method static Builder|Ente0f whereRUR013($value)
 * @method static Builder|Ente0f whereRUR021($value)
 * @method static Builder|Ente0f whereRUR022($value)
 * @method static Builder|Ente0f whereRUR023($value)
 * @method static Builder|Ente0f whereSCAD01($value)
 * @method static Builder|Ente0f whereSCAD02($value)
 * @method static Builder|Ente0f whereSCAD03($value)
 * @method static Builder|Ente0f whereSED101($value)
 * @method static Builder|Ente0f whereSMCAT($value)
 * @method static Builder|Ente0f whereSMCOD($value)
 * @method static Builder|Ente0f whereSMDEN($value)
 * @method static Builder|Ente0f whereSMIND($value)
 * @method static Builder|Ente0f whereSMLOC($value)
 * @method static Builder|Ente0f whereSMRL1($value)
 * @method static Builder|Ente0f whereSMRL2($value)
 * @method static Builder|Ente0f whereTIPSTA($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ente0fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ente0f extends BaseModel
{
    protected $table = 'ente0f';
}
