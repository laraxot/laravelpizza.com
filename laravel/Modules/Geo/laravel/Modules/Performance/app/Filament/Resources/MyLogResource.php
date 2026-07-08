<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Modules\Performance\Filament\Resources\MyLogResource\Pages\CreateMyLog;
use Modules\Performance\Filament\Resources\MyLogResource\Pages\EditMyLog;
use Modules\Performance\Filament\Resources\MyLogResource\Pages\ListMyLogs;
use Modules\Performance\Models\MyLog;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Override;

class MyLogResource extends XotBaseResource
{
    protected static ?string $model = MyLog::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public static function getFormSchema(): array
    {
        // Types are inferred by Filament v4
        return [
            'id_tbl' => TextInput::make('id_tbl')
                ->numeric(),
            'tbl' => TextInput::make('tbl')
                ->maxLength(50),
            'id_approvaz' => TextInput::make('id_approvaz')
                ->numeric(),
            'note' => Textarea::make('note')
                ->columnSpanFull(),
            'data' => Textarea::make('data')
                ->columnSpanFull(),
            'datemod' => DateTimePicker::make('datemod'),
            'handle' => TextInput::make('handle')
                ->maxLength(150),
            'created_by' => TextInput::make('created_by')
                ->maxLength(255),
            'updated_by' => TextInput::make('updated_by')
                ->maxLength(255),

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableColumns(): array
    {
        return [
            'id_tbl' => TextColumn::make('id_tbl')
                ->numeric()
                ->sortable(),
            'tbl' => TextColumn::make('tbl')
                ->searchable(),
            'id_approvaz' => TextColumn::make('id_approvaz')
                ->numeric()
                ->sortable(),
            'datemod' => TextColumn::make('datemod')
                ->dateTime()
                ->sortable(),
            'handle' => TextColumn::make('handle')
                ->searchable(),

        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getTableFilters(): array
    {
        return [];
    }

    /**
     * @return array<int, \Filament\Actions\EditAction>
     */
    public function getTableActions(): array
    {
        return [
            EditAction::make(),

        ];
    }

    /**
     * @return array<int, \Filament\Actions\DeleteBulkAction>
     */
    public function getTableBulkActions(): array
    {
        return [
            DeleteBulkAction::make(),

        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListMyLogs::route('/'),
            'create' => CreateMyLog::route('/create'),
            'edit' => EditMyLog::route('/{record}/edit'),
        ];
    }
}
