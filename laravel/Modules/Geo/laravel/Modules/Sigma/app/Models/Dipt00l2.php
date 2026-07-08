<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Dipt00l2.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $dtannu
 * @property string|null $dtmatr
 * @property string|null $dtturn
 * @property string|null $dtdal
 * @property string|null $dtal
 * @property string|null $dtcom1
 * @property string|null $dtcom2
 * @property string|null $dtcom3
 * @property string|null $dtcom4
 *
 * @method static Builder|Dipt00l2 newModelQuery()
 * @method static Builder|Dipt00l2 newQuery()
 * @method static Builder|Dipt00l2 query()
 * @method static Builder|Dipt00l2 whereDtal($value)
 * @method static Builder|Dipt00l2 whereDtannu($value)
 * @method static Builder|Dipt00l2 whereDtcom1($value)
 * @method static Builder|Dipt00l2 whereDtcom2($value)
 * @method static Builder|Dipt00l2 whereDtcom3($value)
 * @method static Builder|Dipt00l2 whereDtcom4($value)
 * @method static Builder|Dipt00l2 whereDtdal($value)
 * @method static Builder|Dipt00l2 whereDtmatr($value)
 * @method static Builder|Dipt00l2 whereDtturn($value)
 * @method static Builder|Dipt00l2 whereEnteap($value)
 * @method static Builder|Dipt00l2 whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Dipt00l2Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Dipt00l2 extends BaseModel
{
    protected $table = 'dipt00l2';
}
