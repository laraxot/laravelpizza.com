<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Ced08l5.
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
 * @method static Builder|Ced08l5 newModelQuery()
 * @method static Builder|Ced08l5 newQuery()
 * @method static Builder|Ced08l5 query()
 * @method static Builder|Ced08l5 whereAarif($value)
 * @method static Builder|Ced08l5 whereCongeu($value)
 * @method static Builder|Ced08l5 whereCongua($value)
 * @method static Builder|Ced08l5 whereEnte($value)
 * @method static Builder|Ced08l5 whereId($value)
 * @method static Builder|Ced08l5 whereImpoeu($value)
 * @method static Builder|Ced08l5 whereOrestr($value)
 * @method static Builder|Ced08l5 whereSannli($value)
 * @method static Builder|Ced08l5 whereScont($value)
 * @method static Builder|Ced08l5 whereSmatr($value)
 * @method static Builder|Ced08l5 whereSvocfi($value)
 * @method static Builder|Ced08l5 whereTotale($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Ced08l5Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Ced08l5 extends BaseModel
{
    protected $table = 'ced08l5';
}
