<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseSchemaWidget;

final class GroupWidget extends XotBaseSchemaWidget
{
    protected static ?string $heading = 'Group Widget';

    /**
     * @return array<string, mixed>
     */
    public function getFormSchema(): array
    {
        return [];
    }
}
