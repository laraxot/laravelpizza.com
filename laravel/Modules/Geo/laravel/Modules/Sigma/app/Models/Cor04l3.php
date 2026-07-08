<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cor04l3.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $anno
 * @property string|null $mese
 * @property string|null $aaliq
 * @property string|null $mmliq
 * @property string|null $seqc
 * @property string|null $profil
 * @property string|null $datcar
 * @property string|null $tipmc
 * @property string|null $anncor
 * @property string|null $codcor
 * @property string|null $form
 * @property string|null $qtac
 * @property string|null $impuni
 * @property string|null $risul
 * @property string|null $istit
 * @property string|null $numpro
 * @property string|null $area
 * @property string|null $numero
 * @property string|null $tipod
 * @property string|null $tipcod
 * @property string|null $cor001
 * @property string|null $cor002
 * @property string|null $datmis
 * @property string|null $cc1
 * @property string|null $cc2
 * @property string|null $cc3
 *
 * @method static Builder|Cor04l3 newModelQuery()
 * @method static Builder|Cor04l3 newQuery()
 * @method static Builder|Cor04l3 query()
 * @method static Builder|Cor04l3 whereAaliq($value)
 * @method static Builder|Cor04l3 whereAnncor($value)
 * @method static Builder|Cor04l3 whereAnno($value)
 * @method static Builder|Cor04l3 whereArea($value)
 * @method static Builder|Cor04l3 whereCc1($value)
 * @method static Builder|Cor04l3 whereCc2($value)
 * @method static Builder|Cor04l3 whereCc3($value)
 * @method static Builder|Cor04l3 whereCodcor($value)
 * @method static Builder|Cor04l3 whereCor001($value)
 * @method static Builder|Cor04l3 whereCor002($value)
 * @method static Builder|Cor04l3 whereDatcar($value)
 * @method static Builder|Cor04l3 whereDatmis($value)
 * @method static Builder|Cor04l3 whereEnte($value)
 * @method static Builder|Cor04l3 whereForm($value)
 * @method static Builder|Cor04l3 whereId($value)
 * @method static Builder|Cor04l3 whereImpuni($value)
 * @method static Builder|Cor04l3 whereIstit($value)
 * @method static Builder|Cor04l3 whereMatr($value)
 * @method static Builder|Cor04l3 whereMese($value)
 * @method static Builder|Cor04l3 whereMmliq($value)
 * @method static Builder|Cor04l3 whereNumero($value)
 * @method static Builder|Cor04l3 whereNumpro($value)
 * @method static Builder|Cor04l3 whereProfil($value)
 * @method static Builder|Cor04l3 whereQtac($value)
 * @method static Builder|Cor04l3 whereRisul($value)
 * @method static Builder|Cor04l3 whereSeqc($value)
 * @method static Builder|Cor04l3 whereTipcod($value)
 * @method static Builder|Cor04l3 whereTipmc($value)
 * @method static Builder|Cor04l3 whereTipod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cor04l3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cor04l3 extends BaseModel
{
    protected $table = 'cor04l3';
}
