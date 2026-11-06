<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Fixtures;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Infolists\Components\Entry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Tables\Columns\Column;
use Filament\Tables\Filters\BaseFilter;
use Modules\Lang\Actions\Filament\AutoLabelAction;

final class AutoLabelExecuteNestedCaller
{
    public function execute(Field|Entry|BaseFilter|Column|Step|Action|Section $component, string $type = 'label'): Field|Entry|BaseFilter|Column|Step|Action|Section
    {
        return app(AutoLabelAction::class)->execute($component, $type);
    }
}
