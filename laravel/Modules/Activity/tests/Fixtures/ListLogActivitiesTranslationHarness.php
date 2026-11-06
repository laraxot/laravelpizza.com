<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Fixtures;

use Modules\Activity\Filament\Pages\ListLogActivities;
use Modules\Activity\Filament\Resources\ActivityResource;
use ReflectionMethod;
use Webmozart\Assert\Assert;

/**
 * Pagina ListLogActivities con risorsa ActivityResource che espone il metodo privato toTranslationString
 * (classe con nome, non anonima).
 */
final class ListLogActivitiesTranslationHarness extends ListLogActivities
{
    public static function getResource(): string
    {
        return ActivityResource::class;
    }

    /**
     * @param  list<string>|string|int  $value
     */
    public function exposeToTranslationString(string|array|int $value): string
    {
        $method = new ReflectionMethod(ListLogActivities::class, 'toTranslationString');
        $method->setAccessible(true);

        $result = $method->invoke($this, $value);
        Assert::string($result);

        return $result;
    }
}
