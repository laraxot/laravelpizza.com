<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

final class GroupWidget extends XotBaseWidget
{
    protected static ?string $heading = 'Group Widget';

    #[\Override]
    public function getFormSchema(): array
    {
        return [];
    }
}
