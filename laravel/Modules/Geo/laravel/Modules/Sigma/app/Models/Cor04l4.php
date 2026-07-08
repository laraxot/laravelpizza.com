<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cor04l4.
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
 * @method static Builder|Cor04l4 newModelQuery()
 * @method static Builder|Cor04l4 newQuery()
 * @method static Builder|Cor04l4 query()
 * @method static Builder|Cor04l4 whereAaliq($value)
 * @method static Builder|Cor04l4 whereAnncor($value)
 * @method static Builder|Cor04l4 whereAnno($value)
 * @method static Builder|Cor04l4 whereArea($value)
 * @method static Builder|Cor04l4 whereCc1($value)
 * @method static Builder|Cor04l4 whereCc2($value)
 * @method static Builder|Cor04l4 whereCc3($value)
 * @method static Builder|Cor04l4 whereCodcor($value)
 * @method static Builder|Cor04l4 whereCor001($value)
 * @method static Builder|Cor04l4 whereCor002($value)
 * @method static Builder|Cor04l4 whereDatcar($value)
 * @method static Builder|Cor04l4 whereDatmis($value)
 * @method static Builder|Cor04l4 whereEnte($value)
 * @method static Builder|Cor04l4 whereForm($value)
 * @method static Builder|Cor04l4 whereId($value)
 * @method static Builder|Cor04l4 whereImpuni($value)
 * @method static Builder|Cor04l4 whereIstit($value)
 * @method static Builder|Cor04l4 whereMatr($value)
 * @method static Builder|Cor04l4 whereMese($value)
 * @method static Builder|Cor04l4 whereMmliq($value)
 * @method static Builder|Cor04l4 whereNumero($value)
 * @method static Builder|Cor04l4 whereNumpro($value)
 * @method static Builder|Cor04l4 whereProfil($value)
 * @method static Builder|Cor04l4 whereQtac($value)
 * @method static Builder|Cor04l4 whereRisul($value)
 * @method static Builder|Cor04l4 whereSeqc($value)
 * @method static Builder|Cor04l4 whereTipcod($value)
 * @method static Builder|Cor04l4 whereTipmc($value)
 * @method static Builder|Cor04l4 whereTipod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cor04l4Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cor04l4 extends BaseModel
{
    protected $table = 'cor04l4';
}
