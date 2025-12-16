<?php

declare(strict_types=1);

namespace Modules\User\Filament\Widgets;

use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Modules\User\Models\AuthenticationLog;

final class RecentLoginsWidget extends BaseWidget
{
    protected static ?string $heading = 'Recent Logins'; // Rendi static la proprietà

    protected int|string|array $columnSpan = 'full';

    /**
     * Define the columns to display in the table.
     */
    public function getTableColumns(): array
    {
        return [
            TextColumn::make('user'),
            TextColumn::make('login_at'),
            TextColumn::make('ip_address'),
            TextColumn::make('user_agent'),
        ];
    }

    /**
     * Optionally configure additional table settings.
     *
     * @return array<string, Action|ActionGroup>
     */
    public function getTableActions(): array
    {
        return [];
    }

    /**
     * Define the query to fetch recent logins.
     */
    protected function getTableQuery(): Builder
    {
        return AuthenticationLog::query()
            ->where('login_successful', true)
            ->orderBy('login_at', 'desc')
            ->limit(10);
    }
}
