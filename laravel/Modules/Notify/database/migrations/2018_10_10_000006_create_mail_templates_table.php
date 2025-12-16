<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
// ----- bases ----
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateMailTemplatesTable.
 */
return new class() extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE -- Definizione iniziale della tabella
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('mailable');
            $table->string('slug')->unique();
            $table->json('subject')->nullable();
            $table->json('html_template')->nullable();
            $table->json('text_template')->nullable();
            $table->string('version')->default('1.0.0');
        });

        // -- UPDATE -- Aggiornamento della tabella esistente
        $this->tableUpdate(function (Blueprint $table): void {
            if (!$this->hasColumn('name')) {
                $table->string('name');
            }
            if (!$this->hasColumn('slug')) {
                $table->string('slug')->unique();
            }
            if (!$this->hasColumn('params')) {
                $table->text('params')->nullable();
            }
            if (!$this->hasColumn('sms_template')) {
                $table->json('sms_template')->nullable();
            }
            if (!$this->hasColumn('counter')) {
                $table->integer('counter')->default(0);
            }

            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
