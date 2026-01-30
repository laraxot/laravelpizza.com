<?php

/**
 * ---.
 */

declare(strict_types=1);

namespace Modules\Chart\Models;

use Illuminate\Support\Carbon;
use Modules\Quaeris\Models\Profile;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Modules\Chart\Models\MixedChart.
 *
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $created_by
 * @property string|null $updated_by
 * @property-read Collection<int, Chart> $charts
 * @property-read int|null $charts_count
 * @property-read Profile|null $creator
 * @property-read Profile|null $updater
 *
 * @method static Builder<static>|MixedChart newModelQuery()
 * @method static Builder<static>|MixedChart newQuery()
 * @method static Builder<static>|MixedChart query()
 * @method static Builder<static>|MixedChart whereCreatedAt($value)
 * @method static Builder<static>|MixedChart whereCreatedBy($value)
 * @method static Builder<static>|MixedChart whereId($value)
 * @method static Builder<static>|MixedChart whereName($value)
 * @method static Builder<static>|MixedChart whereUpdatedAt($value)
 * @method static Builder<static>|MixedChart whereUpdatedBy($value)
 *
 * @mixin \Eloquent
 */
class MixedChart extends BaseModel
{
    /** @var list<string> */
    protected $fillable = [
        'id',
        'name',
    ];

    // ---- relations

    public function charts(): MorphMany
    {
        /**
         * @phpstan-ignore argument.type
         */
        Relation::morphMap([
            'question_chart' => 'Modules\Quaeris\Models\QuestionChart',
            'mixed_chart' => self::class,
        ]);

        return $this->morphMany(Chart::class, 'post');
    }
}
