<?php

declare(strict_types=1);
/**
 * @see https://github.com/ryangjchandler/filament-user-resource/blob/main/src/resources/UserResource.php
 * @see https://github.com/3x1io/filament-user/blob/main/src/resources/UserResource.php
 */

namespace Modules\User\Filament\Resources;

use Filament\Resources\RelationManagers\RelationGroup;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\RelationManagers\RelationManagerConfiguration;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Filament\Resources\UserResource\RelationManagers\AuthenticationLogsRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\ClientsRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\DevicesRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\OauthTokensRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\ProfileRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\RolesRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\SocialiteUsersRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\TeamsRelationManager;
use Modules\User\Filament\Resources\UserResource\RelationManagers\TenantsRelationManager;
use Modules\User\Filament\Resources\UserResource\Widgets\UserOverview;
use Modules\Xot\Datas\XotData;
use Modules\Xot\Filament\Resources\XotBaseResource;

class UserResource extends XotBaseResource
{
    /**
     * Raggruppa i 9 RelationManager in 4 tab invece di 9, usando il meccanismo
     * nativo Filament v4 `RelationGroup` (piu' manager renderizzati in sequenza
     * sotto una sola tab con badge/icona propri: vedi
     * `vendor/filament/filament/src/Resources/RelationManagers/RelationGroup.php`
     * e `HasRelationManagers::getRelationManagerTabComponent()`).
     *
     * Raggruppamento (proposto dall'audit UX, vedi
     * docs/wiki/user-resource-clustering-widgets-actions-audit.md):
     * - Profilo: tab propria (dati personali, priorita' massima).
     * - Sicurezza: log accessi + dispositivi + client OAuth + token OAuth.
     * - Organizzazione: ruoli + team + tenant.
     * - Social login: tab propria (bassa frequenza d'uso, non centrale alla sicurezza).
     *
     * @return array<int, class-string<RelationManager>|RelationGroup|RelationManagerConfiguration>
     */
    #[\Override]
    public static function getRelations(): array
    {
        return [
            ProfileRelationManager::class,
            RelationGroup::make(trans('user::user.relation_groups.security.label'), [
                AuthenticationLogsRelationManager::class,
                DevicesRelationManager::class,
                ClientsRelationManager::class,
                OauthTokensRelationManager::class,
            ])->icon('heroicon-o-shield-check'),
            RelationGroup::make(trans('user::user.relation_groups.organization.label'), [
                RolesRelationManager::class,
                TeamsRelationManager::class,
                TenantsRelationManager::class,
            ])->icon('heroicon-o-building-office-2'),
            SocialiteUsersRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            UserOverview::class,
        ];
    }

    // public static function extendForm(\Closure $callback): void
    // {
    //    static::$extendFormCallback = $callback;
    // }

    // public static function enablePasswordUpdates(bool|Closure $condition = true): void
    // {
    //     static::$enablePasswordUpdates = $condition;
    // }

    /*
     * public static function getModel(): string
     * {
     * return config('filament-user-resource.model');
     * }
     */

    #[\Override]
    public function hasCombinedRelationManagerTabsWithContent(): bool
    {
        return true;
    }

    /**
     * @return class-string<Model>
     */
    #[\Override]
    public static function getModel(): string
    {
        return XotData::make()->getUserClass();
    }
}
