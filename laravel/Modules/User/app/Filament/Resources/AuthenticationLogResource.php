<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\AuthenticationLogResource\Pages\ListAuthenticationLogs;
use Modules\User\Filament\Resources\AuthenticationLogResource\Pages\ViewAuthenticationLog;
use Modules\User\Models\AuthenticationLog;
use Modules\Xot\Filament\Resources\XotBaseResource;

class AuthenticationLogResource extends XotBaseResource
{
    protected static ?string $model = AuthenticationLog::class;

    public static function getPages(): array
    {
        return [
            'index' => ListAuthenticationLogs::route('/'),
            'view' => ViewAuthenticationLog::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['authenticatable']);
    }
}
