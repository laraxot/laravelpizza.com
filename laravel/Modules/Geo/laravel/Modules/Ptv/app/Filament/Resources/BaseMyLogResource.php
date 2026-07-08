<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\PageRegistration;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Support\Components\Component;
use Illuminate\Database\Eloquent\Builder;
use Modules\Ptv\Filament\Resources\MyLogResource\Pages\ListMyLogs;
use Modules\Ptv\Filament\Resources\MyLogResource\Pages\ViewMyLog;
use Modules\Ptv\Models\MyLog;
use Modules\Xot\Filament\Resources\XotBaseResource;

abstract class BaseMyLogResource extends XotBaseResource
{
    protected static ?string $model = MyLog::class;

    protected static ?int $navigationSort = 99;

    /**
     * @return array<int, Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Section::make('Dettagli Log')
                ->columnSpanFull()
                ->schema([
                    Grid::make(2)
                        ->schema([
                            TextInput::make('id_tbl')
                                ->numeric()
                                ->disabled(),
                            TextInput::make('tbl')
                                ->maxLength(255)
                                ->disabled(),
                        ]),
                    Grid::make(2)
                        ->schema([
                            TextInput::make('obj')
                                ->maxLength(255)
                                ->disabled(),
                            TextInput::make('act')
                                ->maxLength(255)
                                ->disabled(),
                        ]),
                    Textarea::make('note')
                        ->rows(3)
                        ->columnSpanFull(),
                    KeyValue::make('data')
                        ->columnSpanFull(),
                    Grid::make(2)
                        ->schema([
                            TextInput::make('created_by')
                                ->maxLength(255)
                                ->disabled(),
                            TextInput::make('created_at')
                                ->disabled(),
                        ]),
                ]),
        ];
    }

    /**
     * @return array<string, PageRegistration>
     */
    public static function getPages(): array
    {
        return [
            'index' => ListMyLogs::route('/'),
            'view' => ViewMyLog::route('/{record}'),
        ];
    }

    /**
     * @return Builder<MyLog>
     */
    public static function getEloquentQuery(): Builder
    {
        /** @var Builder<MyLog> $query */
        $query = parent::getEloquentQuery();

        return $query->orderBy('created_at', 'desc');
    }
}
