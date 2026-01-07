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
     * @return array<string, Component>
     */
    #[\Override]
    public function getInfolistSchema(): array
    {
        return [
            'name' => TextEntry::make('name'),
            'guard_name' => TextEntry::make('guard_name'),
            'active' => TextEntry::make('active')
                ->formatStateUsing(fn ($state): string => $state ? __('user::common.yes') : __('user::common.no')),
            'created_at' => TextEntry::make('created_at')
                ->dateTime(),
        ];
    }
}
