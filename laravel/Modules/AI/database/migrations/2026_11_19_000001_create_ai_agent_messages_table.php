<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    protected ?string $table_name = 'ai_agent_messages';

    /**
     * Messaggi degli agenti neuron-ai (EloquentMessageStore): formato completo di neuron
     * (blocchi di contenuto, chiamate ai tool, metadati), che ai_messages non puo' contenere senza
     * perdere informazioni. `thread_id` = id della conversazione dell'agente (AiThread::public_id).
     * Chiave autoincrementale: neuron ordina il thread per chiave.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            $table->string('thread_id')->index();

            $table->string('message_id');

            $table->string('role', 32);

            $table->json('content')->nullable();

            $table->json('meta')->nullable();

            $table->timestamp('archived_at')->nullable();

            $table->unique(['thread_id', 'message_id']);

            $this->updateTimestamps($table);
        });
    }
};
