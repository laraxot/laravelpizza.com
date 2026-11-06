<?php

declare(strict_types=1);

namespace Modules\User\Filament\Resources\UserResource\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;
use Modules\User\Models\AuthenticationLog;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;

/**
 * Statistiche di sintesi sugli utenti, mostrate in testa alla lista utenti
 * (`ListUsers::getHeaderWidgets()`).
 *
 * Sostituisce il precedente placeholder che mostrava solo `$record->name`:
 * su una pagina di elenco `$record` e' sempre `null`, quindi il widget
 * originale renderizzava staticamente "Utente" senza alcun valore informativo.
 */
class UserOverview extends XotBaseStatsOverviewWidget
{
    /**
     * @return array<int, Stat>
     */
    protected function getStats(): array
    {
        $userClass = XotData::make()->getUserClass();

        $total = $userClass::query()->count();
        $active = $userClass::query()->where('is_active', true)->count();
        $verified = $userClass::query()->whereNotNull('email_verified_at')->count();
        $verifiedPercent = $total > 0 ? (int) round(($verified / $total) * 100) : 0;
        $recentLogins = AuthenticationLog::query()
            ->where('login_successful', true)
            ->where('login_at', '>=', Carbon::now()->subDay())
            ->count();

        return [
            Stat::make(trans('user::user.widgets.overview.total.label'), (string) $total)
                ->description(trans('user::user.widgets.overview.total.description'))
                ->icon('heroicon-o-users')
                ->color('primary'),
            Stat::make(trans('user::user.widgets.overview.active.label'), (string) $active)
                ->description(trans('user::user.widgets.overview.active.description'))
                ->icon('heroicon-o-check-circle')
                ->color('success'),
            Stat::make(trans('user::user.widgets.overview.verified.label'), $verifiedPercent.'%')
                ->description(trans('user::user.widgets.overview.verified.description'))
                ->icon('heroicon-o-shield-check')
                ->color($verifiedPercent >= 80 ? 'success' : 'warning'),
            Stat::make(trans('user::user.widgets.overview.recent_logins.label'), (string) $recentLogins)
                ->description(trans('user::user.widgets.overview.recent_logins.description'))
                ->icon('heroicon-o-arrow-right-on-rectangle')
                ->color('info'),
        ];
    }
}
