<?php

declare(strict_types=1);

namespace Modules\Performance\Models;

use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Modules\Ptv\Models\Profile;
use Modules\Xot\Traits\Updater;

/**
 * Modules\Performance\Models\IndividualeDecurtazioneAssenze.
 *
 * @property int $id
 * @property int|null $anno
 * @property Carbon|null $created_at
 * @property string|null $created_by
 * @property Carbon|null $updated_at
 * @property string|null $updated_by
 * @property float|null $min_perc
 * @property float|null $max_perc
 * @property float|null $min_gg_365
 * @property float|null $max_gg_365
 * @property float|null $decurtazione_perc
 * @method static Builder|IndividualeDecurtazioneAssenze newModelQuery()
 * @method static Builder|IndividualeDecurtazioneAssenze newQuery()
 * @method static Builder|IndividualeDecurtazioneAssenze query()
 * @method static Builder|IndividualeDecurtazioneAssenze whereAnno($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereCreatedAt($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereCreatedBy($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereDecurtazionePerc($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereId($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereMaxGg365($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereMaxPerc($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereMinGg365($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereMinPerc($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereUpdatedAt($value)
 * @method static Builder|IndividualeDecurtazioneAssenze whereUpdatedBy($value)
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 * @property-read Profile|null $deleter
 * @mixin \Eloquent
 */
class IndividualeDecurtazioneAssenze extends BaseModel
{
    protected $fillable = ['id', 'anno', 'min_perc', 'max_perc', 'min_gg_365', 'max_gg_365', 'decurtazione_perc'];

    protected $table = 'peso_assenze';

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
        // echo '<pre>';print_r($params);echo '</pre>';
        if (isset($anno)) {
            return $query->where('anno', $anno);
        }

        return $query;
    }

    // end search
    // -------------------------
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

    // end populate
    /*
ALTER TABLE `peso_assenze`
ADD COLUMN `created_at` TIMESTAMP NULL DEFAULT NULL AFTER `anno`,
ADD COLUMN `created_by` VARCHAR(50) NULL DEFAULT NULL AFTER `created_at`,
ADD COLUMN `updated_at` TIMESTAMP NULL DEFAULT NULL AFTER `created_by`,
ADD COLUMN `updated_by` VARCHAR(50) NULL DEFAULT NULL AFTER `updated_at`;
 */
}
