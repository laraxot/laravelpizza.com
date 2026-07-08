<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Est00f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $dal
 * @property string|null $al
 * @property string|null $matr
 * @property string|null $ora
 * @property string|null $impfis
 * @property string|null $impfi2
 * @property string|null $impfi3
 * @property string|null $vo01
 * @property string|null $vo02
 * @property string|null $vo03
 * @property string|null $impeur
 * @property string|null $impeu2
 * @property string|null $impeu3
 * @property string|null $impora
 * @property string|null $impore
 * @property string|null $perrif
 * @property string|null $campo1
 * @property string|null $campo2
 * @property string|null $des
 * @property string|null $estan
 * @property string|null $impegn
 * @property string|null $cdr
 * @property string|null $impe01
 * @property string|null $impe02
 * @property string|null $impe03
 * @property string|null $impe04
 * @property string|null $cdr01
 * @property string|null $dafa
 * @property string|null $dafa2
 * @property string|null $tiprap
 * @property string|null $codatt
 *
 * @method static Builder|Est00f newModelQuery()
 * @method static Builder|Est00f newQuery()
 * @method static Builder|Est00f query()
 * @method static Builder|Est00f whereAl($value)
 * @method static Builder|Est00f whereCampo1($value)
 * @method static Builder|Est00f whereCampo2($value)
 * @method static Builder|Est00f whereCdr($value)
 * @method static Builder|Est00f whereCdr01($value)
 * @method static Builder|Est00f whereCodatt($value)
 * @method static Builder|Est00f whereDafa($value)
 * @method static Builder|Est00f whereDafa2($value)
 * @method static Builder|Est00f whereDal($value)
 * @method static Builder|Est00f whereDes($value)
 * @method static Builder|Est00f whereEnte($value)
 * @method static Builder|Est00f whereEstan($value)
 * @method static Builder|Est00f whereId($value)
 * @method static Builder|Est00f whereImpe01($value)
 * @method static Builder|Est00f whereImpe02($value)
 * @method static Builder|Est00f whereImpe03($value)
 * @method static Builder|Est00f whereImpe04($value)
 * @method static Builder|Est00f whereImpegn($value)
 * @method static Builder|Est00f whereImpeu2($value)
 * @method static Builder|Est00f whereImpeu3($value)
 * @method static Builder|Est00f whereImpeur($value)
 * @method static Builder|Est00f whereImpfi2($value)
 * @method static Builder|Est00f whereImpfi3($value)
 * @method static Builder|Est00f whereImpfis($value)
 * @method static Builder|Est00f whereImpora($value)
 * @method static Builder|Est00f whereImpore($value)
 * @method static Builder|Est00f whereMatr($value)
 * @method static Builder|Est00f whereOra($value)
 * @method static Builder|Est00f wherePerrif($value)
 * @method static Builder|Est00f whereTiprap($value)
 * @method static Builder|Est00f whereVo01($value)
 * @method static Builder|Est00f whereVo02($value)
 * @method static Builder|Est00f whereVo03($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Est00fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Est00f extends BaseModel
{
    protected $table = 'est00f';
}
