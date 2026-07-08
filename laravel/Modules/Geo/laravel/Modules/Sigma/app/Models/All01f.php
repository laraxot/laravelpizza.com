<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\All01f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $a01mm
 * @property string|null $a01aa
 * @property string|null $pta01
 * @property string|null $pta02
 * @property string|null $pta03
 * @property string|null $pta04
 * @property string|null $pta05
 * @property string|null $pta06
 * @property string|null $pta07
 * @property string|null $pta08
 * @property string|null $pta09
 * @property string|null $pta10
 * @property string|null $pta11
 * @property string|null $pta12
 * @property string|null $pta13
 * @property string|null $pta14
 * @property string|null $pta15
 * @property string|null $pta16
 * @property string|null $pta17
 * @property string|null $pta18
 * @property string|null $pta19
 * @property string|null $pta20
 * @property string|null $pta21
 * @property string|null $pta22
 * @property string|null $pta23
 * @property string|null $pta24
 * @property string|null $ptb01
 * @property string|null $ptb02
 * @property string|null $ptb03
 * @property string|null $ptb04
 * @property string|null $ptb05
 * @property string|null $ptb06
 * @property string|null $ptb07
 * @property string|null $ptb47
 * @property string|null $ptc01
 * @property string|null $ptc02
 * @property string|null $ptd01
 * @property string|null $ptd02
 * @property string|null $pte49
 * @property string|null $pte50
 * @property string|null $pte51
 * @property string|null $pte52
 * @property string|null $ptf01
 * @property string|null $ptf02
 * @property string|null $ptf03
 * @property string|null $ptg01
 * @property string|null $ptg02
 * @property string|null $ptg03
 * @property string|null $ptg04
 * @property string|null $ptg05
 * @property string|null $ptg06
 * @property string|null $ptg07
 * @property string|null $ptg08
 * @property string|null $pth01
 * @property string|null $pth02
 * @property string|null $pth03
 * @property string|null $pth04
 * @property string|null $ptm01
 * @property string|null $ptm02
 * @property string|null $ptm03
 * @property string|null $ptm04
 * @property string|null $ppa01
 * @property string|null $ppa02
 * @property string|null $ppa03
 * @property string|null $ppa04
 * @property string|null $ppa05
 * @property string|null $ppa06
 * @property string|null $ppa07
 * @property string|null $ppa08
 * @property string|null $ppa09
 * @property string|null $ppa10
 * @property string|null $ppa11
 * @property string|null $ppa12
 * @property string|null $ppa13
 * @property string|null $ppa14
 * @property string|null $ppa15
 * @property string|null $ppa16
 * @property string|null $ppa17
 * @property string|null $ppa18
 * @property string|null $ppa19
 * @property string|null $ppa20
 * @property string|null $ppa21
 * @property string|null $ppa22
 * @property string|null $ppa23
 * @property string|null $ppa24
 * @property string|null $ppb01
 * @property string|null $ppb02
 * @property string|null $ppb03
 * @property string|null $ppb04
 * @property string|null $ppb05
 * @property string|null $ppb06
 * @property string|null $ppb07
 * @property string|null $ppb47
 * @property string|null $ppc01
 * @property string|null $ppc02
 * @property string|null $ppd01
 * @property string|null $ppd02
 * @property string|null $ppe49
 * @property string|null $ppe50
 * @property string|null $ppe51
 * @property string|null $ppe52
 * @property string|null $ppf01
 * @property string|null $ppf02
 * @property string|null $ppf03
 * @property string|null $ppg01
 * @property string|null $ppg02
 * @property string|null $ppg03
 * @property string|null $ppg04
 * @property string|null $ppg05
 * @property string|null $ppg06
 * @property string|null $ppg07
 * @property string|null $ppg08
 * @property string|null $pph01
 * @property string|null $pph02
 * @property string|null $pph03
 * @property string|null $pph04
 * @property string|null $ppm01
 * @property string|null $ppm02
 * @property string|null $ppm03
 * @property string|null $ppm04
 * @property string|null $dma01
 * @property string|null $dma02
 * @property string|null $dma03
 * @property string|null $dma04
 * @property string|null $dma05
 * @property string|null $dma06
 * @property string|null $dma07
 * @property string|null $dma08
 * @property string|null $dma09
 * @property string|null $dma10
 * @property string|null $dma11
 * @property string|null $dma12
 * @property string|null $dma13
 * @property string|null $dma14
 * @property string|null $dma15
 * @property string|null $dma16
 * @property string|null $dma17
 * @property string|null $dma18
 * @property string|null $dma19
 * @property string|null $dma20
 * @property string|null $dma21
 * @property string|null $dma22
 * @property string|null $dma23
 * @property string|null $dma24
 * @property string|null $dmb01
 * @property string|null $dmb02
 * @property string|null $dmb03
 * @property string|null $dmb04
 * @property string|null $dmb05
 * @property string|null $dmb06
 * @property string|null $dmb07
 * @property string|null $dmb47
 * @property string|null $dmc01
 * @property string|null $dmc02
 * @property string|null $dmd01
 * @property string|null $dmd02
 * @property string|null $dme49
 * @property string|null $dme50
 * @property string|null $dme51
 * @property string|null $dme52
 * @property string|null $dmf01
 * @property string|null $dmf02
 * @property string|null $dmf03
 * @property string|null $dmg01
 * @property string|null $dmg02
 * @property string|null $dmg03
 * @property string|null $dmg04
 * @property string|null $dmg05
 * @property string|null $dmg06
 * @property string|null $dmg07
 * @property string|null $dmg08
 * @property string|null $dmh01
 * @property string|null $dmh02
 * @property string|null $dmh03
 * @property string|null $dmh04
 * @property string|null $dmm01
 * @property string|null $dmm02
 * @property string|null $dmm03
 * @property string|null $dmm04
 * @property string|null $dia01
 * @property string|null $dia02
 * @property string|null $dia03
 * @property string|null $dia04
 * @property string|null $dia05
 * @property string|null $dia06
 * @property string|null $dia07
 * @property string|null $dia08
 * @property string|null $dia09
 * @property string|null $dia10
 * @property string|null $dia11
 * @property string|null $dia12
 * @property string|null $dia13
 * @property string|null $dia14
 * @property string|null $dia15
 * @property string|null $dia16
 * @property string|null $dia17
 * @property string|null $dia18
 * @property string|null $dia19
 * @property string|null $dia20
 * @property string|null $dia21
 * @property string|null $dia22
 * @property string|null $dia23
 * @property string|null $dia24
 * @property string|null $dib01
 * @property string|null $dib02
 * @property string|null $dib03
 * @property string|null $dib04
 * @property string|null $dib05
 * @property string|null $dib06
 * @property string|null $dib07
 * @property string|null $dib47
 * @property string|null $dic01
 * @property string|null $dic02
 * @property string|null $did01
 * @property string|null $did02
 * @property string|null $die49
 * @property string|null $die50
 * @property string|null $die51
 * @property string|null $die52
 * @property string|null $dif01
 * @property string|null $dif02
 * @property string|null $dif03
 * @property string|null $dig01
 * @property string|null $dig02
 * @property string|null $dig03
 * @property string|null $dig04
 * @property string|null $dig05
 * @property string|null $dig06
 * @property string|null $dig07
 * @property string|null $dig08
 * @property string|null $dih01
 * @property string|null $dih02
 * @property string|null $dih03
 * @property string|null $dih04
 * @property string|null $dim01
 * @property string|null $dim02
 * @property string|null $dim03
 * @property string|null $dim04
 *
 * @method static Builder|All01f newModelQuery()
 * @method static Builder|All01f newQuery()
 * @method static Builder|All01f query()
 * @method static Builder|All01f whereA01aa($value)
 * @method static Builder|All01f whereA01mm($value)
 * @method static Builder|All01f whereDia01($value)
 * @method static Builder|All01f whereDia02($value)
 * @method static Builder|All01f whereDia03($value)
 * @method static Builder|All01f whereDia04($value)
 * @method static Builder|All01f whereDia05($value)
 * @method static Builder|All01f whereDia06($value)
 * @method static Builder|All01f whereDia07($value)
 * @method static Builder|All01f whereDia08($value)
 * @method static Builder|All01f whereDia09($value)
 * @method static Builder|All01f whereDia10($value)
 * @method static Builder|All01f whereDia11($value)
 * @method static Builder|All01f whereDia12($value)
 * @method static Builder|All01f whereDia13($value)
 * @method static Builder|All01f whereDia14($value)
 * @method static Builder|All01f whereDia15($value)
 * @method static Builder|All01f whereDia16($value)
 * @method static Builder|All01f whereDia17($value)
 * @method static Builder|All01f whereDia18($value)
 * @method static Builder|All01f whereDia19($value)
 * @method static Builder|All01f whereDia20($value)
 * @method static Builder|All01f whereDia21($value)
 * @method static Builder|All01f whereDia22($value)
 * @method static Builder|All01f whereDia23($value)
 * @method static Builder|All01f whereDia24($value)
 * @method static Builder|All01f whereDib01($value)
 * @method static Builder|All01f whereDib02($value)
 * @method static Builder|All01f whereDib03($value)
 * @method static Builder|All01f whereDib04($value)
 * @method static Builder|All01f whereDib05($value)
 * @method static Builder|All01f whereDib06($value)
 * @method static Builder|All01f whereDib07($value)
 * @method static Builder|All01f whereDib47($value)
 * @method static Builder|All01f whereDic01($value)
 * @method static Builder|All01f whereDic02($value)
 * @method static Builder|All01f whereDid01($value)
 * @method static Builder|All01f whereDid02($value)
 * @method static Builder|All01f whereDie49($value)
 * @method static Builder|All01f whereDie50($value)
 * @method static Builder|All01f whereDie51($value)
 * @method static Builder|All01f whereDie52($value)
 * @method static Builder|All01f whereDif01($value)
 * @method static Builder|All01f whereDif02($value)
 * @method static Builder|All01f whereDif03($value)
 * @method static Builder|All01f whereDig01($value)
 * @method static Builder|All01f whereDig02($value)
 * @method static Builder|All01f whereDig03($value)
 * @method static Builder|All01f whereDig04($value)
 * @method static Builder|All01f whereDig05($value)
 * @method static Builder|All01f whereDig06($value)
 * @method static Builder|All01f whereDig07($value)
 * @method static Builder|All01f whereDig08($value)
 * @method static Builder|All01f whereDih01($value)
 * @method static Builder|All01f whereDih02($value)
 * @method static Builder|All01f whereDih03($value)
 * @method static Builder|All01f whereDih04($value)
 * @method static Builder|All01f whereDim01($value)
 * @method static Builder|All01f whereDim02($value)
 * @method static Builder|All01f whereDim03($value)
 * @method static Builder|All01f whereDim04($value)
 * @method static Builder|All01f whereDma01($value)
 * @method static Builder|All01f whereDma02($value)
 * @method static Builder|All01f whereDma03($value)
 * @method static Builder|All01f whereDma04($value)
 * @method static Builder|All01f whereDma05($value)
 * @method static Builder|All01f whereDma06($value)
 * @method static Builder|All01f whereDma07($value)
 * @method static Builder|All01f whereDma08($value)
 * @method static Builder|All01f whereDma09($value)
 * @method static Builder|All01f whereDma10($value)
 * @method static Builder|All01f whereDma11($value)
 * @method static Builder|All01f whereDma12($value)
 * @method static Builder|All01f whereDma13($value)
 * @method static Builder|All01f whereDma14($value)
 * @method static Builder|All01f whereDma15($value)
 * @method static Builder|All01f whereDma16($value)
 * @method static Builder|All01f whereDma17($value)
 * @method static Builder|All01f whereDma18($value)
 * @method static Builder|All01f whereDma19($value)
 * @method static Builder|All01f whereDma20($value)
 * @method static Builder|All01f whereDma21($value)
 * @method static Builder|All01f whereDma22($value)
 * @method static Builder|All01f whereDma23($value)
 * @method static Builder|All01f whereDma24($value)
 * @method static Builder|All01f whereDmb01($value)
 * @method static Builder|All01f whereDmb02($value)
 * @method static Builder|All01f whereDmb03($value)
 * @method static Builder|All01f whereDmb04($value)
 * @method static Builder|All01f whereDmb05($value)
 * @method static Builder|All01f whereDmb06($value)
 * @method static Builder|All01f whereDmb07($value)
 * @method static Builder|All01f whereDmb47($value)
 * @method static Builder|All01f whereDmc01($value)
 * @method static Builder|All01f whereDmc02($value)
 * @method static Builder|All01f whereDmd01($value)
 * @method static Builder|All01f whereDmd02($value)
 * @method static Builder|All01f whereDme49($value)
 * @method static Builder|All01f whereDme50($value)
 * @method static Builder|All01f whereDme51($value)
 * @method static Builder|All01f whereDme52($value)
 * @method static Builder|All01f whereDmf01($value)
 * @method static Builder|All01f whereDmf02($value)
 * @method static Builder|All01f whereDmf03($value)
 * @method static Builder|All01f whereDmg01($value)
 * @method static Builder|All01f whereDmg02($value)
 * @method static Builder|All01f whereDmg03($value)
 * @method static Builder|All01f whereDmg04($value)
 * @method static Builder|All01f whereDmg05($value)
 * @method static Builder|All01f whereDmg06($value)
 * @method static Builder|All01f whereDmg07($value)
 * @method static Builder|All01f whereDmg08($value)
 * @method static Builder|All01f whereDmh01($value)
 * @method static Builder|All01f whereDmh02($value)
 * @method static Builder|All01f whereDmh03($value)
 * @method static Builder|All01f whereDmh04($value)
 * @method static Builder|All01f whereDmm01($value)
 * @method static Builder|All01f whereDmm02($value)
 * @method static Builder|All01f whereDmm03($value)
 * @method static Builder|All01f whereDmm04($value)
 * @method static Builder|All01f whereEnte($value)
 * @method static Builder|All01f whereId($value)
 * @method static Builder|All01f wherePpa01($value)
 * @method static Builder|All01f wherePpa02($value)
 * @method static Builder|All01f wherePpa03($value)
 * @method static Builder|All01f wherePpa04($value)
 * @method static Builder|All01f wherePpa05($value)
 * @method static Builder|All01f wherePpa06($value)
 * @method static Builder|All01f wherePpa07($value)
 * @method static Builder|All01f wherePpa08($value)
 * @method static Builder|All01f wherePpa09($value)
 * @method static Builder|All01f wherePpa10($value)
 * @method static Builder|All01f wherePpa11($value)
 * @method static Builder|All01f wherePpa12($value)
 * @method static Builder|All01f wherePpa13($value)
 * @method static Builder|All01f wherePpa14($value)
 * @method static Builder|All01f wherePpa15($value)
 * @method static Builder|All01f wherePpa16($value)
 * @method static Builder|All01f wherePpa17($value)
 * @method static Builder|All01f wherePpa18($value)
 * @method static Builder|All01f wherePpa19($value)
 * @method static Builder|All01f wherePpa20($value)
 * @method static Builder|All01f wherePpa21($value)
 * @method static Builder|All01f wherePpa22($value)
 * @method static Builder|All01f wherePpa23($value)
 * @method static Builder|All01f wherePpa24($value)
 * @method static Builder|All01f wherePpb01($value)
 * @method static Builder|All01f wherePpb02($value)
 * @method static Builder|All01f wherePpb03($value)
 * @method static Builder|All01f wherePpb04($value)
 * @method static Builder|All01f wherePpb05($value)
 * @method static Builder|All01f wherePpb06($value)
 * @method static Builder|All01f wherePpb07($value)
 * @method static Builder|All01f wherePpb47($value)
 * @method static Builder|All01f wherePpc01($value)
 * @method static Builder|All01f wherePpc02($value)
 * @method static Builder|All01f wherePpd01($value)
 * @method static Builder|All01f wherePpd02($value)
 * @method static Builder|All01f wherePpe49($value)
 * @method static Builder|All01f wherePpe50($value)
 * @method static Builder|All01f wherePpe51($value)
 * @method static Builder|All01f wherePpe52($value)
 * @method static Builder|All01f wherePpf01($value)
 * @method static Builder|All01f wherePpf02($value)
 * @method static Builder|All01f wherePpf03($value)
 * @method static Builder|All01f wherePpg01($value)
 * @method static Builder|All01f wherePpg02($value)
 * @method static Builder|All01f wherePpg03($value)
 * @method static Builder|All01f wherePpg04($value)
 * @method static Builder|All01f wherePpg05($value)
 * @method static Builder|All01f wherePpg06($value)
 * @method static Builder|All01f wherePpg07($value)
 * @method static Builder|All01f wherePpg08($value)
 * @method static Builder|All01f wherePph01($value)
 * @method static Builder|All01f wherePph02($value)
 * @method static Builder|All01f wherePph03($value)
 * @method static Builder|All01f wherePph04($value)
 * @method static Builder|All01f wherePpm01($value)
 * @method static Builder|All01f wherePpm02($value)
 * @method static Builder|All01f wherePpm03($value)
 * @method static Builder|All01f wherePpm04($value)
 * @method static Builder|All01f wherePta01($value)
 * @method static Builder|All01f wherePta02($value)
 * @method static Builder|All01f wherePta03($value)
 * @method static Builder|All01f wherePta04($value)
 * @method static Builder|All01f wherePta05($value)
 * @method static Builder|All01f wherePta06($value)
 * @method static Builder|All01f wherePta07($value)
 * @method static Builder|All01f wherePta08($value)
 * @method static Builder|All01f wherePta09($value)
 * @method static Builder|All01f wherePta10($value)
 * @method static Builder|All01f wherePta11($value)
 * @method static Builder|All01f wherePta12($value)
 * @method static Builder|All01f wherePta13($value)
 * @method static Builder|All01f wherePta14($value)
 * @method static Builder|All01f wherePta15($value)
 * @method static Builder|All01f wherePta16($value)
 * @method static Builder|All01f wherePta17($value)
 * @method static Builder|All01f wherePta18($value)
 * @method static Builder|All01f wherePta19($value)
 * @method static Builder|All01f wherePta20($value)
 * @method static Builder|All01f wherePta21($value)
 * @method static Builder|All01f wherePta22($value)
 * @method static Builder|All01f wherePta23($value)
 * @method static Builder|All01f wherePta24($value)
 * @method static Builder|All01f wherePtb01($value)
 * @method static Builder|All01f wherePtb02($value)
 * @method static Builder|All01f wherePtb03($value)
 * @method static Builder|All01f wherePtb04($value)
 * @method static Builder|All01f wherePtb05($value)
 * @method static Builder|All01f wherePtb06($value)
 * @method static Builder|All01f wherePtb07($value)
 * @method static Builder|All01f wherePtb47($value)
 * @method static Builder|All01f wherePtc01($value)
 * @method static Builder|All01f wherePtc02($value)
 * @method static Builder|All01f wherePtd01($value)
 * @method static Builder|All01f wherePtd02($value)
 * @method static Builder|All01f wherePte49($value)
 * @method static Builder|All01f wherePte50($value)
 * @method static Builder|All01f wherePte51($value)
 * @method static Builder|All01f wherePte52($value)
 * @method static Builder|All01f wherePtf01($value)
 * @method static Builder|All01f wherePtf02($value)
 * @method static Builder|All01f wherePtf03($value)
 * @method static Builder|All01f wherePtg01($value)
 * @method static Builder|All01f wherePtg02($value)
 * @method static Builder|All01f wherePtg03($value)
 * @method static Builder|All01f wherePtg04($value)
 * @method static Builder|All01f wherePtg05($value)
 * @method static Builder|All01f wherePtg06($value)
 * @method static Builder|All01f wherePtg07($value)
 * @method static Builder|All01f wherePtg08($value)
 * @method static Builder|All01f wherePth01($value)
 * @method static Builder|All01f wherePth02($value)
 * @method static Builder|All01f wherePth03($value)
 * @method static Builder|All01f wherePth04($value)
 * @method static Builder|All01f wherePtm01($value)
 * @method static Builder|All01f wherePtm02($value)
 * @method static Builder|All01f wherePtm03($value)
 * @method static Builder|All01f wherePtm04($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\All01fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class All01f extends BaseModel
{
    protected $table = 'all01f';
}
