<?php

declare(strict_types=1);

namespace Modules\Xot\Filament\Resources\SessionResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Modules\Xot\Models\Session;

class SessionsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Session>
     */
    protected static string $model = Session::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'user_id' => TextColumn::make('user_id')->searchable()->sortable(),
            'ip_address' => TextColumn::make('ip_address')->searchable()->sortable(),
            'last_activity' => TextColumn::make('last_activity')
                ->since()
                ->dateTimeTooltip()
                ->sortable(),
            'user_agent' => TextColumn::make('user_agent')->searchable()->limit(60)->wrap()->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->searchable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
