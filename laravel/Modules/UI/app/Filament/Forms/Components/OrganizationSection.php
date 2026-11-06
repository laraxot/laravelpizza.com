<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Forms\Components;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Modules\Xot\Filament\Schemas\Components\XotBaseSection;

/** Reusable editor for the common schema.org/Organization properties. */
final class OrganizationSection extends XotBaseSection
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            Grid::make(2)->schema([
                TextInput::make('name')->required(),
                TextInput::make('legal_name'),
                TextInput::make('url')->url(),
                TextInput::make('email')->email(),
                TextInput::make('telephone')->tel(),
                TextInput::make('logo')->url(),
            ]),
        ]);
    }

    public static function getDefaultName(): string
    {
        return 'organization';
    }
}
