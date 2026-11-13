<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Gdpr\Models\Consent;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Colonne di revoca dei consensi. RevokeGdprConsentsAction (chiamata da "Elimina il mio account") e HasGdpr le scrivono e
 * le leggono, ma nessuna migrazione le creava: la cancellazione dell'account rispondeva 500. Additiva e idempotente.
 */
return new class extends XotBaseMigration {
    protected ?string $model_class = Consent::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('revoked_at')) {
                $table->timestamp('revoked_at')->nullable()->index();
            }
            if (! $this->hasColumn('revoked_ip_address')) {
                $table->string('revoked_ip_address', 45)->nullable();
            }
        });
    }

    public function down(): void {}
};
