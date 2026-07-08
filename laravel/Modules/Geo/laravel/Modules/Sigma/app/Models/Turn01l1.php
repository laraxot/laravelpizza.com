<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Turn01l1.
 *
 * @property int $id
 * @property string $t1annu
 * @property int $enteap
 * @property string $t1codi
 * @property int $t1dal
 * @property int $t1al
 * @property int $t1stor
 * @property string $t1desc
 * @property int $t1modu
 * @property string $t1fest
 * @property string $t1manu
 * @property int $t1orar
 * @property int $t1turn
 * @property int $t1sogl
 * @property int $t1sogd
 * @property string $t1chiu
 * @property string $t1moda
 * @property string $t1modp
 * @property string $t1quad
 * @property string $t1pers
 * @property string $t1svil
 * @property string $t1teef
 * @property string $t1aste
 * @property string $t1gipe
 * @property string $t1corr
 * @property string $t1rife
 * @property string $t1rico
 * @property string $t1cofe
 * @property string $t1ripp
 * @property string $t1com1
 * @property string $t1com2
 * @property string $t1com3
 * @property int $t1com4
 * @property int $t1com5
 * @property int $t1com6
 * @property int $t1com7
 *
 * @method static Builder|Turn01l1 newModelQuery()
 * @method static Builder|Turn01l1 newQuery()
 * @method static Builder|Turn01l1 query()
 * @method static Builder|Turn01l1 whereEnteap($value)
 * @method static Builder|Turn01l1 whereId($value)
 * @method static Builder|Turn01l1 whereT1al($value)
 * @method static Builder|Turn01l1 whereT1annu($value)
 * @method static Builder|Turn01l1 whereT1aste($value)
 * @method static Builder|Turn01l1 whereT1chiu($value)
 * @method static Builder|Turn01l1 whereT1codi($value)
 * @method static Builder|Turn01l1 whereT1cofe($value)
 * @method static Builder|Turn01l1 whereT1com1($value)
 * @method static Builder|Turn01l1 whereT1com2($value)
 * @method static Builder|Turn01l1 whereT1com3($value)
 * @method static Builder|Turn01l1 whereT1com4($value)
 * @method static Builder|Turn01l1 whereT1com5($value)
 * @method static Builder|Turn01l1 whereT1com6($value)
 * @method static Builder|Turn01l1 whereT1com7($value)
 * @method static Builder|Turn01l1 whereT1corr($value)
 * @method static Builder|Turn01l1 whereT1dal($value)
 * @method static Builder|Turn01l1 whereT1desc($value)
 * @method static Builder|Turn01l1 whereT1fest($value)
 * @method static Builder|Turn01l1 whereT1gipe($value)
 * @method static Builder|Turn01l1 whereT1manu($value)
 * @method static Builder|Turn01l1 whereT1moda($value)
 * @method static Builder|Turn01l1 whereT1modp($value)
 * @method static Builder|Turn01l1 whereT1modu($value)
 * @method static Builder|Turn01l1 whereT1orar($value)
 * @method static Builder|Turn01l1 whereT1pers($value)
 * @method static Builder|Turn01l1 whereT1quad($value)
 * @method static Builder|Turn01l1 whereT1rico($value)
 * @method static Builder|Turn01l1 whereT1rife($value)
 * @method static Builder|Turn01l1 whereT1ripp($value)
 * @method static Builder|Turn01l1 whereT1sogd($value)
 * @method static Builder|Turn01l1 whereT1sogl($value)
 * @method static Builder|Turn01l1 whereT1stor($value)
 * @method static Builder|Turn01l1 whereT1svil($value)
 * @method static Builder|Turn01l1 whereT1teef($value)
 * @method static Builder|Turn01l1 whereT1turn($value)
 *
 * @mixin \Eloquent
 */
class Turn01l1 extends BaseModel
{
    protected $fillable = [
        'id',
        't1annu',
        'enteap',
        't1codi',
        't1dal',
        't1al',
        't1stor',
        't1desc',
        't1modu',
        't1fest',
        't1manu',
        't1orar',
        't1turn',
        't1sogl',
        't1sogd',
        't1chiu',
        't1moda',
        't1modp',
        't1quad',
        't1pers',
        't1svil',
        't1teef',
        't1aste',
        't1gipe',
        't1corr',
        't1rife',
        't1rico',
        't1cofe',
        't1ripp',
        't1com1',
        't1com2',
        't1com3',
        't1com4',
        't1com5',
        't1com6',
        't1com7',
    ];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'turn01l1';

    public $timestamps = false;
}
