<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Lang\Models\Translation;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Conversione `translations.user_id` da bigint a UUID.
 *
 * Stessa correzione di `posts.user_id`: la colonna era bigint e non puo'
 * contenere gli UUID di Modules\User\Models\User. Conversione delegata a
 * XotBaseMigration::convertUserIdToUuidIfLegacyBigint (idempotente e con
 * guardia sui dati legacy).
 *
 * @see Modules/Lang/docs/migrations.md
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Translation::class;

    public function up(): void
    {
        if (! $this->tableExists()) {
            return;
        }

        // Stessa correzione di posts.user_id: la colonna era bigint e non puo'
        // contenere gli UUID di Modules\User\Models\User. Convertita solo se
        // esistente e ancora bigint.
        $this->tableUpdate(function (Blueprint $table): void {
            $this->convertUserIdToUuidIfLegacyBigint($table);
        });
    }
};
