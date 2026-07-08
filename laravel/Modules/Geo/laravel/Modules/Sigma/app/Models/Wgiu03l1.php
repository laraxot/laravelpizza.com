<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Wgiu03l1.
 *
 * @property int $id
 * @property string $g3annu
 * @property int $enteap
 * @property int $stdata
 * @property int $g3matr
 * @property int $lecod1
 * @property int $lecod2
 * @property int $g3qtaa
 * @property string $g3qtav
 * @property string $g3orad
 * @property string $g3oraa
 * @property string $g3umis
 * @property int $g3qtar
 * @property string $g3flgs
 * @property string $g3flg1
 * @property string $g3com1
 * @property int $g3com2
 * @property int $g3com3
 * @property int $g3com4
 * @property int $g3com5
 * @property string $g3com6
 * @property int $g3com7
 * @property string $g3impe
 * @property string $g3unmi
 *
 * @method static Builder|Wgiu03l1 newModelQuery()
 * @method static Builder|Wgiu03l1 newQuery()
 * @method static Builder|Wgiu03l1 query()
 * @method static Builder|Wgiu03l1 whereEnteap($value)
 * @method static Builder|Wgiu03l1 whereG3annu($value)
 * @method static Builder|Wgiu03l1 whereG3com1($value)
 * @method static Builder|Wgiu03l1 whereG3com2($value)
 * @method static Builder|Wgiu03l1 whereG3com3($value)
 * @method static Builder|Wgiu03l1 whereG3com4($value)
 * @method static Builder|Wgiu03l1 whereG3com5($value)
 * @method static Builder|Wgiu03l1 whereG3com6($value)
 * @method static Builder|Wgiu03l1 whereG3com7($value)
 * @method static Builder|Wgiu03l1 whereG3flg1($value)
 * @method static Builder|Wgiu03l1 whereG3flgs($value)
 * @method static Builder|Wgiu03l1 whereG3impe($value)
 * @method static Builder|Wgiu03l1 whereG3matr($value)
 * @method static Builder|Wgiu03l1 whereG3oraa($value)
 * @method static Builder|Wgiu03l1 whereG3orad($value)
 * @method static Builder|Wgiu03l1 whereG3qtaa($value)
 * @method static Builder|Wgiu03l1 whereG3qtar($value)
 * @method static Builder|Wgiu03l1 whereG3qtav($value)
 * @method static Builder|Wgiu03l1 whereG3umis($value)
 * @method static Builder|Wgiu03l1 whereG3unmi($value)
 * @method static Builder|Wgiu03l1 whereId($value)
 * @method static Builder|Wgiu03l1 whereLecod1($value)
 * @method static Builder|Wgiu03l1 whereLecod2($value)
 * @method static Builder|Wgiu03l1 whereStdata($value)
 *
 * @mixin \Eloquent
 */
class Wgiu03l1 extends BaseModel
{
    protected $fillable = [
        'id',
        'g3annu',
        'enteap',
        'stdata',
        'g3matr',
        'lecod1',
        'lecod2',
        'g3qtaa',
        'g3qtav',
        'g3orad',
        'g3oraa',
        'g3umis',
        'g3qtar',
        'g3flgs',
        'g3flg1',
        'g3com1',
        'g3com2',
        'g3com3',
        'g3com4',
        'g3com5',
        'g3com6',
        'g3com7',
        'g3impe',
        'g3unmi',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'wgiu03l1';

    public $timestamps = false;
}
