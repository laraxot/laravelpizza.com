<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\RoleResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Component;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Modules\Xot\Filament\Resources\RelationManagers\XotBaseRelationManager;

/**
 * UsersRelationManager.
 *
 * Manages the relationship between users and roles, providing functionality
 * for viewing, filtering, and managing users associated with a specific role.
 */
final class UsersRelationManager extends XotBaseRelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $inverseRelationship = 'roles';

    /**
     * Returns the form schema structure, defining the input fields for user data.
     *
     * @return array<\Filament\Schemas\Components\Component>
     */
    #[\Override]
    public function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required()->maxLength(255),
            // Additional fields can be added here as necessary
        ];
    }

    /**
     * Defines the columns displayed in the users list table.
     *
     * @return array<Tables\Columns\Column|Component>
     */
    #[\Override]
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->copyable(),
            TextColumn::make('email')
                ->searchable()
                ->sortable()
                ->copyable(),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    /**
     * Configures available filters for the table, enabling users to refine their view.
     *
     * @return array<BaseFilter>
     */
    #[\Override]
    public function getTableFilters(): array
    {
        return [
            Filter::make('active')->query(fn (Builder $query): Builder => $query->where('is_active', true))->toggle(),
            Filter::make('created_at')
                ->schema([
                    DatePicker::make('created_from'),
                    DatePicker::make('created_until'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    if (isset($data['created_from']) && is_string($data['created_from']) && '' !== $data['created_from']) {
                        $query->whereDate('created_at', '>=', $data['created_from']);
                    }

                    if (isset($data['created_until']) && is_string($data['created_until']) && '' !== $data['created_until']) {
                        $query->whereDate('created_at', '<=', $data['created_until']);
                    }

                    return $query;
                })
                ->columns(2),
        ];
    }
}
