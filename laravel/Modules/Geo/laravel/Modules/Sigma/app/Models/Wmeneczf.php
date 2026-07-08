<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Wmeneczf.
 *
 * @property int $id
 * @property string|null $enteap
 * @property string|null $mematr
 * @property string|null $medata
 * @property string|null $meorat
 * @property string|null $mefla0
 * @property string|null $mefla1
 * @property string|null $mecaus
 * @property string|null $mecom1
 * @property string|null $mecom2
 *
 * @method static Builder|Wmeneczf newModelQuery()
 * @method static Builder|Wmeneczf newQuery()
 * @method static Builder|Wmeneczf query()
 * @method static Builder|Wmeneczf whereEnteap($value)
 * @method static Builder|Wmeneczf whereId($value)
 * @method static Builder|Wmeneczf whereMecaus($value)
 * @method static Builder|Wmeneczf whereMecom1($value)
 * @method static Builder|Wmeneczf whereMecom2($value)
 * @method static Builder|Wmeneczf whereMedata($value)
 * @method static Builder|Wmeneczf whereMefla0($value)
 * @method static Builder|Wmeneczf whereMefla1($value)
 * @method static Builder|Wmeneczf whereMematr($value)
 * @method static Builder|Wmeneczf whereMeorat($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\WmeneczfFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Wmeneczf extends BaseModel
{
    protected $table = 'wmeneczf';
}
