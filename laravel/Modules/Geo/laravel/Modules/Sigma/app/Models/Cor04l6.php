<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cor04l6.
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
 * @method static Builder|Cor04l6 newModelQuery()
 * @method static Builder|Cor04l6 newQuery()
 * @method static Builder|Cor04l6 query()
 * @method static Builder|Cor04l6 whereAaliq($value)
 * @method static Builder|Cor04l6 whereAnncor($value)
 * @method static Builder|Cor04l6 whereAnno($value)
 * @method static Builder|Cor04l6 whereArea($value)
 * @method static Builder|Cor04l6 whereCc1($value)
 * @method static Builder|Cor04l6 whereCc2($value)
 * @method static Builder|Cor04l6 whereCc3($value)
 * @method static Builder|Cor04l6 whereCodcor($value)
 * @method static Builder|Cor04l6 whereCor001($value)
 * @method static Builder|Cor04l6 whereCor002($value)
 * @method static Builder|Cor04l6 whereDatcar($value)
 * @method static Builder|Cor04l6 whereDatmis($value)
 * @method static Builder|Cor04l6 whereEnte($value)
 * @method static Builder|Cor04l6 whereForm($value)
 * @method static Builder|Cor04l6 whereId($value)
 * @method static Builder|Cor04l6 whereImpuni($value)
 * @method static Builder|Cor04l6 whereIstit($value)
 * @method static Builder|Cor04l6 whereMatr($value)
 * @method static Builder|Cor04l6 whereMese($value)
 * @method static Builder|Cor04l6 whereMmliq($value)
 * @method static Builder|Cor04l6 whereNumero($value)
 * @method static Builder|Cor04l6 whereNumpro($value)
 * @method static Builder|Cor04l6 whereProfil($value)
 * @method static Builder|Cor04l6 whereQtac($value)
 * @method static Builder|Cor04l6 whereRisul($value)
 * @method static Builder|Cor04l6 whereSeqc($value)
 * @method static Builder|Cor04l6 whereTipcod($value)
 * @method static Builder|Cor04l6 whereTipmc($value)
 * @method static Builder|Cor04l6 whereTipod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cor04l6Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cor04l6 extends BaseModel
{
    protected $table = 'cor04l6';
}
