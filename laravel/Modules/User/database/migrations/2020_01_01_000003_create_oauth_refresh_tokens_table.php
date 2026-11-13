<?php

declare(strict_types=1);
use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->string('id', 100)->primary();
            // Stringa come `oauth_access_tokens.id` (id Passport di 80 caratteri). foreignIdFor() su un
            // model con chiave stringa crea una colonna uuid (36) e tronca l'id del token.
            $table->string('access_token_id', 100)->index();
            $table->boolean('revoked');
            $table->dateTime('expires_at')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            // if (! $this->hasColumn('email'))
            //    $table->string('email')->nullable();
            // }
            $this->updateUser($table);
        });
    }
};
