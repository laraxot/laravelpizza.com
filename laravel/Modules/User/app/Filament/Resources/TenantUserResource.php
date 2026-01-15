<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources;

use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Models\TenantUser;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * Class TenantUserResource.
 */
final class TenantUserResource extends XotBaseResource
{
    protected static ?string $model = TenantUser::class;

    /**
     * @return array<string, Component>
     */
    #[\Override]
    public static function getFormSchema(): array
    {
        return [
            'tenant_user' => Section::make('Tenant User Information')
                ->schema([
                    'tenant_id' => Select::make('tenant_id')
                        ->label('Tenant')
                        ->relationship('tenant', 'name')
                        ->required()
                        ->searchable(),
                    'user_id' => Select::make('user_id')
                        ->label('User')
                        ->relationship('user', 'name')
                        ->required()
                        ->searchable(),
                    'role' => Select::make('role')
                        ->label('Role')
                        ->options([
                            'admin' => 'Admin',
                            'manager' => 'Manager',
                            'user' => 'User',
                            'viewer' => 'Viewer',
                        ])
                        ->required()
                        ->searchable()
                        ->helperText('Role of the user in the tenant'),
                ])
                ->columns(2),
        ];
    }

    /**
     * Configure the model query.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['tenant', 'user']);
    }
}
