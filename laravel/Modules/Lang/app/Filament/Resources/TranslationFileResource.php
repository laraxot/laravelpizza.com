<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources;

use Illuminate\Support\Facades\Config;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\CreateTranslationFile;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\EditTranslationFile;
use Modules\Lang\Filament\Resources\TranslationFileResource\Pages\ListTranslationFiles;
use Modules\Lang\Models\TranslationFile;
use Modules\Xot\Filament\Resources\XotBaseResource;

class TranslationFileResource extends XotBaseResource
{
    protected static ?string $model = TranslationFile::class;

    public static function getDefaultTranslatableLocale(): string
    {
        return Config::string('app.locale', 'it');
    }

    public static function getTranslatableLocales(): array
    {
        return ['it', 'en'];
    }

    #[\Override]
    public static function getFormSchema(): array
    {
        return [];

        /*
         * return [
         * Components\TextInput::make('key')
         * ->required()
         * ->maxLength(255)
         * ->disabled()
         * ->label('Chiave File'),
         *
         * Components\TextInput::make('name')
         * ->required()
         * ->maxLength(255)
         * ->disabled()
         * ->label('Nome File'),
         *
         * Components\TextInput::make('path')
         * ->required()
         * ->maxLength(255)
         * ->disabled()
         * ->label('Percorso File'),
         *
         * Components\KeyValue::make('content')
         * ->label('Traduzioni')
         * ->keyLabel('Chiave')
         * ->valueLabel('Valore')
         * ->addActionLabel('Aggiungi Traduzione')
         * ->deleteActionLabel('Rimuovi')
         * ->reorderable()
         * ->columnSpanFull(),
         *
         * ];
         */
    }

    #[\Override]
    public static function getPages(): array
    {
        return [
            'index' => ListTranslationFiles::route('/'),
            'create' => CreateTranslationFile::route('/create'),
            // 'view' => Pages\ViewTranslationFile::route('/{record}'),
            'edit' => EditTranslationFile::route('/{record}/edit'),
        ];
    }
}
