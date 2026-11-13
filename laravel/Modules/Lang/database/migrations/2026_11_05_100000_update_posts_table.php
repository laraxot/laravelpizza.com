<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Post;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Conversione `posts.user_id` da bigint a UUID.
 *
 * `user_id` nasce bigint con lo scaffold iniziale, ma gli id di
 * Modules\User\Models\User sono UUID (HasUuids): ogni insert con un
 * utente reale falliva con "Incorrect integer value". La conversione
 * e' delegata a XotBaseMigration::convertUserIdToUuidIfLegacyBigint,
 * che e' idempotente (salta se la colonna non e' piu' bigint) e rifiuta
 * di procedere se esistono righe con valore legacy.
 *
 * @see Modules/Lang/docs/migrations.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Post::class;

    public function up(): void
    {
        // `user_id` nasce bigint con lo scaffold iniziale, ma gli id di
        // Modules\User\Models\User sono UUID (HasUuids): ogni insert con un
        // utente reale fallisce con "Incorrect integer value". Stessa
        // conversione che XotBaseMigration::updateUserKeyString applica al
        // resto della piattaforma. Si converte solo se la colonna esiste ed e'
        // ancora bigint: gli ambienti gia' corretti non vengono toccati.
        $this->tableUpdate(function (Blueprint $table): void {
            $this->convertUserIdToUuidIfLegacyBigint($table);
        });
    }
};
