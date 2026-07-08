<?php

declare(strict_types=1);

namespace Modules\Sigma\Models;

use Illuminate\Database\Eloquent\Builder;

// ----------traits ---
/**
 * Modules\Sigma\Models\Codici.
 *
 * @property int $id
 * @property int $tipo
 * @property int $codice
 * @property string $desc1
 *
 * @method static Builder|Codici newModelQuery()
 * @method static Builder|Codici newQuery()
 * @method static Builder|Codici query()
 * @method static Builder|Codici whereCodice($value)
 * @method static Builder|Codici whereDesc1($value)
 * @method static Builder|Codici whereId($value)
 * @method static Builder|Codici whereTipo($value)
 *
 * @mixin \Eloquent
 */
class Codici extends BaseModel
{
    protected $fillable = ['id', 'tipo', 'codice', 'desc1'];

    protected $connection = 'generale';

    // this will use the specified database connection
    protected $table = 'codici';

    public $timestamps = false;
}
