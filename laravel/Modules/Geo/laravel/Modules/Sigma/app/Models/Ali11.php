<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ali11.
 *
 * @property int $id
 * @property string|null $flag
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $conome
 * @property string|null $nome
 * @property string|null $datn1
 * @property string|null $sess1
 * @property string|null $idcont
 * @property string|null $idtipc
 * @property string|null $idrapp
 * @property string|null $idruol
 * @property string|null $idpro
 * @property string|null $idpos
 * @property string|null $idcoq
 * @property string|null $idcat
 * @property string|null $idfas
 * @property string|null $idore
 * @property string|null $idort
 * @property string|null $idpsz
 * @property string|null $rapdes
 * @property string|null $despr
 * @property string|null $desco
 * @property string|null $desdi
 * @property string|null $area
 * @property string|null $stab
 * @property string|null $repa
 * @property string|null $desar
 * @property string|null $desst
 * @property string|null $desse
 * @property string|null $idcam
 * @property string|null $idctd
 * @property string|null $idcre
 * @property string|null $dtass
 * @property string|null $dtasu
 * @property string|null $dtast
 * @property string|null $asscau
 * @property string|null $dtasn
 * @property string|null $dtdec
 * @property string|null $dtces
 * @property string|null $dtcet
 * @property string|null $dimcau
 * @property string|null $codra
 * @property string|null $codrad
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
 * @method static Builder|Ali11 newModelQuery()
 * @method static Builder|Ali11 newQuery()
 * @method static Builder|Ali11 query()
 * @method static Builder|Ali11 whereArea($value)
 * @method static Builder|Ali11 whereAsscau($value)
 * @method static Builder|Ali11 whereCodra($value)
 * @method static Builder|Ali11 whereCodrad($value)
 * @method static Builder|Ali11 whereConome($value)
 * @method static Builder|Ali11 whereDatara($value)
 * @method static Builder|Ali11 whereDatarp($value)
 * @method static Builder|Ali11 whereDatn1($value)
 * @method static Builder|Ali11 whereDesar($value)
 * @method static Builder|Ali11 whereDesco($value)
 * @method static Builder|Ali11 whereDesdi($value)
 * @method static Builder|Ali11 whereDespr($value)
 * @method static Builder|Ali11 whereDesse($value)
 * @method static Builder|Ali11 whereDesst($value)
 * @method static Builder|Ali11 whereDimcau($value)
 * @method static Builder|Ali11 whereDtasn($value)
 * @method static Builder|Ali11 whereDtass($value)
 * @method static Builder|Ali11 whereDtast($value)
 * @method static Builder|Ali11 whereDtasu($value)
 * @method static Builder|Ali11 whereDtces($value)
 * @method static Builder|Ali11 whereDtcet($value)
 * @method static Builder|Ali11 whereDtdec($value)
 * @method static Builder|Ali11 whereEnte($value)
 * @method static Builder|Ali11 whereFlag($value)
 * @method static Builder|Ali11 whereId($value)
 * @method static Builder|Ali11 whereIdcam($value)
 * @method static Builder|Ali11 whereIdcat($value)
 * @method static Builder|Ali11 whereIdcont($value)
 * @method static Builder|Ali11 whereIdcoq($value)
 * @method static Builder|Ali11 whereIdcre($value)
 * @method static Builder|Ali11 whereIdctd($value)
 * @method static Builder|Ali11 whereIdfas($value)
 * @method static Builder|Ali11 whereIdore($value)
 * @method static Builder|Ali11 whereIdort($value)
 * @method static Builder|Ali11 whereIdpos($value)
 * @method static Builder|Ali11 whereIdpro($value)
 * @method static Builder|Ali11 whereIdpsz($value)
 * @method static Builder|Ali11 whereIdrapp($value)
 * @method static Builder|Ali11 whereIdruol($value)
 * @method static Builder|Ali11 whereIdtipc($value)
 * @method static Builder|Ali11 whereLib1($value)
 * @method static Builder|Ali11 whereLib2($value)
 * @method static Builder|Ali11 whereLib3($value)
 * @method static Builder|Ali11 whereLib4($value)
 * @method static Builder|Ali11 whereLib5($value)
 * @method static Builder|Ali11 whereLib6($value)
 * @method static Builder|Ali11 whereLib7($value)
 * @method static Builder|Ali11 whereMatr($value)
 * @method static Builder|Ali11 whereNome($value)
 * @method static Builder|Ali11 whereRapdes($value)
 * @method static Builder|Ali11 whereRepa($value)
 * @method static Builder|Ali11 whereSess1($value)
 * @method static Builder|Ali11 whereStab($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ali11Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ali11 extends BaseModel
{
    protected $table = 'ali11';
}
