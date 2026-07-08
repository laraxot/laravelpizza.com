<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Orar00lx.
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
 * @method static Builder|Orar00lx newModelQuery()
 * @method static Builder|Orar00lx newQuery()
 * @method static Builder|Orar00lx query()
 * @method static Builder|Orar00lx whereEnteap($value)
 * @method static Builder|Orar00lx whereId($value)
 * @method static Builder|Orar00lx whereOraea1($value)
 * @method static Builder|Orar00lx whereOraea2($value)
 * @method static Builder|Orar00lx whereOraea3($value)
 * @method static Builder|Orar00lx whereOraea4($value)
 * @method static Builder|Orar00lx whereOraer1($value)
 * @method static Builder|Orar00lx whereOraer2($value)
 * @method static Builder|Orar00lx whereOraer3($value)
 * @method static Builder|Orar00lx whereOraer4($value)
 * @method static Builder|Orar00lx whereOral($value)
 * @method static Builder|Orar00lx whereOrannu($value)
 * @method static Builder|Orar00lx whereOrattr($value)
 * @method static Builder|Orar00lx whereOraua1($value)
 * @method static Builder|Orar00lx whereOraua2($value)
 * @method static Builder|Orar00lx whereOraua3($value)
 * @method static Builder|Orar00lx whereOraua4($value)
 * @method static Builder|Orar00lx whereOraur1($value)
 * @method static Builder|Orar00lx whereOraur2($value)
 * @method static Builder|Orar00lx whereOraur3($value)
 * @method static Builder|Orar00lx whereOraur4($value)
 * @method static Builder|Orar00lx whereOrcodi($value)
 * @method static Builder|Orar00lx whereOrcom1($value)
 * @method static Builder|Orar00lx whereOrcom2($value)
 * @method static Builder|Orar00lx whereOrcom3($value)
 * @method static Builder|Orar00lx whereOrcom4($value)
 * @method static Builder|Orar00lx whereOrcom5($value)
 * @method static Builder|Orar00lx whereOrcom6($value)
 * @method static Builder|Orar00lx whereOrcom7($value)
 * @method static Builder|Orar00lx whereOrdal($value)
 * @method static Builder|Orar00lx whereOrdife($value)
 * @method static Builder|Orar00lx whereOrdifu($value)
 * @method static Builder|Orar00lx whereOrent1($value)
 * @method static Builder|Orar00lx whereOrent2($value)
 * @method static Builder|Orar00lx whereOrent3($value)
 * @method static Builder|Orar00lx whereOrent4($value)
 * @method static Builder|Orar00lx whereOrfaa1($value)
 * @method static Builder|Orar00lx whereOrfaa2($value)
 * @method static Builder|Orar00lx whereOrfaa3($value)
 * @method static Builder|Orar00lx whereOrfaa4($value)
 * @method static Builder|Orar00lx whereOrfaa5($value)
 * @method static Builder|Orar00lx whereOrfaa6($value)
 * @method static Builder|Orar00lx whereOrfaa7($value)
 * @method static Builder|Orar00lx whereOrfaa8($value)
 * @method static Builder|Orar00lx whereOrfaco($value)
 * @method static Builder|Orar00lx whereOriniz($value)
 * @method static Builder|Orar00lx whereOrinte($value)
 * @method static Builder|Orar00lx whereOrmanu($value)
 * @method static Builder|Orar00lx whereOrmrit($value)
 * @method static Builder|Orar00lx whereOrnega($value)
 * @method static Builder|Orar00lx whereOrnotf($value)
 * @method static Builder|Orar00lx whereOrnoti($value)
 * @method static Builder|Orar00lx whereOrpaus($value)
 * @method static Builder|Orar00lx whereOrtea1($value)
 * @method static Builder|Orar00lx whereOrtea2($value)
 * @method static Builder|Orar00lx whereOrtea3($value)
 * @method static Builder|Orar00lx whereOrtea4($value)
 * @method static Builder|Orar00lx whereOrter1($value)
 * @method static Builder|Orar00lx whereOrter2($value)
 * @method static Builder|Orar00lx whereOrter3($value)
 * @method static Builder|Orar00lx whereOrter4($value)
 * @method static Builder|Orar00lx whereOrtobb($value)
 * @method static Builder|Orar00lx whereOrttot($value)
 * @method static Builder|Orar00lx whereOrtua1($value)
 * @method static Builder|Orar00lx whereOrtua2($value)
 * @method static Builder|Orar00lx whereOrtua3($value)
 * @method static Builder|Orar00lx whereOrtua4($value)
 * @method static Builder|Orar00lx whereOrtur1($value)
 * @method static Builder|Orar00lx whereOrtur2($value)
 * @method static Builder|Orar00lx whereOrtur3($value)
 * @method static Builder|Orar00lx whereOrtur4($value)
 * @method static Builder|Orar00lx whereOrusc1($value)
 * @method static Builder|Orar00lx whereOrusc2($value)
 * @method static Builder|Orar00lx whereOrusc3($value)
 * @method static Builder|Orar00lx whereOrusc4($value)
 * @method static Builder|Orar00lx whereOxdife($value)
 * @method static Builder|Orar00lx whereOxdifu($value)
 * @method static Builder|Orar00lx whereOxent1($value)
 * @method static Builder|Orar00lx whereOxent2($value)
 * @method static Builder|Orar00lx whereOxent3($value)
 * @method static Builder|Orar00lx whereOxent4($value)
 * @method static Builder|Orar00lx whereOxinte($value)
 * @method static Builder|Orar00lx whereOxmrit($value)
 * @method static Builder|Orar00lx whereOxnotf($value)
 * @method static Builder|Orar00lx whereOxnoti($value)
 * @method static Builder|Orar00lx whereOxpaus($value)
 * @method static Builder|Orar00lx whereOxtea1($value)
 * @method static Builder|Orar00lx whereOxtea2($value)
 * @method static Builder|Orar00lx whereOxtea3($value)
 * @method static Builder|Orar00lx whereOxtea4($value)
 * @method static Builder|Orar00lx whereOxter1($value)
 * @method static Builder|Orar00lx whereOxter2($value)
 * @method static Builder|Orar00lx whereOxter3($value)
 * @method static Builder|Orar00lx whereOxter4($value)
 * @method static Builder|Orar00lx whereOxttot($value)
 * @method static Builder|Orar00lx whereOxtua1($value)
 * @method static Builder|Orar00lx whereOxtua2($value)
 * @method static Builder|Orar00lx whereOxtua3($value)
 * @method static Builder|Orar00lx whereOxtua4($value)
 * @method static Builder|Orar00lx whereOxtur1($value)
 * @method static Builder|Orar00lx whereOxtur2($value)
 * @method static Builder|Orar00lx whereOxtur3($value)
 * @method static Builder|Orar00lx whereOxtur4($value)
 * @method static Builder|Orar00lx whereOxusc1($value)
 * @method static Builder|Orar00lx whereOxusc2($value)
 * @method static Builder|Orar00lx whereOxusc3($value)
 * @method static Builder|Orar00lx whereOxusc4($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Orar00lxFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Orar00lx extends BaseModel
{
    protected $table = 'orar00lx';
}
