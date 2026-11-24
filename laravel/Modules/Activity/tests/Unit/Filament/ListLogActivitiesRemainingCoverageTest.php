<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Filament;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Activity\Actions\ActivityLogger as ActivityLoggerAction;
use Modules\Activity\Filament\Actions\ListLogActivitiesAction;
use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\Fixtures\ActivitySubjectHarness;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestPage;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestRecord;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesActionTestResourceSimple;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesBadPaginatorPage;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesMountablePage;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesNestedFormPage;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesNonSchemaFormPage;
use Modules\Activity\Tests\Fixtures\ListLogActivitiesPageHarness;
