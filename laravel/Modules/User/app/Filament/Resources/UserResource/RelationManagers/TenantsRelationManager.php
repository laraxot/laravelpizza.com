<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DetachAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Tables\Columns\Column;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Filament\Resources\TenantResource\Pages\ListTenants;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

/**
 * Manages the relationship between users and tenants.
 *
 * This class provides the form schema and table configuration for the "tenants" relationship
 * with strong typing and enhanced structure for stability and professionalism.
 */
class TenantsRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'tenants';

    protected static ?string $recordTitleAttribute = 'name';

    /**
     * Set up the form schema for tenant relations.
     *
     * @return array<Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required()->maxLength(255),
        ];
    }

    /**
     * Define table columns for displaying tenant information.
     *
     * @return array<string, Column>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        $listTenants = app(ListTenants::class);

        if (! method_exists($listTenants, 'getTableColumns')) {
            return [];
        }

        $columns = $listTenants->getTableColumns();

        /** @var array<string, Column> $columnMap */
        $columnMap = [];
        foreach ($columns as $column) {
            if (! $column instanceof Column) {
                continue;
            }

            $columnMap[(string) $column->getName()] = $column;
        }

        return $columnMap;
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
