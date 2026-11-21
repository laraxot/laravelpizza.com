<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    /**
     * Table name following Laraxot philosophy.
     */
    protected ?string $table_name = 'ai_messages';

    /**
     * Run the migration following AI module naming standards.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            $table->foreignId('ai_thread_id')->constrained('ai_threads')->cascadeOnDelete();

            $table->string('user_id', 36)->nullable()->index();

            $table->string('role');

            $table->longText('content')->nullable();

            $table->json('payload')->nullable();

            $this->updateTimestamps($table);
        });

        // Id utente come stringa: gli utenti Laraxot hanno UUID; vale anche per id numerici. Nullable: utenti anonimi.
        $this->tableUpdate(function (Blueprint $table): void {
            if ($this->hasColumn('user_id')) {
                $table->string('user_id', 36)->nullable()->change();
            }
        });
    }
};
