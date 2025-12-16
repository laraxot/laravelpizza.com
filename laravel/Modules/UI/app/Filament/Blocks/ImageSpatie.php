<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Spatie\MediaLibrary\HasMedia;
use Webmozart\Assert\Assert;

final class ImageSpatie
{
    public static function make(string $name = 'image_spatie', string $context = 'form'): Block
    {
        return Block::make($name)
            ->schema([
                Hidden::make('img_uuid')
                    ->default(Str::uuid()->toString(...))
                    ->formatStateUsing(fn ($state) => $state ?? Str::uuid()->toString()),
                // ->live()
                SpatieMediaLibraryFileUpload::make('image')
                    ->live()
                    ->hiddenLabel()
                    ->imagePreviewHeight('666')
                    // ->panelLayout('integrated')
                    // ->imageResizeMode('cover')
                    // ->panelAspectRatio('2:1')
                    ->maxSize(102400)
                    ->disk('local')
                    ->image()
                    ->preserveFilenames()
                    ->openable()
                    ->downloadable()
                    // ->rules(Rule::dimensions()->maxWidth(600)->maxHeight(800))
                    ->collection(fn (Get $get) => $get('img_uuid'))
                    ->afterStateUpdated(function (
                        HasForms $_livewire,
                        SpatieMediaLibraryFileUpload $_component,
                        TemporaryUploadedFile $state,
                        Get $get,
                        HasMedia $record,
                    ): void {
                        // Call to an undefined method Filament\Forms\Contracts\HasForms::validateOnly().
                        // $livewire->validateOnly($component->getStatePath());
                        Assert::string(
                            $collection_name = $get('img_uuid'),
                            '['.__LINE__.']['.class_basename(self::class).']',
                        );
                        $res = $record->addMedia($state)->withResponsiveImages()->toMediaCollection($collection_name);
                    }),
                TextInput::make('caption'),
            ])
            ->columns('form' === $context ? 2 : 1);
    }
}
