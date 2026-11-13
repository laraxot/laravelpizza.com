<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Gdpr\Models\Consent;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Adds the columns HasGdpr::giveConsent()/revokeConsent() have always written to
 * (metadata, revoked_at, revoked_ip_address) but that no prior consents migration
 * ever created — calling those trait methods previously threw a SQL error.
 */
return new class extends XotBaseMigration {
    protected ?string $model_class = Consent::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('metadata')) {
                $table->json('metadata')->nullable();
            }
            if (! $this->hasColumn('revoked_at')) {
                $table->timestamp('revoked_at')->nullable();
            }
            if (! $this->hasColumn('revoked_ip_address')) {
                $table->string('revoked_ip_address', 45)->nullable();
            }
        });
    }
};
