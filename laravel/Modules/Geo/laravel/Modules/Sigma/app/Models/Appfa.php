<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Appfa.
 *
 * @method static Builder|Appfa newModelQuery()
 * @method static Builder|Appfa newQuery()
 * @method static Builder|Appfa query()
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $yonome
 * @property string|null $yome
 * @property string|null $decorr
 * @property string|null $tiptas
 * @property string|null $flagch
 * @property string|null $cath
 * @property string|null $fash
 * @property string|null $proh
 * @property string|null $posh
 * @property string|null $catn
 * @property string|null $fasn
 * @property string|null $pron
 * @property string|null $posn
 * @property string|null $note
 * @property string|null $nomeap
 * @property string|null $dataap
 *
 * @method static Builder|Appfa whereCath($value)
 * @method static Builder|Appfa whereCatn($value)
 * @method static Builder|Appfa whereDataap($value)
 * @method static Builder|Appfa whereDecorr($value)
 * @method static Builder|Appfa whereEnte($value)
 * @method static Builder|Appfa whereFash($value)
 * @method static Builder|Appfa whereFasn($value)
 * @method static Builder|Appfa whereFlagch($value)
 * @method static Builder|Appfa whereId($value)
 * @method static Builder|Appfa whereMatr($value)
 * @method static Builder|Appfa whereNomeap($value)
 * @method static Builder|Appfa whereNote($value)
 * @method static Builder|Appfa wherePosh($value)
 * @method static Builder|Appfa wherePosn($value)
 * @method static Builder|Appfa whereProh($value)
 * @method static Builder|Appfa wherePron($value)
 * @method static Builder|Appfa whereTiptas($value)
 * @method static Builder|Appfa whereYome($value)
 * @method static Builder|Appfa whereYonome($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AppfaFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Appfa extends BaseModel
{
    protected $table = 'appfa';
}
