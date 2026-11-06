<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

final class ListLogActivitiesStdClassResourceHarness extends ListLogActivitiesPageHarness
{
    public static function getResource(): string
    {
        return \stdClass::class;
    }
}
