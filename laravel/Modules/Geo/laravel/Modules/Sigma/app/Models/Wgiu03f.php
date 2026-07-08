<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Date;

// ----------traits ---
/**
 * Modules\Sigma\Models\Wgiu03f.
 *
 * @property int $id
 * @property string $g3annu
 * @property int $enteap
 * @property mixed $stdata
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
 * @property-read Codici|null $codici
 *
 * @method static Builder|Wgiu03f newModelQuery()
 * @method static Builder|Wgiu03f newQuery()
 * @method static Builder|Wgiu03f query()
 * @method static Builder|Wgiu03f whereEnteap($value)
 * @method static Builder|Wgiu03f whereG3annu($value)
 * @method static Builder|Wgiu03f whereG3com1($value)
 * @method static Builder|Wgiu03f whereG3com2($value)
 * @method static Builder|Wgiu03f whereG3com3($value)
 * @method static Builder|Wgiu03f whereG3com4($value)
 * @method static Builder|Wgiu03f whereG3com5($value)
 * @method static Builder|Wgiu03f whereG3com6($value)
 * @method static Builder|Wgiu03f whereG3com7($value)
 * @method static Builder|Wgiu03f whereG3flg1($value)
 * @method static Builder|Wgiu03f whereG3flgs($value)
 * @method static Builder|Wgiu03f whereG3impe($value)
 * @method static Builder|Wgiu03f whereG3matr($value)
 * @method static Builder|Wgiu03f whereG3oraa($value)
 * @method static Builder|Wgiu03f whereG3orad($value)
 * @method static Builder|Wgiu03f whereG3qtaa($value)
 * @method static Builder|Wgiu03f whereG3qtar($value)
 * @method static Builder|Wgiu03f whereG3qtav($value)
 * @method static Builder|Wgiu03f whereG3umis($value)
 * @method static Builder|Wgiu03f whereG3unmi($value)
 * @method static Builder|Wgiu03f whereId($value)
 * @method static Builder|Wgiu03f whereLecod1($value)
 * @method static Builder|Wgiu03f whereLecod2($value)
 * @method static Builder|Wgiu03f whereStdata($value)
 *
 * @mixin \Eloquent
 */
class Wgiu03f extends BaseModel
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
    protected $table = 'wgiu03f';

    public $timestamps = false;

    /**
     * @return array<string, mixed>
     */
    public function casts(): array
    {
        return [
            'stdata' => 'datetime',
        ];
    }

    // ------------- RELATIONSHIPS ------------------
    /**
     * @return HasOne<Codici, $this>
     */
    public function codici(): HasOne
    {
        return $this->hasOne(Codici::class, 'tipo', 'lecod1')->where('codice', $this->lecod2);
    }

    // ------- Mutators --------
    /**
     * Undocumented function.
     *
     *
     * @return Carbon|mixed
     */
    protected function getStdataAttribute(mixed $value): mixed
    {
        if (\is_string($value)) {
            return Date::parse($value);
        }

        return $value;
    }
}
