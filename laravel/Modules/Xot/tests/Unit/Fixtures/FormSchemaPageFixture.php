<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Fixtures;

use Filament\Forms\Components\TextInput;
use Modules\Xot\Filament\Pages\XotBasePage;

final class FormSchemaPageFixture extends XotBasePage
{
    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document';

    protected string $view = 'xot::filament.pages.base';

    /** @return array<int|string, TextInput> */
    public function getFormSchema(): array
    {
        return [
            'legacy_field' => TextInput::make('legacy_field'),
        ];
    }
}
