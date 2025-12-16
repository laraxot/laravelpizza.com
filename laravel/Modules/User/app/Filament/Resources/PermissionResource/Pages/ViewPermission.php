<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\PermissionResource\Pages;

use Filament\Infolists\Components\TextEntry;
use Filament\Support\Components\Component;
use Modules\User\Filament\Resources\PermissionResource;
use Modules\Xot\Filament\Resources\Pages\XotBaseViewRecord;

class ViewPermission extends XotBaseViewRecord
{
    protected static string $resource = PermissionResource::class;

    /**
     * @return array<int, Component>
     */
    #[\Override]
    public function getInfolistSchema(): array
    {
        return [
            TextEntry::make('name')->label(__('user::permission.fields.name.label')),
            TextEntry::make('guard_name')->label(__('user::permission.fields.guard_name.label')),
            TextEntry::make('active')
                ->label(__('user::permission.fields.active.label'))
                ->formatStateUsing(fn ($state): string => $state ? __('user::common.yes') : __('user::common.no')),
            TextEntry::make('created_at')
                ->label(__('user::permission.fields.created_at.label'))
                ->dateTime(),
        ];
    }
}
