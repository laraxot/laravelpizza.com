<?php

declare(strict_types=1);

namespace Modules\UI\Filament\Blocks;

use Filament\Forms\Components\Builder\Block;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Utilities\Set;

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
                    ->afterStateHydrated(static function (?string $state, Set $set): void {
                        if (! $state) {
                            $set('ratio', '4-3');
                        }
                    }),
                TextInput::make('alt')->columnSpanFull(),
                TextInput::make('caption')->columnSpanFull(),
            ])
            ->columns($context === 'form' ? 2 : 1);
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

    /**
     * @return array<int, Component>
     */
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
