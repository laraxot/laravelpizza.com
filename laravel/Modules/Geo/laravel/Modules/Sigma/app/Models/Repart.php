<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Repart.
 *
 * @property int $id
 * @property int $ente
 * @property int $stabi
 * @property int $repar
 * @property string $dest1
 * @property string $dest2
 *
 * @method static Builder|Repart newModelQuery()
 * @method static Builder|Repart newQuery()
 * @method static Builder|Repart query()
 * @method static Builder|Repart whereDest1($value)
 * @method static Builder|Repart whereDest2($value)
 * @method static Builder|Repart whereEnte($value)
 * @method static Builder|Repart whereId($value)
 * @method static Builder|Repart whereRepar($value)
 * @method static Builder|Repart whereStabi($value)
 *
 * @mixin \Eloquent
 */
class Repart extends BaseModel
{
    protected $fillable = ['id', 'ente', 'stabi', 'repar', 'dest1', 'dest2'];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'repart';

    public $timestamps = false;
}
