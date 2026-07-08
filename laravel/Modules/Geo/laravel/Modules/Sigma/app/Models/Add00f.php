<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Add00f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $anno
 * @property string|null $addtip
 * @property string|null $addist
 * @property string|null $provin
 * @property string|null $codreg
 * @property string|null $addnra
 * @property string|null $impdpa
 * @property string|null $imprif
 * @property string|null $imprit
 * @property string|null $addper
 * @property string|null $imp01l
 * @property string|null $imp02l
 * @property string|null $imp03l
 * @property string|null $imp04l
 * @property string|null $imp05l
 * @property string|null $imp06l
 * @property string|null $imp07l
 * @property string|null $imp08l
 * @property string|null $imp09l
 * @property string|null $imp10l
 * @property string|null $imp11l
 * @property string|null $imp12l
 * @property string|null $impdpe
 * @property string|null $imprfe
 * @property string|null $imprte
 * @property string|null $imp01e
 * @property string|null $imp02e
 * @property string|null $imp03e
 * @property string|null $imp04e
 * @property string|null $imp05e
 * @property string|null $imp06e
 * @property string|null $imp07e
 * @property string|null $imp08e
 * @property string|null $imp09e
 * @property string|null $imp10e
 * @property string|null $imp11e
 * @property string|null $imp12e
 *
 * @method static Builder|Add00f newModelQuery()
 * @method static Builder|Add00f newQuery()
 * @method static Builder|Add00f query()
 * @method static Builder|Add00f whereAddist($value)
 * @method static Builder|Add00f whereAddnra($value)
 * @method static Builder|Add00f whereAddper($value)
 * @method static Builder|Add00f whereAddtip($value)
 * @method static Builder|Add00f whereAnno($value)
 * @method static Builder|Add00f whereCodreg($value)
 * @method static Builder|Add00f whereEnte($value)
 * @method static Builder|Add00f whereId($value)
 * @method static Builder|Add00f whereImp01e($value)
 * @method static Builder|Add00f whereImp01l($value)
 * @method static Builder|Add00f whereImp02e($value)
 * @method static Builder|Add00f whereImp02l($value)
 * @method static Builder|Add00f whereImp03e($value)
 * @method static Builder|Add00f whereImp03l($value)
 * @method static Builder|Add00f whereImp04e($value)
 * @method static Builder|Add00f whereImp04l($value)
 * @method static Builder|Add00f whereImp05e($value)
 * @method static Builder|Add00f whereImp05l($value)
 * @method static Builder|Add00f whereImp06e($value)
 * @method static Builder|Add00f whereImp06l($value)
 * @method static Builder|Add00f whereImp07e($value)
 * @method static Builder|Add00f whereImp07l($value)
 * @method static Builder|Add00f whereImp08e($value)
 * @method static Builder|Add00f whereImp08l($value)
 * @method static Builder|Add00f whereImp09e($value)
 * @method static Builder|Add00f whereImp09l($value)
 * @method static Builder|Add00f whereImp10e($value)
 * @method static Builder|Add00f whereImp10l($value)
 * @method static Builder|Add00f whereImp11e($value)
 * @method static Builder|Add00f whereImp11l($value)
 * @method static Builder|Add00f whereImp12e($value)
 * @method static Builder|Add00f whereImp12l($value)
 * @method static Builder|Add00f whereImpdpa($value)
 * @method static Builder|Add00f whereImpdpe($value)
 * @method static Builder|Add00f whereImprfe($value)
 * @method static Builder|Add00f whereImprif($value)
 * @method static Builder|Add00f whereImprit($value)
 * @method static Builder|Add00f whereImprte($value)
 * @method static Builder|Add00f whereMatr($value)
 * @method static Builder|Add00f whereProvin($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Add00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Add00f extends BaseModel
{
    protected $table = 'add00f';
}
