<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Sost00l3.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $ssanno
 * @property string|null $ssdal
 * @property string|null $ssal
 * @property string|null $ssesp
 * @property string|null $sscla
 * @property string|null $ssmatr
 * @property string|null $sssta
 * @property string|null $ssrep
 * @property string|null $sspro
 * @property string|null $sspos
 * @property string|null $sosann
 *
 * @method static Builder|Sost00l3 newModelQuery()
 * @method static Builder|Sost00l3 newQuery()
 * @method static Builder|Sost00l3 query()
 * @method static Builder|Sost00l3 whereEnte($value)
 * @method static Builder|Sost00l3 whereId($value)
 * @method static Builder|Sost00l3 whereMatr($value)
 * @method static Builder|Sost00l3 whereSosann($value)
 * @method static Builder|Sost00l3 whereSsal($value)
 * @method static Builder|Sost00l3 whereSsanno($value)
 * @method static Builder|Sost00l3 whereSscla($value)
 * @method static Builder|Sost00l3 whereSsdal($value)
 * @method static Builder|Sost00l3 whereSsesp($value)
 * @method static Builder|Sost00l3 whereSsmatr($value)
 * @method static Builder|Sost00l3 whereSspos($value)
 * @method static Builder|Sost00l3 whereSspro($value)
 * @method static Builder|Sost00l3 whereSsrep($value)
 * @method static Builder|Sost00l3 whereSssta($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Sost00l3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Sost00l3 extends BaseModel
{
    protected $table = 'sost00l3';
}
