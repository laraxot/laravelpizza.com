<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Catastp.
 *
 * @property int $id
 * @property string|null $des30
 * @property string|null $des24
 * @property string|null $prov
 * @property string|null $codcat
 * @property string|null $comcat
 *
 * @method static Builder|Catastp newModelQuery()
 * @method static Builder|Catastp newQuery()
 * @method static Builder|Catastp query()
 * @method static Builder|Catastp whereCodcat($value)
 * @method static Builder|Catastp whereComcat($value)
 * @method static Builder|Catastp whereDes24($value)
 * @method static Builder|Catastp whereDes30($value)
 * @method static Builder|Catastp whereId($value)
 * @method static Builder|Catastp whereProv($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\CatastpFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Catastp extends BaseModel
{
    protected $table = 'catastp';
}
