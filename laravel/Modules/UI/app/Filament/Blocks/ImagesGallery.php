<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;

final class ImagesGallery
{
    public static function make(string $name = 'images_gallery', string $context = 'form'): Block
    {
        return Block::make($name)
            ->schema([
                Repeater::make('gallery')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            // ->image()
                            // ->maxSize(5000)
                            ->multiple()
                            ->enableReordering()
                            ->openable()
                            ->downloadable()
                            ->columnSpanFull()
                            // ->collection('avatars')
                            // ->conversion('thumbnail')
                            ->disk('uploads')
                            ->directory('photos'),
                        TextInput::make('title')->columnSpanFull(),
                        TextInput::make('subtitle')->columnSpanFull(),
                        Select::make('version')
                            ->required()
                            ->options([
                                'v1' => 'versione 1',
                                'v2' => 'versione 2',
                            ]),
                    ])
                    ->columnSpanFull(),
                // FileUpload::make('image')
                //     ,
                // SpatieMediaLibraryFileUpload::make('image')
                //         // ->image()
                //         // ->maxSize(5000)
                //     ->multiple()
                //     ->enableReordering()
                //     ->openable()
                //     ->downloadable()
                //     ->columnSpanFull()
                //         // ->collection('avatars')
                //         // ->conversion('thumbnail')
                //     ->disk('uploads')
                //     ->directory('photos'),
                // TextInput::make('url')
                //     ,
                // Select::make('ratio')
                //     ->options(static::getRatios())
                //     ->afterStateHydrated(static fn ($state, $set) => $state || $set('ratio', '4-3')),
                // TextInput::make('alt')
                //     ->columnSpanFull(),
                // TextInput::make('caption')
                //     ->columnSpanFull(),
            ])
            ->columns('form' === $context ? 2 : 1);
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
