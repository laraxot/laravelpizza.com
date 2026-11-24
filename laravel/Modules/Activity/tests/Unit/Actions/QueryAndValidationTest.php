<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Actions;
<<<<<<< .merge_file_NrHKsA
=======

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Mockery;
use Modules\Activity\Actions\ActivityLogger as ActivityLoggerAction;
use Modules\Activity\Actions\LogActivityAction;
use Modules\Activity\Actions\Query\GetActivitiesByTypeAction;
use Modules\Activity\Actions\Query\GetRecentActivitiesAction;
use Modules\Activity\Actions\Query\GetSubjectActivityLogAction;
use Modules\Activity\Actions\Query\GetUserActivitiesAction;
use Modules\Activity\Actions\RecordSubjectActivityAction;
use Modules\Activity\Actions\RestoreActivityAction;
use Modules\Activity\Adapters\ActivityLogger as ActivityLoggerAdapter;
use Modules\Activity\Adapters\ActivityRecorder;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;
use Webmozart\Assert\InvalidArgumentException as AssertInvalidArgumentException;

<<<<<<< .merge_file_IJJF9N
<<<<<<< .merge_file_Hi14Xn
<<<<<<< .merge_file_xaqWlF
>>>>>>> .merge_file_wUlVxX
=======
>>>>>>> .merge_file_pEtZUf
=======
>>>>>>> .merge_file_iFnUgG
=======
>>>>>>> .merge_file_lbzmtD
