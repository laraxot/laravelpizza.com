<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Orar00l1.
 *
 * @property int $id
 * @property int|null $enteap
 * @property string|null $orannu
 * @property string|null $orcodi
 * @property int|null $orent1
 * @property int|null $orusc1
 * @property int|null $orent2
 * @property int|null $orusc2
 * @property int|null $orent3
 * @property int|null $orusc3
 * @property int|null $orent4
 * @property int|null $orusc4
 * @property string|null $oriniz
 * @property string|null $orattr
 * @property int|null $ortea1
 * @property int|null $ortua1
 * @property int|null $ortea2
 * @property int|null $ortua2
 * @property int|null $ortea3
 * @property int|null $ortua3
 * @property int|null $ortea4
 * @property int|null $ortua4
 * @property int|null $orter1
 * @property int|null $ortur1
 * @property int|null $orter2
 * @property int|null $ortur2
 * @property int|null $orter3
 * @property int|null $ortur3
 * @property int|null $orter4
 * @property int|null $ortur4
 * @property int|null $oraea1
 * @property int|null $oraer1
 * @property int|null $oraua1
 * @property int|null $oraur1
 * @property int|null $oraea2
 * @property int|null $oraer2
 * @property int|null $oraua2
 * @property int|null $oraur2
 * @property int|null $oraea3
 * @property int|null $oraer3
 * @property int|null $oraua3
 * @property int|null $oraur3
 * @property int|null $oraea4
 * @property int|null $oraer4
 * @property int|null $oraua4
 * @property int|null $oraur4
 * @property int|null $orinte
 * @property int|null $ortobb
 * @property int|null $orttot
 * @property int|null $ordife
 * @property int|null $ordifu
 * @property int|null $ormrit
 * @property int|null $ornoti
 * @property int|null $ornotf
 * @property int|null $orpaus
 * @property string|null $ormanu
 * @property string|null $ornega
 * @property int|null $ordal
 * @property int|null $oral
 * @property string|null $orfaco
 * @property int|null $orfaa1
 * @property int|null $orfaa2
 * @property int|null $orfaa3
 * @property int|null $orfaa4
 * @property int|null $orfaa5
 * @property int|null $orfaa6
 * @property int|null $orfaa7
 * @property int|null $orfaa8
 * @property string|null $orcom1
 * @property string|null $orcom2
 * @property string|null $orcom3
 * @property int|null $orcom4
 * @property int|null $orcom5
 * @property int|null $orcom6
 * @property int|null $orcom7
 * @property int|null $oxent1
 * @property int|null $oxusc1
 * @property int|null $oxent2
 * @property int|null $oxusc2
 * @property int|null $oxent3
 * @property int|null $oxusc3
 * @property int|null $oxent4
 * @property int|null $oxusc4
 * @property int|null $oxtea1
 * @property int|null $oxtua1
 * @property int|null $oxtea2
 * @property int|null $oxtua2
 * @property int|null $oxtea3
 * @property int|null $oxtua3
 * @property int|null $oxtea4
 * @property int|null $oxtua4
 * @property int|null $oxter1
 * @property int|null $oxtur1
 * @property int|null $oxter2
 * @property int|null $oxtur2
 * @property int|null $oxter3
 * @property int|null $oxtur3
 * @property int|null $oxter4
 * @property int|null $oxtur4
 * @property int|null $oxttot
 * @property int|null $oxdife
 * @property int|null $oxdifu
 * @property int|null $oxnoti
 * @property int|null $oxnotf
 * @property int|null $oxpaus
 * @property int|null $oxinte
 * @property int|null $oxmrit
 *
 * @method static Builder|Orar00l1 newModelQuery()
 * @method static Builder|Orar00l1 newQuery()
 * @method static Builder|Orar00l1 query()
 * @method static Builder|Orar00l1 whereEnteap($value)
 * @method static Builder|Orar00l1 whereId($value)
 * @method static Builder|Orar00l1 whereOraea1($value)
 * @method static Builder|Orar00l1 whereOraea2($value)
 * @method static Builder|Orar00l1 whereOraea3($value)
 * @method static Builder|Orar00l1 whereOraea4($value)
 * @method static Builder|Orar00l1 whereOraer1($value)
 * @method static Builder|Orar00l1 whereOraer2($value)
 * @method static Builder|Orar00l1 whereOraer3($value)
 * @method static Builder|Orar00l1 whereOraer4($value)
 * @method static Builder|Orar00l1 whereOral($value)
 * @method static Builder|Orar00l1 whereOrannu($value)
 * @method static Builder|Orar00l1 whereOrattr($value)
 * @method static Builder|Orar00l1 whereOraua1($value)
 * @method static Builder|Orar00l1 whereOraua2($value)
 * @method static Builder|Orar00l1 whereOraua3($value)
 * @method static Builder|Orar00l1 whereOraua4($value)
 * @method static Builder|Orar00l1 whereOraur1($value)
 * @method static Builder|Orar00l1 whereOraur2($value)
 * @method static Builder|Orar00l1 whereOraur3($value)
 * @method static Builder|Orar00l1 whereOraur4($value)
 * @method static Builder|Orar00l1 whereOrcodi($value)
 * @method static Builder|Orar00l1 whereOrcom1($value)
 * @method static Builder|Orar00l1 whereOrcom2($value)
 * @method static Builder|Orar00l1 whereOrcom3($value)
 * @method static Builder|Orar00l1 whereOrcom4($value)
 * @method static Builder|Orar00l1 whereOrcom5($value)
 * @method static Builder|Orar00l1 whereOrcom6($value)
 * @method static Builder|Orar00l1 whereOrcom7($value)
 * @method static Builder|Orar00l1 whereOrdal($value)
 * @method static Builder|Orar00l1 whereOrdife($value)
 * @method static Builder|Orar00l1 whereOrdifu($value)
 * @method static Builder|Orar00l1 whereOrent1($value)
 * @method static Builder|Orar00l1 whereOrent2($value)
 * @method static Builder|Orar00l1 whereOrent3($value)
 * @method static Builder|Orar00l1 whereOrent4($value)
 * @method static Builder|Orar00l1 whereOrfaa1($value)
 * @method static Builder|Orar00l1 whereOrfaa2($value)
 * @method static Builder|Orar00l1 whereOrfaa3($value)
 * @method static Builder|Orar00l1 whereOrfaa4($value)
 * @method static Builder|Orar00l1 whereOrfaa5($value)
 * @method static Builder|Orar00l1 whereOrfaa6($value)
 * @method static Builder|Orar00l1 whereOrfaa7($value)
 * @method static Builder|Orar00l1 whereOrfaa8($value)
 * @method static Builder|Orar00l1 whereOrfaco($value)
 * @method static Builder|Orar00l1 whereOriniz($value)
 * @method static Builder|Orar00l1 whereOrinte($value)
 * @method static Builder|Orar00l1 whereOrmanu($value)
 * @method static Builder|Orar00l1 whereOrmrit($value)
 * @method static Builder|Orar00l1 whereOrnega($value)
 * @method static Builder|Orar00l1 whereOrnotf($value)
 * @method static Builder|Orar00l1 whereOrnoti($value)
 * @method static Builder|Orar00l1 whereOrpaus($value)
 * @method static Builder|Orar00l1 whereOrtea1($value)
 * @method static Builder|Orar00l1 whereOrtea2($value)
 * @method static Builder|Orar00l1 whereOrtea3($value)
 * @method static Builder|Orar00l1 whereOrtea4($value)
 * @method static Builder|Orar00l1 whereOrter1($value)
 * @method static Builder|Orar00l1 whereOrter2($value)
 * @method static Builder|Orar00l1 whereOrter3($value)
 * @method static Builder|Orar00l1 whereOrter4($value)
 * @method static Builder|Orar00l1 whereOrtobb($value)
 * @method static Builder|Orar00l1 whereOrttot($value)
 * @method static Builder|Orar00l1 whereOrtua1($value)
 * @method static Builder|Orar00l1 whereOrtua2($value)
 * @method static Builder|Orar00l1 whereOrtua3($value)
 * @method static Builder|Orar00l1 whereOrtua4($value)
 * @method static Builder|Orar00l1 whereOrtur1($value)
 * @method static Builder|Orar00l1 whereOrtur2($value)
 * @method static Builder|Orar00l1 whereOrtur3($value)
 * @method static Builder|Orar00l1 whereOrtur4($value)
 * @method static Builder|Orar00l1 whereOrusc1($value)
 * @method static Builder|Orar00l1 whereOrusc2($value)
 * @method static Builder|Orar00l1 whereOrusc3($value)
 * @method static Builder|Orar00l1 whereOrusc4($value)
 * @method static Builder|Orar00l1 whereOxdife($value)
 * @method static Builder|Orar00l1 whereOxdifu($value)
 * @method static Builder|Orar00l1 whereOxent1($value)
 * @method static Builder|Orar00l1 whereOxent2($value)
 * @method static Builder|Orar00l1 whereOxent3($value)
 * @method static Builder|Orar00l1 whereOxent4($value)
 * @method static Builder|Orar00l1 whereOxinte($value)
 * @method static Builder|Orar00l1 whereOxmrit($value)
 * @method static Builder|Orar00l1 whereOxnotf($value)
 * @method static Builder|Orar00l1 whereOxnoti($value)
 * @method static Builder|Orar00l1 whereOxpaus($value)
 * @method static Builder|Orar00l1 whereOxtea1($value)
 * @method static Builder|Orar00l1 whereOxtea2($value)
 * @method static Builder|Orar00l1 whereOxtea3($value)
 * @method static Builder|Orar00l1 whereOxtea4($value)
 * @method static Builder|Orar00l1 whereOxter1($value)
 * @method static Builder|Orar00l1 whereOxter2($value)
 * @method static Builder|Orar00l1 whereOxter3($value)
 * @method static Builder|Orar00l1 whereOxter4($value)
 * @method static Builder|Orar00l1 whereOxttot($value)
 * @method static Builder|Orar00l1 whereOxtua1($value)
 * @method static Builder|Orar00l1 whereOxtua2($value)
 * @method static Builder|Orar00l1 whereOxtua3($value)
 * @method static Builder|Orar00l1 whereOxtua4($value)
 * @method static Builder|Orar00l1 whereOxtur1($value)
 * @method static Builder|Orar00l1 whereOxtur2($value)
 * @method static Builder|Orar00l1 whereOxtur3($value)
 * @method static Builder|Orar00l1 whereOxtur4($value)
 * @method static Builder|Orar00l1 whereOxusc1($value)
 * @method static Builder|Orar00l1 whereOxusc2($value)
 * @method static Builder|Orar00l1 whereOxusc3($value)
 * @method static Builder|Orar00l1 whereOxusc4($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Orar00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Orar00l1 extends BaseModel
{
    protected $table = 'orar00l1';
}
