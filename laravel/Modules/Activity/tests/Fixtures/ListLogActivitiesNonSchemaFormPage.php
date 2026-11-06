<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

final class ListLogActivitiesNonSchemaFormPage extends ListLogActivitiesPageHarness
{
    public static function getResource(): string
    {
        return ListLogActivitiesNonSchemaFormResource::class;
    }
}
