<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Asz03f.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $as3con
 * @property string|null $as3nom
 * @property string|null $as3tip
 * @property string|null $as3cod
 * @property string|null $as3dal
 * @property string|null $as3al
 * @property string|null $as3qtv
 * @property string|null $as3umi
 * @property string|null $as3ri1
 * @property string|null $as3ri2
 * @property string|null $as3ri3
 * @property string|null $as3ri4
 * @property string|null $as3ri5
 * @property string|null $as3ri6
 * @property string|null $as3tim
 * @property string|null $as3pro
 * @property string|null $as3001
 * @property string|null $as3002
 * @property string|null $as3003
 * @property string|null $as3004
 * @property string|null $as3005
 * @property string|null $as3ann
 *
 * @method static Builder|Asz03f newModelQuery()
 * @method static Builder|Asz03f newQuery()
 * @method static Builder|Asz03f query()
 * @method static Builder|Asz03f whereAs3001($value)
 * @method static Builder|Asz03f whereAs3002($value)
 * @method static Builder|Asz03f whereAs3003($value)
 * @method static Builder|Asz03f whereAs3004($value)
 * @method static Builder|Asz03f whereAs3005($value)
 * @method static Builder|Asz03f whereAs3al($value)
 * @method static Builder|Asz03f whereAs3ann($value)
 * @method static Builder|Asz03f whereAs3cod($value)
 * @method static Builder|Asz03f whereAs3con($value)
 * @method static Builder|Asz03f whereAs3dal($value)
 * @method static Builder|Asz03f whereAs3nom($value)
 * @method static Builder|Asz03f whereAs3pro($value)
 * @method static Builder|Asz03f whereAs3qtv($value)
 * @method static Builder|Asz03f whereAs3ri1($value)
 * @method static Builder|Asz03f whereAs3ri2($value)
 * @method static Builder|Asz03f whereAs3ri3($value)
 * @method static Builder|Asz03f whereAs3ri4($value)
 * @method static Builder|Asz03f whereAs3ri5($value)
 * @method static Builder|Asz03f whereAs3ri6($value)
 * @method static Builder|Asz03f whereAs3tim($value)
 * @method static Builder|Asz03f whereAs3tip($value)
 * @method static Builder|Asz03f whereAs3umi($value)
 * @method static Builder|Asz03f whereEnte($value)
 * @method static Builder|Asz03f whereId($value)
 * @method static Builder|Asz03f whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Asz03fFactory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Asz03f extends BaseModel
{
    protected $table = 'asz03f';
}
