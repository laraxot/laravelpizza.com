<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Filament\Schemas\Components\Component;
use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

final class TestWidget extends XotBaseSchemaWidget
{
    protected ?string $heading = 'Test Widget';

    /**
     * @return array<string, Component>
     */
    public function getFormSchema(): array
    {
        return [];
    }
}
