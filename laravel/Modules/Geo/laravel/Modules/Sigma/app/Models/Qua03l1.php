<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Qua03l1.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $q3tipo
 * @property string|null $q3dal
 * @property string|null $q3al
 * @property string|null $q3desc
 * @property string|null $q3cont
 * @property string|null $q3pro
 * @property string|null $q3fun
 * @property string|null $q3voc1
 * @property string|null $q3anz1
 * @property string|null $q3imp1
 * @property string|null $q3voc2
 * @property string|null $q3anz2
 * @property string|null $q3imp2
 * @property string|null $q3voc3
 * @property string|null $q3anz3
 * @property string|null $q3imp3
 * @property string|null $q3voc4
 * @property string|null $q3anz4
 * @property string|null $q3imp4
 * @property string|null $q3voc5
 * @property string|null $q3anz5
 * @property string|null $q3imp5
 * @property string|null $q3tip
 * @property string|null $q3dat
 * @property string|null $q3num
 * @property string|null $q3ann
 *
 * @method static Builder|Qua03l1 newModelQuery()
 * @method static Builder|Qua03l1 newQuery()
 * @method static Builder|Qua03l1 query()
 * @method static Builder|Qua03l1 whereEnte($value)
 * @method static Builder|Qua03l1 whereId($value)
 * @method static Builder|Qua03l1 whereMatr($value)
 * @method static Builder|Qua03l1 whereQ3al($value)
 * @method static Builder|Qua03l1 whereQ3ann($value)
 * @method static Builder|Qua03l1 whereQ3anz1($value)
 * @method static Builder|Qua03l1 whereQ3anz2($value)
 * @method static Builder|Qua03l1 whereQ3anz3($value)
 * @method static Builder|Qua03l1 whereQ3anz4($value)
 * @method static Builder|Qua03l1 whereQ3anz5($value)
 * @method static Builder|Qua03l1 whereQ3cont($value)
 * @method static Builder|Qua03l1 whereQ3dal($value)
 * @method static Builder|Qua03l1 whereQ3dat($value)
 * @method static Builder|Qua03l1 whereQ3desc($value)
 * @method static Builder|Qua03l1 whereQ3fun($value)
 * @method static Builder|Qua03l1 whereQ3imp1($value)
 * @method static Builder|Qua03l1 whereQ3imp2($value)
 * @method static Builder|Qua03l1 whereQ3imp3($value)
 * @method static Builder|Qua03l1 whereQ3imp4($value)
 * @method static Builder|Qua03l1 whereQ3imp5($value)
 * @method static Builder|Qua03l1 whereQ3num($value)
 * @method static Builder|Qua03l1 whereQ3pro($value)
 * @method static Builder|Qua03l1 whereQ3tip($value)
 * @method static Builder|Qua03l1 whereQ3tipo($value)
 * @method static Builder|Qua03l1 whereQ3voc1($value)
 * @method static Builder|Qua03l1 whereQ3voc2($value)
 * @method static Builder|Qua03l1 whereQ3voc3($value)
 * @method static Builder|Qua03l1 whereQ3voc4($value)
 * @method static Builder|Qua03l1 whereQ3voc5($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Qua03l1Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Qua03l1 extends BaseModel
{
    protected $table = 'qua03l1';
}
