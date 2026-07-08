<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ced08l2.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $scont
 * @property string|null $smatr
 * @property string|null $sannli
 * @property string|null $aarif
 * @property string|null $svocfi
 * @property string|null $totale
 * @property string|null $impoeu
 * @property string|null $orestr
 * @property string|null $congua
 * @property string|null $congeu
 *
 * @method static Builder|Ced08l2 newModelQuery()
 * @method static Builder|Ced08l2 newQuery()
 * @method static Builder|Ced08l2 query()
 * @method static Builder|Ced08l2 whereAarif($value)
 * @method static Builder|Ced08l2 whereCongeu($value)
 * @method static Builder|Ced08l2 whereCongua($value)
 * @method static Builder|Ced08l2 whereEnte($value)
 * @method static Builder|Ced08l2 whereId($value)
 * @method static Builder|Ced08l2 whereImpoeu($value)
 * @method static Builder|Ced08l2 whereOrestr($value)
 * @method static Builder|Ced08l2 whereSannli($value)
 * @method static Builder|Ced08l2 whereScont($value)
 * @method static Builder|Ced08l2 whereSmatr($value)
 * @method static Builder|Ced08l2 whereSvocfi($value)
 * @method static Builder|Ced08l2 whereTotale($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ced08l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ced08l2 extends BaseModel
{
    protected $table = 'ced08l2';
}
