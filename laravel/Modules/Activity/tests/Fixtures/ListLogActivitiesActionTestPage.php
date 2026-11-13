<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Modules\Xot\Filament\Resources\Pages\XotBaseListRecords;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Webmozart\Assert\Assert;

final class ListLogActivitiesActionTestPage extends XotBaseListRecords
{
    private static string $resourceClass = ListLogActivitiesActionTestResource::class;

    /**
     * @param  class-string<XotBaseResource>  $resourceClass
     */
    public static function usingResource(string $resourceClass): self
    {
        Assert::subclassOf($resourceClass, XotBaseResource::class);

        self::$resourceClass = $resourceClass;

        return new self();
    }

    /**
     * @return class-string<XotBaseResource>
     */
    public static function getResource(): string
    {
        Assert::subclassOf(self::$resourceClass, XotBaseResource::class);

        return self::$resourceClass;
    }
}
