<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Gdpr\Models\Consent;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * `consents.metadata`: SaveGdprConsentsAction la scrive alla registrazione (versione dell'informativa, origine del consenso).
 * La colonna la creava `2024_01_01_000006_create_consents_table`, cancellata due volte dai mirror (becb0d58b, 483080dca):
 * su un database nuovo ogni registrazione falliva con "Unknown column 'metadata'". Additiva e idempotente; il nome datato
 * la tiene distinta dalle `create_consents_table` storiche.
 */
return new class extends XotBaseMigration {
    protected ?string $model_class = Consent::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('metadata')) {
                $table->json('metadata')->nullable();
            }
        });
    }

    public function down(): void {}
};
