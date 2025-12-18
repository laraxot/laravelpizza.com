<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class Image
{
    public static function make(string $name = 'image', string $context = 'form'): Block
    {
        return Block::make($name)
            ->schema([
                FileUpload::make('image'),
                TextInput::make('url'),
                Select::make('ratio')
                    ->options(static::getRatios())
                    ->afterStateHydrated(function (mixed $state, mixed $set) {
                        if (! $state && is_callable($set)) {
                            $set('ratio', '4-3');
                        }
                    }),
                TextInput::make('alt')->columnSpanFull(),
                TextInput::make('caption')->columnSpanFull(),
            ])
            ->columns('form' === $context ? 2 : 1);
    }

    /**
     * @return array<string, string>
     */
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

    public static function getFormSchema(): array
    {
        return [
            FileUpload::make('image')
                ->required()
                ->image()
                ->maxSize(5120),
            TextInput::make('url')->url()->maxLength(255),
        ];
    }
}
