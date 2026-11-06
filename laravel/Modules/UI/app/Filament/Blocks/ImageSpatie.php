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
                    ->formatStateUsing(static fn (?string $state): string => $state ?? Str::uuid()->toString()),
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
                    ->collection(static fn (Get $get) => $get('img_uuid'))
                    ->afterStateUpdated(static function (
                        HasForms $_livewire,
                        SpatieMediaLibraryFileUpload $_component,
                        TemporaryUploadedFile $state,
                        Get $get,
                        HasMedia $record,
                    ): void {
                        // Call to an undefined method Filament\Forms\Contracts\HasForms::validateOnly().
                        // $livewire->validateOnly($component->getStatePath());
                        Assert::string(
                            $collectionName = $get('img_uuid'),
                            '['.__LINE__.']['.class_basename(self::class).']',
                        );
                        $record->addMedia($state)->withResponsiveImages()->toMediaCollection($collectionName);
                    }),
                TextInput::make('caption'),
            ])
            ->columns($context === 'form' ? 2 : 1);
    }
}
