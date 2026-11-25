<?php

declare(strict_types=1);

namespace Modules\Xot\Models;

use Spatie\Activitylog\Models\Activity as SpatieActivity;

/**
 * Class BaseActivity.
 *
 * Base class for activities extending Spatie's Activity model.
 */
abstract class BaseActivity extends SpatieActivity
{
    /** @var string */
    protected $connection = 'activity';
}
