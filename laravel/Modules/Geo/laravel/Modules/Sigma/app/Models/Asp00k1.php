<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Asp00k1.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $matr
 * @property string|null $tipasp
 * @property string|null $aspin
 * @property string|null $aspte
 * @property string|null $aspco
 * @property string|null $numrid
 * @property string|null $aspper
 * @property string|null $aspann
 * @property string|null $asptip
 * @property string|null $aspdat
 * @property string|null $aspnum
 * @property string|null $asp2ki
 * @property string|null $asp2kf
 * @property string|null $asp2kc
 * @property string|null $asp2kp
 * @property string|null $asp001
 * @property string|null $asp002
 * @property string|null $asp003
 * @property string|null $asp004
 * @property string|null $asp005
 *
 * @method static Builder|Asp00k1 newModelQuery()
 * @method static Builder|Asp00k1 newQuery()
 * @method static Builder|Asp00k1 query()
 * @method static Builder|Asp00k1 whereAsp001($value)
 * @method static Builder|Asp00k1 whereAsp002($value)
 * @method static Builder|Asp00k1 whereAsp003($value)
 * @method static Builder|Asp00k1 whereAsp004($value)
 * @method static Builder|Asp00k1 whereAsp005($value)
 * @method static Builder|Asp00k1 whereAsp2kc($value)
 * @method static Builder|Asp00k1 whereAsp2kf($value)
 * @method static Builder|Asp00k1 whereAsp2ki($value)
 * @method static Builder|Asp00k1 whereAsp2kp($value)
 * @method static Builder|Asp00k1 whereAspann($value)
 * @method static Builder|Asp00k1 whereAspco($value)
 * @method static Builder|Asp00k1 whereAspdat($value)
 * @method static Builder|Asp00k1 whereAspin($value)
 * @method static Builder|Asp00k1 whereAspnum($value)
 * @method static Builder|Asp00k1 whereAspper($value)
 * @method static Builder|Asp00k1 whereAspte($value)
 * @method static Builder|Asp00k1 whereAsptip($value)
 * @method static Builder|Asp00k1 whereEnte($value)
 * @method static Builder|Asp00k1 whereId($value)
 * @method static Builder|Asp00k1 whereMatr($value)
 * @method static Builder|Asp00k1 whereNumrid($value)
 * @method static Builder|Asp00k1 whereTipasp($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Asp00k1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Asp00k1 extends BaseModel
{
    protected $table = 'asp00k1';
}
