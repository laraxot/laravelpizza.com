<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ali12.
 *
 * @property int $id
 * @property string|null $flag
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $area
 * @property string|null $stab
 * @property string|null $repa
 * @property string|null $desar
 * @property string|null $desst
 * @property string|null $desse
 * @property string|null $cont
 * @property string|null $tipco
 * @property string|null $rapp
 * @property string|null $ruolo
 * @property string|null $propro
 * @property string|null $posfun
 * @property string|null $fascia
 * @property string|null $codqua
 * @property string|null $liv
 * @property string|null $oree
 * @property string|null $oret
 * @property string|null $idpsz
 * @property string|null $rapdes
 * @property string|null $despr
 * @property string|null $desco
 * @property string|null $desdi
 * @property string|null $impo1
 * @property string|null $impo2
 * @property string|null $impo3
 * @property string|null $impo4
 * @property string|null $impo5
 * @property string|null $impo6
 * @property string|null $impo7
 * @property string|null $idcam
 * @property string|null $ruo11
 * @property string|null $pro11
 * @property string|null $pos11
 * @property string|null $fas11
 * @property string|null $liv11
 * @property string|null $ore11
 * @property string|null $ort11
 * @property string|null $impo1p
 * @property string|null $impo2p
 * @property string|null $impo3p
 * @property string|null $impo4p
 * @property string|null $impo5p
 * @property string|null $impo6p
 * @property string|null $impo7p
 * @property string|null $delta
 * @property string|null $mesi
 * @property string|null $impo1d
 * @property string|null $impo2d
 * @property string|null $impo3d
 * @property string|null $impo4d
 * @property string|null $impo5d
 * @property string|null $impo6d
 * @property string|null $impo7d
 * @property string|null $datarp
 * @property string|null $datara
 * @property string|null $lib1
 * @property string|null $lib2
 * @property string|null $lib3
 * @property string|null $lib4
 * @property string|null $lib5
 * @property string|null $lib6
 * @property string|null $lib7
 *
 * @method static Builder|Ali12 newModelQuery()
 * @method static Builder|Ali12 newQuery()
 * @method static Builder|Ali12 query()
 * @method static Builder|Ali12 whereArea($value)
 * @method static Builder|Ali12 whereCodqua($value)
 * @method static Builder|Ali12 whereConome($value)
 * @method static Builder|Ali12 whereCont($value)
 * @method static Builder|Ali12 whereDatara($value)
 * @method static Builder|Ali12 whereDatarp($value)
 * @method static Builder|Ali12 whereDelta($value)
 * @method static Builder|Ali12 whereDesar($value)
 * @method static Builder|Ali12 whereDesco($value)
 * @method static Builder|Ali12 whereDesdi($value)
 * @method static Builder|Ali12 whereDespr($value)
 * @method static Builder|Ali12 whereDesse($value)
 * @method static Builder|Ali12 whereDesst($value)
 * @method static Builder|Ali12 whereEnte($value)
 * @method static Builder|Ali12 whereFas11($value)
 * @method static Builder|Ali12 whereFascia($value)
 * @method static Builder|Ali12 whereFlag($value)
 * @method static Builder|Ali12 whereId($value)
 * @method static Builder|Ali12 whereIdcam($value)
 * @method static Builder|Ali12 whereIdpsz($value)
 * @method static Builder|Ali12 whereImpo1($value)
 * @method static Builder|Ali12 whereImpo1d($value)
 * @method static Builder|Ali12 whereImpo1p($value)
 * @method static Builder|Ali12 whereImpo2($value)
 * @method static Builder|Ali12 whereImpo2d($value)
 * @method static Builder|Ali12 whereImpo2p($value)
 * @method static Builder|Ali12 whereImpo3($value)
 * @method static Builder|Ali12 whereImpo3d($value)
 * @method static Builder|Ali12 whereImpo3p($value)
 * @method static Builder|Ali12 whereImpo4($value)
 * @method static Builder|Ali12 whereImpo4d($value)
 * @method static Builder|Ali12 whereImpo4p($value)
 * @method static Builder|Ali12 whereImpo5($value)
 * @method static Builder|Ali12 whereImpo5d($value)
 * @method static Builder|Ali12 whereImpo5p($value)
 * @method static Builder|Ali12 whereImpo6($value)
 * @method static Builder|Ali12 whereImpo6d($value)
 * @method static Builder|Ali12 whereImpo6p($value)
 * @method static Builder|Ali12 whereImpo7($value)
 * @method static Builder|Ali12 whereImpo7d($value)
 * @method static Builder|Ali12 whereImpo7p($value)
 * @method static Builder|Ali12 whereLib1($value)
 * @method static Builder|Ali12 whereLib2($value)
 * @method static Builder|Ali12 whereLib3($value)
 * @method static Builder|Ali12 whereLib4($value)
 * @method static Builder|Ali12 whereLib5($value)
 * @method static Builder|Ali12 whereLib6($value)
 * @method static Builder|Ali12 whereLib7($value)
 * @method static Builder|Ali12 whereLiv($value)
 * @method static Builder|Ali12 whereLiv11($value)
 * @method static Builder|Ali12 whereMatr($value)
 * @method static Builder|Ali12 whereMesi($value)
 * @method static Builder|Ali12 whereNome($value)
 * @method static Builder|Ali12 whereOre11($value)
 * @method static Builder|Ali12 whereOree($value)
 * @method static Builder|Ali12 whereOret($value)
 * @method static Builder|Ali12 whereOrt11($value)
 * @method static Builder|Ali12 wherePos11($value)
 * @method static Builder|Ali12 wherePosfun($value)
 * @method static Builder|Ali12 wherePro11($value)
 * @method static Builder|Ali12 wherePropro($value)
 * @method static Builder|Ali12 whereRapdes($value)
 * @method static Builder|Ali12 whereRapp($value)
 * @method static Builder|Ali12 whereRepa($value)
 * @method static Builder|Ali12 whereRuo11($value)
 * @method static Builder|Ali12 whereRuolo($value)
 * @method static Builder|Ali12 whereStab($value)
 * @method static Builder|Ali12 whereTipco($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ali12Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ali12 extends BaseModel
{
    protected $table = 'ali12';
}
