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

final class VideoSpatie
{
    public static function make(string $name = 'video_spatie', string $context = 'form'): Block
    {
        return Block::make($name)
            ->schema([
                Hidden::make('img_uuid')
                    ->default(Str::uuid()->toString(...))
                    ->formatStateUsing(fn ($state) => $state ?? Str::uuid()->toString())
                    ->live(),
                // ->required(),

                SpatieMediaLibraryFileUpload::make('video')
                    ->live()
                    ->hiddenLabel()
                    // ->imagePreviewHeight('250')
                    // ->panelLayout('integrated')
                    ->imageResizeMode('cover')
                    ->panelAspectRatio('2:1')
                    ->maxSize(502400)
                    ->disk('local')
                    ->preserveFilenames()
                    ->openable()
                    ->previewable()
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
                        $record->addMedia($state)->withResponsiveImages()->toMediaCollection($collection_name);
                    }),
                /*
                 * Select::make('ratio')
                 * ->options(static::getRatios())
                 * ->afterStateHydrated(static fn ($state, $set) => $state || $set('ratio', '4-3')),
                 *
                 * TextInput::make('alt')
                 * ->columnSpanFull(),
                 */
                TextInput::make('caption'),
                // ->columnSpanFull()
                // Filament\Forms\Components\SpatieMediaLibraryFileUpload::whereCustomProperties does not exist.
                // ->whereCustomProperties(fn(Forms\Get $get) => ['gallery_id' => $get('gallery_id')])
                // ->customProperties(fn(Forms\Get $get) => ['gallery_id' => $get('gallery_id')]),
                // Forms\Components\SpatieMediaLibraryFileUpload::make('media_id')
            ])
            ->columns($context === 'form' ? 2 : 1);
    }

    public static function getRatios(): array
    {
        return [
            '4-3' => '4/3',
            '3-4' => '3/4',
            'free' => 'free',
        ];
    }

    public static function getRatioClass(string $ratio): string
    {
        return match ($ratio) {
            '4-3' => 'aspect-[4/3]',
            '3-4' => 'aspect-[3/4]',
            default => '',
        };
    }
}
