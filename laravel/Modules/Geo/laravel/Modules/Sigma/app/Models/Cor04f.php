<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cor04f.
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
 * @method static Builder|Cor04f newModelQuery()
 * @method static Builder|Cor04f newQuery()
 * @method static Builder|Cor04f query()
 * @method static Builder|Cor04f whereAaliq($value)
 * @method static Builder|Cor04f whereAnncor($value)
 * @method static Builder|Cor04f whereAnno($value)
 * @method static Builder|Cor04f whereArea($value)
 * @method static Builder|Cor04f whereCc1($value)
 * @method static Builder|Cor04f whereCc2($value)
 * @method static Builder|Cor04f whereCc3($value)
 * @method static Builder|Cor04f whereCodcor($value)
 * @method static Builder|Cor04f whereCor001($value)
 * @method static Builder|Cor04f whereCor002($value)
 * @method static Builder|Cor04f whereDatcar($value)
 * @method static Builder|Cor04f whereDatmis($value)
 * @method static Builder|Cor04f whereEnte($value)
 * @method static Builder|Cor04f whereForm($value)
 * @method static Builder|Cor04f whereId($value)
 * @method static Builder|Cor04f whereImpuni($value)
 * @method static Builder|Cor04f whereIstit($value)
 * @method static Builder|Cor04f whereMatr($value)
 * @method static Builder|Cor04f whereMese($value)
 * @method static Builder|Cor04f whereMmliq($value)
 * @method static Builder|Cor04f whereNumero($value)
 * @method static Builder|Cor04f whereNumpro($value)
 * @method static Builder|Cor04f whereProfil($value)
 * @method static Builder|Cor04f whereQtac($value)
 * @method static Builder|Cor04f whereRisul($value)
 * @method static Builder|Cor04f whereSeqc($value)
 * @method static Builder|Cor04f whereTipcod($value)
 * @method static Builder|Cor04f whereTipmc($value)
 * @method static Builder|Cor04f whereTipod($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cor04fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cor04f extends BaseModel
{
    protected $table = 'cor04f';
}
