<?php

declare(strict_types=1);

namespace Modules\User\Filament\Clusters\Passport\Widgets;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Laravel\Passport\Passport as LaravelPassport;
use Modules\User\Filament\Clusters\Passport;
use Modules\User\Filament\Clusters\Passport\Resources\OauthAccessTokenResource;
use Modules\User\Filament\Clusters\Passport\Resources\OauthClientResource;
use Modules\User\Filament\Clusters\Passport\Resources\OauthRefreshTokenResource;
use Modules\Xot\Filament\Widgets\XotBaseStatsOverviewWidget;

/**
 * Widget statistiche Passport per la dashboard OAuth.
 */
class PassportStatsWidget extends XotBaseStatsOverviewWidget
{
    protected static ?string $cluster = Passport::class;

    protected static ?int $sort = 1;

    protected ?string $heading = 'Statistiche OAuth';

    /**
     * @return array<Stat>
     */
    #[\Override]
    protected function getStats(): array
    {
        $clientModel = LaravelPassport::clientModel();
        $tokenModel = LaravelPassport::tokenModel();
        $refreshTokenModel = LaravelPassport::refreshTokenModel();

        $clientsTotal = $clientModel::query()->count();
        $tokensTotal = $tokenModel::query()->count();
        $tokensRevoked = $tokenModel::query()->where('revoked', true)->count();
        $tokensValid = $tokenModel::query()
            ->where('revoked', false)
            ->where('expires_at', '>', now())
            ->count();
        $refreshTokensTotal = $refreshTokenModel::query()->count();

        return [
            Stat::make(__('user::passport.stats.clients_total'), (string) $clientsTotal)
                ->description(__('user::passport.stats.clients_description'))
                ->descriptionIcon('heroicon-m-identification')
                ->url(OauthClientResource::getUrl('index'))
                ->color('primary'),

            Stat::make(__('user::passport.stats.tokens_total'), (string) $tokensTotal)
                ->description(__('user::passport.stats.tokens_description'))
                ->descriptionIcon('heroicon-m-key')
                ->url(OauthAccessTokenResource::getUrl('index'))
                ->color('success'),

            Stat::make(__('user::passport.stats.tokens_valid'), (string) $tokensValid)
                ->description(__('user::passport.stats.tokens_valid_description'))
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make(__('user::passport.stats.tokens_revoked'), (string) $tokensRevoked)
                ->description(__('user::passport.stats.tokens_revoked_description'))
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),

            Stat::make(__('user::passport.stats.refresh_tokens_total'), (string) $refreshTokensTotal)
                ->description(__('user::passport.stats.refresh_tokens_description'))
                ->descriptionIcon('heroicon-m-arrow-path')
                ->url(OauthRefreshTokenResource::getUrl('index'))
                ->color('warning'),
        ];
    }
}
