<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Widgets;

use Modules\Xot\Filament\Widgets\XotBaseWidget;

final class TestWidget extends XotBaseWidget
{
    protected ?string $heading = 'Test Widget';

    public function getFormSchema(): array
    {
        return [];
    }
}
