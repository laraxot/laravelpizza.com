<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ced08l4.
 *
 * @property int $id
 * @property int|null $ente
 * @property int|null $scont
 * @property int|null $smatr
 * @property int|null $sannli
 * @property int|null $aarif
 * @property int|null $svocfi
 * @property int|null $totale
 * @property string|null $impoeu
 * @property string|null $orestr
 * @property int|null $congua
 * @property string|null $congeu
 *
 * @method static Builder|Ced08l4 newModelQuery()
 * @method static Builder|Ced08l4 newQuery()
 * @method static Builder|Ced08l4 query()
 * @method static Builder|Ced08l4 whereAarif($value)
 * @method static Builder|Ced08l4 whereCongeu($value)
 * @method static Builder|Ced08l4 whereCongua($value)
 * @method static Builder|Ced08l4 whereEnte($value)
 * @method static Builder|Ced08l4 whereId($value)
 * @method static Builder|Ced08l4 whereImpoeu($value)
 * @method static Builder|Ced08l4 whereOrestr($value)
 * @method static Builder|Ced08l4 whereSannli($value)
 * @method static Builder|Ced08l4 whereScont($value)
 * @method static Builder|Ced08l4 whereSmatr($value)
 * @method static Builder|Ced08l4 whereSvocfi($value)
 * @method static Builder|Ced08l4 whereTotale($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ced08l4Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ced08l4 extends BaseModel
{
    protected $table = 'ced08l4';
}
