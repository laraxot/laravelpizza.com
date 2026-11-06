<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PasswordResetResource\Tables;

use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\PasswordReset;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

class PasswordResetsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<PasswordReset>
     */
    protected static string $model = PasswordReset::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'email' => TextColumn::make('email')->searchable()->sortable()->copyable(),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
