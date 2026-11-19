<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    protected ?string $table_name = 'ai_knowledge_entries';

    /**
     * Base di conoscenza dell'assistente: coppie domanda/risposta verificate dal proprietario.
     *
     * `collection` separa le basi di conoscenza dei diversi progetti/clienti che usano il modulo
     * (es. `fixcity-faq`, `restaurant-shop-42`): il modulo AI non conosce i domini.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();

            $table->string('collection')->index();

            $table->text('question');

            $table->longText('answer');

            $table->json('tags')->nullable();

            $table->boolean('is_active')->default(true)->index();

            $this->updateTimestamps($table);
        });
    }
};
