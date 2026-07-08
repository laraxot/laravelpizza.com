<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Dipt00l1.
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
 * @method static Builder|Dipt00l1 newModelQuery()
 * @method static Builder|Dipt00l1 newQuery()
 * @method static Builder|Dipt00l1 query()
 * @method static Builder|Dipt00l1 whereDtal($value)
 * @method static Builder|Dipt00l1 whereDtannu($value)
 * @method static Builder|Dipt00l1 whereDtcom1($value)
 * @method static Builder|Dipt00l1 whereDtcom2($value)
 * @method static Builder|Dipt00l1 whereDtcom3($value)
 * @method static Builder|Dipt00l1 whereDtcom4($value)
 * @method static Builder|Dipt00l1 whereDtdal($value)
 * @method static Builder|Dipt00l1 whereDtmatr($value)
 * @method static Builder|Dipt00l1 whereDtturn($value)
 * @method static Builder|Dipt00l1 whereEnteap($value)
 * @method static Builder|Dipt00l1 whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Dipt00l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Dipt00l1 extends BaseModel
{
    protected $table = 'dipt00l1';
}
