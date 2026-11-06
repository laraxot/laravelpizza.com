<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\Activity\Models\Activity;

/**
 * Subject con relazione activities() per ListLogActivities / query actions.
 */
class ActivitySubjectHarness extends Model
{
    protected $table = 'activity_subject_harness';

    public $timestamps = false;

    public $incrementing = false;

    protected $keyType = 'string';

    /** @var list<string> */
    protected $fillable = ['id', 'name'];

    /**
     * @return MorphMany<Activity, $this>
     */
    public function activities(): MorphMany
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}
