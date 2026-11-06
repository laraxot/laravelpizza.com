<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

/**
 * Subject senza metodo activities().
 */
final class ActivitySubjectNoActivitiesMethodHarness extends Model
{
    protected $table = 'activity_subject_no_method';

    public $timestamps = false;
}
