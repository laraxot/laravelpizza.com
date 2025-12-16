<?php

declare(strict_types=1);

namespace Modules\Media\Filament\Resources;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Schemas\Components\Component;
use Modules\Media\Filament\Resources\MediaResource\Pages\ConvertMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\CreateMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\EditMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\ListMedia;
use Modules\Media\Filament\Resources\MediaResource\Pages\ViewMedia;
use Modules\Media\Models\Media;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class MediaResource extends XotBaseResource
{
    protected static ?string $model = Media::class;

    /**
     * @return array<string, Component>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        return [
            'file' => FileUpload::make('file')
                ->hint(static::trans('fields.file_hint'))
                ->storeFileNamesIn('original_file_name')
                ->visibility('private')
                ->required()
                ->columnSpanFull(),
            'attachment_type' => Radio::make('attachment_type'),
            'name' => TextInput::make('name')
                ->translateLabel()
                ->hint(static::trans('fields.name.hint'))
                ->autocomplete(false)
                ->maxLength(255)
                ->columnSpanFull(),
        ];
    }

    /**
     * @psalm-return array<never, never>
     */
    #[Override]
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * @return array<PageRegistration>
     *
     * @psalm-return array{index: PageRegistration, create: PageRegistration, edit: PageRegistration}
     */
    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMedia::route('/'),
            'create' => CreateMedia::route('/create'),
            'edit' => EditMedia::route('/{record}/edit'),
            'view' => ViewMedia::route('/{record}'),
            'convert' => ConvertMedia::route('/{record}/convert'),
        ];
    }
}
