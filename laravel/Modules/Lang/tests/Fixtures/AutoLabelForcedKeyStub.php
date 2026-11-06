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

final class AutoLabelForcedKeyStub extends AutoLabelAction
{
    /**
     * @return array<string, mixed>
     */
    protected function findCallerFrame(Field|Entry|BaseFilter|Column|Step|Action|Section $component): array
    {
        return ['class' => self::class];
    }
}
