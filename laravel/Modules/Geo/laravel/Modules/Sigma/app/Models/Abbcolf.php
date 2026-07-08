<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Abbcolf.
 *
 * @property int $id
 * @property int $ente
 * @property int $emeen1
 * @property string $emeli1
 * @property int $emeen2
 * @property string $emeli2
 * @property int $emeen3
 * @property string $emeli3
 * @property int $emeen4
 * @property string $emeli4
 * @property int $emeen5
 * @property string $emeli5
 * @property int $emeen6
 * @property string $emeli6
 *
 * @method static Builder|Abbcolf newModelQuery()
 * @method static Builder|Abbcolf newQuery()
 * @method static Builder|Abbcolf query()
 * @method static Builder|Abbcolf whereEmeen1($value)
 * @method static Builder|Abbcolf whereEmeen2($value)
 * @method static Builder|Abbcolf whereEmeen3($value)
 * @method static Builder|Abbcolf whereEmeen4($value)
 * @method static Builder|Abbcolf whereEmeen5($value)
 * @method static Builder|Abbcolf whereEmeen6($value)
 * @method static Builder|Abbcolf whereEmeli1($value)
 * @method static Builder|Abbcolf whereEmeli2($value)
 * @method static Builder|Abbcolf whereEmeli3($value)
 * @method static Builder|Abbcolf whereEmeli4($value)
 * @method static Builder|Abbcolf whereEmeli5($value)
 * @method static Builder|Abbcolf whereEmeli6($value)
 * @method static Builder|Abbcolf whereEnte($value)
 * @method static Builder|Abbcolf whereId($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\AbbcolfFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Abbcolf extends BaseModel
{
    protected $table = 'abbcolf';
}
