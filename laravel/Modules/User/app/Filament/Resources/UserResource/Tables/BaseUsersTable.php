<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Filament\Resources\UserResource\Actions\VerifyEmailAction;
use Modules\User\Models\User;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;

abstract class BaseUsersTable extends XotBaseResourceTable
{
    /**
     * @var class-string<User>
     */
    protected static string $model = User::class;

    /**
     * @return array<int|string, Action|ActionGroup>
     */
    #[\Override]
    public function getTableActions(): array
    {
        return [
            'verify_email' => VerifyEmailAction::make()->iconButton(),
            ...parent::getTableActions(),
        ];
    }

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            'email' => TextColumn::make('email')->searchable()->sortable()->copyable(),
            'first_name' => TextColumn::make('first_name')->searchable()->sortable(),
            'last_name' => TextColumn::make('last_name')->searchable()->sortable(),
            'is_active' => IconColumn::make('is_active')->boolean()->sortable(),
            'email_verified_at' => TextColumn::make('email_verified_at')->dateTime()->sortable()->placeholder('—'),
            'is_otp' => IconColumn::make('is_otp')->boolean()->sortable()->toggleable(isToggledHiddenByDefault: true),
            'lang' => TextColumn::make('lang')->toggleable(isToggledHiddenByDefault: true),
            'current_team_id' => TextColumn::make('current_team_id')->toggleable(isToggledHiddenByDefault: true),
            'type' => TextColumn::make('type')->toggleable(isToggledHiddenByDefault: true),
            'state' => TextColumn::make('state')->searchable()->toggleable(isToggledHiddenByDefault: true),
            'password_expires_at' => TextColumn::make('password_expires_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }
}
