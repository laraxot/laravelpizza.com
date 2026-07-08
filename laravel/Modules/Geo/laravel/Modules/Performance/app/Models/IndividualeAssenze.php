<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\IndividualeAssenze.
 *
 * @property int $id
 * @property int|null $tipo
 * @property int|null $codice
 * @property string|null $descr
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property string|null $deleted_at
 * @property string|null $deleted_by
 * @method static Builder|IndividualeAssenze newModelQuery()
 * @method static Builder|IndividualeAssenze newQuery()
 * @method static Builder|IndividualeAssenze query()
 * @method static Builder|IndividualeAssenze whereAnno($value)
 * @method static Builder|IndividualeAssenze whereCodice($value)
 * @method static Builder|IndividualeAssenze whereCreatedAt($value)
 * @method static Builder|IndividualeAssenze whereCreatedBy($value)
 * @method static Builder|IndividualeAssenze whereDeletedAt($value)
 * @method static Builder|IndividualeAssenze whereDeletedBy($value)
 * @method static Builder|IndividualeAssenze whereDescr($value)
 * @method static Builder|IndividualeAssenze whereId($value)
 * @method static Builder|IndividualeAssenze whereTipo($value)
 * @method static Builder|IndividualeAssenze whereUpdatedAt($value)
 * @method static Builder|IndividualeAssenze whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class IndividualeAssenze extends BaseModel
{
    protected $fillable = ['id', 'tipo', 'codice', 'descr', 'anno'];

    protected $table = 'codici_assenze_individuale';

    // use Updater;
    // protected $connection = 'performance'; // this will use the specified database connection
    // public $timestamps= false;
    /*
    protected $dates = [
        'created_at',
        'updated_at',
    ];
    */

    /**
     * @param array<string, mixed> $params
     * @return Builder<static>
     */
    public static function filter(array $params): Builder
    {
        $query = static::query();
        extract($params);
        if (isset($anno)) {
            return $query->where('anno', $anno);
        }

        return $query;
    }

    // end search

    public static function populate(): void
    {
        $params = getRouteParameters();
        extract($params);
        if (! isset($anno)) {
            throw new Exception('anno is not defined ['.__LINE__.']['.class_basename(self::class).']');
        }

        $rows = self::where('anno', $anno)->get();
        if ($rows->count() === 0) {
            $rows = self::where('anno', (is_int($anno) ? $anno : (int) $anno) - 1)->get();
            foreach ($rows as $row) {
                $row_1 = $row->replicate();
                $row_1->anno = $row->anno + 1;
                $row_1->save();
            }
        }
    }

    // -----------------------------------------------
} // end class
