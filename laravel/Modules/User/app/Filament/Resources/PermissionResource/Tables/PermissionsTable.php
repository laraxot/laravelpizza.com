<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PermissionResource\Tables;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\UI\Filament\Tables\Columns\IDColumn;
use Modules\User\Models\Permission;
use Modules\User\Models\Role;
use Modules\Xot\Filament\Resources\Tables\XotBaseResourceTable;
use Webmozart\Assert\Assert;

class PermissionsTable extends XotBaseResourceTable
{
    /**
     * @var class-string<Permission>
     */
    protected static string $model = Permission::class;

    /**
     * @return array<string, Column>
     */
    public function getTableColumns(): array
    {
        return [
            'name' => TextColumn::make('name')->searchable()->sortable(),
            // NOTA: 'display_name' non esiste nello schema reale (tabella `permissions`,
            // connessione `user`; confermato via Schema::getColumnListing() e dalla
            // migration owner 2026_09_01_150112_create_permissions_table.php, che
            // dichiara esplicitamente nessuna colonna aggiuntiva). ->searchable()/
            // ->sortable() generavano una query SQL su colonna inesistente: rimossi.
            // Vedi https://github.com/laraxot/module_user_fila5/issues/90.
            'display_name' => TextColumn::make('display_name'),
            'guard_name' => TextColumn::make('guard_name')->searchable()->sortable(),
            'active' => IconColumn::make('active')->boolean(),
            'description' => TextColumn::make('description')->limit(60)->wrap()->toggleable(isToggledHiddenByDefault: true),
            'id' => IDColumn::make('id')->sortable()->copyable()->toggleable(isToggledHiddenByDefault: true),
            'created_at' => TextColumn::make('created_at')->dateTime()->sortable()->placeholder('—'),
            'updated_at' => TextColumn::make('updated_at')->dateTime()->sortable()->placeholder('—')->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * @return array<string, BaseFilter>
     */
    public function getTableFilters(): array
    {
        return [
            'guard_name' => SelectFilter::make('guard_name')
                ->options([
                    'web' => 'Web',
                    'api' => 'API',
                    'sanctum' => 'Sanctum',
                ])
                ->multiple(),
        ];
    }

    /**
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'edit' => EditAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    /**
     * @return array<string, BulkAction>
     */
    public function getTableBulkActions(): array
    {
        Assert::classExists($roleModel = config('permission.models.role'));

        return [
            'delete' => DeleteBulkAction::make(),
            'attach_role' => BulkAction::make('Attach Role')
                ->action(static function (Collection $collection, array $data): void {
                    foreach ($collection as $record) {
                        if (method_exists($record, 'roles')) {
                            /** @var BelongsToMany<Role, Permission> $rolesRelation */
                            $rolesRelation = $record->roles();
                            $roleData = $data['role'] ?? null;
                            if (is_array($roleData) || is_int($roleData) || is_string($roleData)) {
                                $syncData = is_array($roleData) ? $roleData : [$roleData];
                                $rolesRelation->sync($syncData);
                                $record->save();
                            }
                        }
                    }
                })
                ->schema([
                    Select::make('role')
                        ->options(function () use ($roleModel): array {
                            /** @var Builder<Role> $query */
                            $query = $roleModel::query();

                            return $query->pluck('name', 'id')
                                ->mapWithKeys(static fn (mixed $name, int|string $id): array => is_string($name) || is_int($name) ? [(string) $id => (string) $name] : [])
                                ->all();
                        })
                        ->required(),
                ])
                ->deselectRecordsAfterCompletion(),
        ];
    }
}
