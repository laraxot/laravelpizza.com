<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\OauthRefreshToken;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * `oauth_refresh_tokens.access_token_id` era creata con foreignIdFor(OauthAccessToken::class): il token
 * Passport ha chiave stringa, quindi la colonna nasceva uuid/char(36) e l'id del token (80 caratteri)
 * veniva troncato sulle connessioni non strict. Nessun refresh token si ritrovava dal suo access token:
 * revoca (RevokeUserAccessAction, logout) e rotazione di Passport non lo vedevano.
 * Additiva e idempotente: porta la colonna a varchar(100) come `oauth_access_tokens.id`.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = OauthRefreshToken::class;

    public function up(): void
    {
        if (! $this->tableExists() || ! $this->hasColumn('access_token_id')) {
            return;
        }

        if (in_array($this->getColumnType('access_token_id'), ['varchar', 'string', 'text'], true)) {
            return;
        }

        $this->tableUpdate(function (Blueprint $table): void {
            $table->string('access_token_id', 100)->change();
        });
    }
};
