<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class DevicesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'devices';

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            'device' => TextInput::make('device')->required()->maxLength(255),
        ];
    }

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'uuid' => TextColumn::make('uuid'),
            'mobile_id' => TextColumn::make('mobile_id'),
            'device' => TextColumn::make('device'),
            'platform' => TextColumn::make('platform'),
            'browser' => TextColumn::make('browser'),
            'version' => TextColumn::make('version'),
            'login_at' => TextColumn::make('login_at'),
            'logout_at' => TextColumn::make('logout_at'),
        ];
    }

    /**
     * Override del default `XotBaseRelationManager::getTableActions()`: aggiunge
     * `->tooltip()` ai pulsanti icon-only (il default della base class li lascia
     * senza aria-label, unico meccanismo di accessibilita' per bottoni icona-sola
     * in Filament).
     *
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableActions(): array
    {
        $me = $this;

        return [
            'edit' => EditAction::make()
                ->iconButton()
                ->tooltip(trans('user::user.actions.edit.tooltip'))
                ->visible(static function (?Model $record) use ($me): bool {
                    if ($record === null) {
                        return false;
                    }

                    return $me->canEdit($record);
                }),
            'detach' => DetachAction::make()
                ->iconButton()
                ->tooltip(trans('user::user.actions.detach.tooltip'))
                ->visible(static function (?Model $record) use ($me): bool {
                    if ($record === null) {
                        return false;
                    }

                    return $me->canDetach($record);
                }),
        ];
    }
}
