<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Profile;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Profilo pubblico e pagina "Modifica il profilo" (/{lingua}/profile/edit): biografia, lingua preferita e indirizzo.
 * La tabella profiles del modulo Meetup (database dati) non aveva queste colonne: il blocco profile.detail le leggeva
 * ma restavano sempre vuote, e salvarle dava "Unknown column 'bio'".
 */
return new class extends XotBaseMigration
{
    protected ?string $model_class = Profile::class;

    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table): void {
            if (! $this->hasColumn('bio')) {
                $table->text('bio')->nullable()->after('email');
            }
            if (! $this->hasColumn('locale')) {
                $table->string('locale', 8)->nullable()->after('bio');
            }
            if (! $this->hasColumn('address')) {
                $table->string('address')->nullable()->after('locale');
            }
        });
    }
};
