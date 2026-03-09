<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\Pages;

use Illuminate\Support\Arr;
use Modules\User\Filament\Resources\RoleResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseCreateRecord;

class CreateRole extends XotBaseCreateRecord
{
    protected static string $resource = RoleResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        /** @var array<string, mixed> $res */
        $res = Arr::only($data, ['name', 'guard_name', 'team_id']);
        if (! isset($res['team_id'])) {
            $res['team_id'] = null;
        }

        return $res;
    }
}
