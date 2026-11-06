<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Widgets\Fixtures;

use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

/**
 * Stub per test calendar widget (BaseCalendarWidget non presente in Filament v4).
 */
abstract class BaseCalendarWidgetStub extends XotBaseSchemaWidget
{
    /**
     * @param  array<string, mixed>  $fetchInfo
     * @return array<int, array<string, mixed>>
     */
    abstract public function fetchEvents(array $fetchInfo): array;

    /**
     * @return array<int, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }
}
