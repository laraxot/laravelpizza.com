<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\User;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Colonne per l'accesso con SPID e CIE (PRD-02). I controller del tema cercavano l'utente per `fiscal_code` e scrivevano
 * `auth_method`, colonne che non esistevano: il primo accesso con identità digitale finiva in errore SQL.
 *
 * Minimizzazione (GDPR art. 5): si salvano solo l'identificativo (codice fiscale), il metodo e il gestore dell'identità
 * e l'ultimo accesso. Nome e cognome vanno in `first_name`/`last_name`, che esistono già. Data e luogo di nascita, sesso,
 * indirizzo e telefono restituiti dall'IdP non servono a una segnalazione e non si conservano.
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = User::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('fiscal_code')) {
                // Unico ma nullable: gli utenti registrati con email non hanno codice fiscale.
                $table->string('fiscal_code', 16)->nullable()->unique();
            }

            if (! $this->hasColumn('auth_method')) {
                // `spid` o `cie` (HasVerifiedIdentityAction::TRUSTED_IDENTITY_METHODS); null per l'accesso con email.
                $table->string('auth_method', 20)->nullable()->index();
            }

            if (! $this->hasColumn('identity_provider')) {
                // Identity provider SPID scelto (es. `poste`) oppure `cie`.
                $table->string('identity_provider', 50)->nullable();
            }

            if (! $this->hasColumn('last_login_at')) {
                $table->timestamp('last_login_at')->nullable();
            }
        });
    }
};
