<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Models\Profile;

/**
 * Modules\Sigma\Models\Asz02l3.
 *
 * @property int $id
 * @property string|null $ente
 * @property string|null $matr
 * @property string|null $as2tip
 * @property string|null $as2cod
 * @property string|null $as2dat
 * @property string|null $as2an
 * @property string|null $as2me
 * @property string|null $as2gg
 * @property string|null $as2qta
 * @property string|null $as2qtv
 * @property string|null $as2umi
 * @property string|null $as2lir
 * @property string|null $as2ri1
 * @property string|null $as2ri2
 * @property string|null $as2ri3
 * @property string|null $as2ri4
 * @property string|null $as2ri5
 * @property string|null $as2tim
 * @property string|null $as2pro
 * @property string|null $as2001
 * @property string|null $as2002
 * @property string|null $as2003
 * @property string|null $as2004
 * @property string|null $as2005
 * @property string|null $as2ann
 *
 * @method static Builder|Asz02l3 newModelQuery()
 * @method static Builder|Asz02l3 newQuery()
 * @method static Builder|Asz02l3 query()
 * @method static Builder|Asz02l3 whereAs2001($value)
 * @method static Builder|Asz02l3 whereAs2002($value)
 * @method static Builder|Asz02l3 whereAs2003($value)
 * @method static Builder|Asz02l3 whereAs2004($value)
 * @method static Builder|Asz02l3 whereAs2005($value)
 * @method static Builder|Asz02l3 whereAs2an($value)
 * @method static Builder|Asz02l3 whereAs2ann($value)
 * @method static Builder|Asz02l3 whereAs2cod($value)
 * @method static Builder|Asz02l3 whereAs2dat($value)
 * @method static Builder|Asz02l3 whereAs2gg($value)
 * @method static Builder|Asz02l3 whereAs2lir($value)
 * @method static Builder|Asz02l3 whereAs2me($value)
 * @method static Builder|Asz02l3 whereAs2pro($value)
 * @method static Builder|Asz02l3 whereAs2qta($value)
 * @method static Builder|Asz02l3 whereAs2qtv($value)
 * @method static Builder|Asz02l3 whereAs2ri1($value)
 * @method static Builder|Asz02l3 whereAs2ri2($value)
 * @method static Builder|Asz02l3 whereAs2ri3($value)
 * @method static Builder|Asz02l3 whereAs2ri4($value)
 * @method static Builder|Asz02l3 whereAs2ri5($value)
 * @method static Builder|Asz02l3 whereAs2tim($value)
 * @method static Builder|Asz02l3 whereAs2tip($value)
 * @method static Builder|Asz02l3 whereAs2umi($value)
 * @method static Builder|Asz02l3 whereEnte($value)
 * @method static Builder|Asz02l3 whereId($value)
 * @method static Builder|Asz02l3 whereMatr($value)
 *
 * @property-read Profile|null $creator
 * @property-read Profile|null $deleter
 * @property-read Profile|null $updater
 *
 * @method static \Modules\Sigma\Database\Factories\Asz02l3Factory factory($count = null, $state = [])
 *
 * @mixin \Eloquent
 */
class Asz02l3 extends BaseModel
{
    protected $table = 'asz02l3';
}
