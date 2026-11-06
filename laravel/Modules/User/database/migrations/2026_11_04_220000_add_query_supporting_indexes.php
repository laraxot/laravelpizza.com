<?php

declare(strict_types=1);

use Modules\User\Models\AuthenticationLog;
use Modules\User\Models\RoleHasPermission;
use Modules\User\Models\SocialiteUser;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Indici di supporto alle query lente del modulo User, tutte sulla connessione `user`.
 *
 * Solo aggiunte idempotenti (XotBaseMigration::ensureIndexes). Niente down(): togliere indici in
 * produzione e' una decisione dell'utente. I nomi delle tabelle vengono dai modelli.
 *
 * Prove: audit statico del 2026-11-04, nessun `EXPLAIN` su volumi di produzione.
 *
 * @see ../../../Quaeris/docs/stories/quaeris-query-lente-e-indici.story.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = AuthenticationLog::class;

    public function up(): void
    {
        $this->ensureIndexes($this->indexes());
    }

    /**
     * Tabella => nome indice => colonne in ordine (prima l'uguaglianza, poi l'intervallo).
     *
     * @return array<string, array<string, list<string>>>
     */
    private function indexes(): array
    {
        return [
            // RecentLoginsWidget, UserOverview, UsersChartWidget: filtro/ordine su login_at e login_successful.
            (new AuthenticationLog)->getTable() => [
                'authentication_logs_login_at_successful_index' => ['login_at', 'login_successful'],
                // Il model:prune cancella per created_at (AuthenticationLog::prunable, 365 giorni).
                'authentication_logs_created_at_index' => ['created_at'],
            ],
            // RetrieveSocialiteUserAction: provider + provider_id a ogni accesso SSO, user_id + provider per i collegamenti.
            (new SocialiteUser)->getTable() => [
                'socialite_users_provider_index' => ['provider', 'provider_id'],
                'socialite_users_user_id_index' => ['user_id'],
            ],
            // Ricostruzione della cache Spatie: role_id = ? e permission_id IN (...). Oggi la tabella ha solo la PK.
            (new RoleHasPermission)->getTable() => [
                'role_has_permission_role_permission_index' => ['role_id', 'permission_id'],
                'role_has_permission_permission_role_index' => ['permission_id', 'role_id'],
            ],
        ];
    }
};
