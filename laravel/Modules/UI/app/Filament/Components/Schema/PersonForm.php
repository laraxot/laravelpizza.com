<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Components\Schema;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Modules\UI\Contracts\SchemaComponentContract;

/**
 * schema.org Person - reusable Filament form component
 * Properties: name, email, telephone, address, jobTitle, worksFor, knowsAbout, image, description
 */
final class PersonForm implements SchemaComponentContract
{
    public static function type(): string
    {
        return 'Person';
    }

    public static function make(?string $prefix = null): array
    {
        $p = $prefix ? $prefix.'.' : '';

        return [
            Section::make('Person')
                ->schema([
                    Grid::make(2)->schema([
                        TextInput::make($p.'name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(100)
                            ->helperText('schema.org: name'),
                        TextInput::make($p.'email')
                            ->label('Email')
                            ->email()
                            ->maxLength(150)
                            ->helperText('schema.org: email'),
                    ]),
                    Grid::make(2)->schema([
                        TextInput::make($p.'telephone')
                            ->label('Phone')
                            ->tel()
                            ->maxLength(30)
                            ->helperText('schema.org: telephone'),
                        TextInput::make($p.'jobTitle')
                            ->label('Job Title')
                            ->maxLength(100)
                            ->helperText('schema.org: jobTitle'),
                    ]),
                    Textarea::make($p.'address')
                        ->label('Address')
                        ->rows(3)
                        ->helperText('schema.org: address'),
                    TextInput::make($p.'worksFor')
                        ->label('Organization')
                        ->maxLength(100)
                        ->helperText('schema.org: worksFor (Organization name or @id)'),
                    TagsInput::make($p.'knowsAbout')
                        ->label('Knows About')
                        ->helperText('schema.org: knowsAbout (skills, topics)'),
                    Hidden::make('component_type')->default('Person'),
                    FileUpload::make($p.'image')
                        ->label('Profile Image')
                        ->image()
                        ->directory('schema/person')
                        ->helperText('schema.org: image'),
                    Textarea::make($p.'description')
                        ->label('Bio / Description')
                        ->rows(4)
                        ->helperText('schema.org: description'),
                ]),
        ];
    }
}
