<?php

declare(strict_types=1);

namespace Modules\Lang\Filament\Resources;

use Illuminate\Support\Facades\Config;
use Modules\Lang\Actions\GetDefaultTranslatableLocaleAction;
use Modules\Lang\Actions\GetTranslatableLocalesAction;
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
        return app(GetDefaultTranslatableLocaleAction::class)->execute(Config::string('app.locale', 'it'));
    }

    /**
     * @return array<int, string>
     */
    public static function getTranslatableLocales(): array
    {
        return app(GetTranslatableLocalesAction::class)->execute();
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
