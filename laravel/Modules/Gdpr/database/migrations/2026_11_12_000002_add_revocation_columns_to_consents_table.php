<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Gdpr\Models\Consent;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Revoca dei consensi (GDPR art. 7.3) e richiesta di cancellazione (art. 17).
 * RevokeGdprConsentsAction, HasGdpr e DeleteAccountAction scrivono `revoked_at`, `revoked_ip_address` e `metadata`,
 * ma nessuna migrazione li creava: "elimina account" falliva con "Unknown column 'revoked_at'".
 */
return new class extends XotBaseMigration
{
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
            if (! $this->hasColumn('metadata')) {
                $table->json('metadata')->nullable();
            }
        });
    }
};
