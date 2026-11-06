<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\User\Actions\Shield\GetPermissionModelAction;
use Modules\User\Filament\Resources\RoleResource;
use Modules\User\Models\Role;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;
use Webmozart\Assert\Assert;

class EditRole extends XotBaseEditRecord
{
    /** @var Collection<int, string> */
    public Collection $permissions;

    // public Role $record;
    protected static string $resource = RoleResource::class;

    /**
     *  ---.
     */
    public function afterSave(): void
    {
        $permissionModels = collect();
        Assert::isArray($data = $this->data);
        $this->permissions->each(static function (string $permission) use ($permissionModels, $data): void {
            $permissionModels->push(app(GetPermissionModelAction::class)->execute()::firstOrCreate([
                'name' => $permission,
                'guard_name' => $data['guard_name'] ?? 'web',
            ]));
        });
        Assert::isInstanceOf($this->record, Role::class, '['.__LINE__.']['.class_basename($this).']');
        $this->record->syncPermissions($permissionModels);
    }

    protected function getHeaderActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $this->permissions = collect($data)
            ->keys()
            ->filter(
                static fn (string $key): bool => ! \in_array($key, ['name', 'guard_name', 'select_all'], false) && Str::contains($key, '_'),
            )
            ->values();

        /** @var array<string, mixed> $result */
        $result = Arr::only($data, ['name', 'guard_name']);

        return $result;
    }
}
