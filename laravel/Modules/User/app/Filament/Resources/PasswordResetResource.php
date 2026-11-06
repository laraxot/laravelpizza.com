<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Illuminate\Database\Eloquent\Builder;
use Modules\User\Filament\Resources\PasswordResetResource\Pages\ListPasswordResets;
use Modules\User\Filament\Resources\PasswordResetResource\Pages\ViewPasswordReset;
use Modules\User\Models\PasswordReset; // Added
use Modules\Xot\Filament\Resources\XotBaseResource;

class PasswordResetResource extends XotBaseResource
{
    protected static ?string $model = PasswordReset::class;

    public static function getPages(): array
    {
        return [
            'index' => ListPasswordResets::route('/'),
            'view' => ViewPasswordReset::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}
