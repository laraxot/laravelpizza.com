<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Pages;

use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Illuminate\Support\Arr;
use Modules\User\Filament\Resources\RoleResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord;

class EditRole extends XotBaseEditRecord
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            'view' => ViewAction::make(),
            'delete' => DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        /** @var array<string, mixed> $result */
        $result = Arr::only($data, ['name', 'guard_name']);

        return $result;
    }
}
