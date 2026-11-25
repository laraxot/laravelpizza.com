<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Fixtures\Stubs;

use Modules\Xot\Filament\Widgets\XotBaseWidget;
use Modules\Xot\Models\Cache as CacheModel;

final class XotWidgetFormHost extends XotBaseWidget
{
    protected string $view = 'xot::filament.widgets.base';

    public function getFormSchema(): array
    {
        return [];
    }

    public function getFormModel(): string
    {
        return CacheModel::class;
    }
}
