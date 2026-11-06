<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

final class ListLogActivitiesNestedFormPage extends ListLogActivitiesPageHarness
{
    public static function getResource(): string
    {
        return ListLogActivitiesNestedFormResource::class;
    }
}
