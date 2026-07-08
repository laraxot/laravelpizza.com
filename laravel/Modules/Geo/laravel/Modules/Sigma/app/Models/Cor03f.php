<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Cor03f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $tabe
 * @property string|null $desc1
 * @property string|null $desc2
 * @property string|null $fondo
 * @property string|null $sauto
 * @property string|null $satte
 * @property string|null $sregr
 * @property string|null $seq
 * @property string|null $form
 * @property string|null $vocep
 * @property string|null $vocen
 * @property string|null $ist
 * @property string|null $qtasn
 *
 * @method static Builder|Cor03f newModelQuery()
 * @method static Builder|Cor03f newQuery()
 * @method static Builder|Cor03f query()
 * @method static Builder|Cor03f whereDesc1($value)
 * @method static Builder|Cor03f whereDesc2($value)
 * @method static Builder|Cor03f whereEnte($value)
 * @method static Builder|Cor03f whereFondo($value)
 * @method static Builder|Cor03f whereForm($value)
 * @method static Builder|Cor03f whereId($value)
 * @method static Builder|Cor03f whereIst($value)
 * @method static Builder|Cor03f whereQtasn($value)
 * @method static Builder|Cor03f whereSatte($value)
 * @method static Builder|Cor03f whereSauto($value)
 * @method static Builder|Cor03f whereSeq($value)
 * @method static Builder|Cor03f whereSregr($value)
 * @method static Builder|Cor03f whereTabe($value)
 * @method static Builder|Cor03f whereVocen($value)
 * @method static Builder|Cor03f whereVocep($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Cor03fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Cor03f extends BaseModel
{
    protected $table = 'cor03f';
}
