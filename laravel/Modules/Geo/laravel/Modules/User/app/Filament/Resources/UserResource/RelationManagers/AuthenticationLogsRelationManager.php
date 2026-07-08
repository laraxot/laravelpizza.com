<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

use function Safe\json_encode;

/**
 * Class AuthenticationLogsRelationManager.
 */
class AuthenticationLogsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'authentications';

    protected static ?string $recordTitleAttribute = 'ip_address';

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'ip_address' => TextColumn::make('ip_address')
                ->sortable(),
            'user_agent' => TextColumn::make('user_agent')
                ->limit(50),
            'login_successful' => IconColumn::make('login_successful')
                ->boolean(),
            'login_at' => TextColumn::make('login_at')
                ->dateTime()
                ->sortable(),
            'logout_at' => TextColumn::make('logout_at')
                ->dateTime()
                ->sortable(),
            'location' => TextColumn::make('location')
                ->formatStateUsing(function ($state) {
                    if (is_array($state)) {
                        return collect($state)
                            ->map(fn ($value, $key): string => (string) $key.': '.(string) $value)
                            ->join(', ');
                    }

                    if (null === $state) {
                        return 'N/A';
                    }

                    return json_encode($state);
                }),
            'created_at' => TextColumn::make('created_at')
                ->dateTime()
                ->sortable(),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableActions(): array
    {
        return [
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }
}
