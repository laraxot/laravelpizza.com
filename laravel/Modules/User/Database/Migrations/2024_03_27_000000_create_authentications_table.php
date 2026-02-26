<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\User\Models\Authentication;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Authentication::class;

    /**
     * Esegue la migrazione.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->string('type');
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->json('location')->nullable();
            $table->timestamp('login_at')->nullable();
            $table->boolean('login_successful')->default(false);
            $table->timestamp('logout_at')->nullable();
            $table->uuidMorphs('authenticatable', 'k_authentications_morph');
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // Aggiungi colonne mancanti se non esistono
            if (! $this->hasColumn('login_at')) {
                $table->timestamp('login_at')->nullable();
            }
            if (! $this->hasColumn('login_successful')) {
                $table->boolean('login_successful')->default(false);
            }
            if (! $this->hasColumn('logout_at')) {
                $table->timestamp('logout_at')->nullable();
            }
            if (! $this->hasColumn('authenticatable_type')) {
                $table->uuidMorphs('authenticatable', 'k_authentications_morph');
            }

            $this->updateTimestamps($table, true);
        });
    }
};
