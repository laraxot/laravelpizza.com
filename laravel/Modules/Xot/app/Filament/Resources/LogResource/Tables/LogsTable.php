<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\LogResource\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Number;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Models\Log;

class LogsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Log>
     */
    protected static string $model = Log::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'size' => TextColumn::make('size')
                ->formatStateUsing(static fn (?int $state): ?string => $state === null ? null : Number::fileSize($state))
                ->placeholder('—')
                ->sortable(),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            'level_name' => SelectFilter::make('level_name')
                ->options([
                    'emergency' => 'Emergency',
                    'alert' => 'Alert',
                    'critical' => 'Critical',
                    'error' => 'Error',
                    'warning' => 'Warning',
                    'notice' => 'Notice',
                    'info' => 'Info',
                    'debug' => 'Debug',
                ]),
        ];
    }

    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    public function getTableBulkActions(): array
    {
        return [
            'delete' => DeleteBulkAction::make(),
        ];
    }
}
