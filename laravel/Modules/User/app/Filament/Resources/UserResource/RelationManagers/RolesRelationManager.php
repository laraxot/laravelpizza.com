<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Filament\Actions\Header\AttachRoleAction;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

class RolesRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'roles';

    protected static ?string $recordTitleAttribute = 'name';

    // protected static ?string $inverseRelationship = 'section'; // Since the inverse related model is `Category`, this is normally `category`, not `section`.
    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    // }
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
        ];
    }

    /**
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            'id' => IDColumn::make('id'),
            'name' => TextColumn::make('name'),
            'team_id' => TextColumn::make('team_id'),
        ];
    }

    /**
     * @return array<string, Action>
     */
    #[\Override]
    public function getTableHeaderActions(): array
    {
        /** @var array<string, Action> $parentActions */
        $parentActions = parent::getTableHeaderActions();

        return array_merge(
            $parentActions,
            [
                'attach' => AttachRoleAction::make(),
            ]
        );
    }

    /**
     * Override del default `XotBaseRelationManager::getTableActions()`: aggiunge
     * `->tooltip()` ai pulsanti icon-only, unico meccanismo di accessibilita'
     * (aria-label) per bottoni icona-sola in Filament.
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
