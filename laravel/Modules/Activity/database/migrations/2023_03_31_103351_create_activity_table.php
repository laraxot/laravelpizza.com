<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        $this->tableCreate(
            function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('log_name')->nullable();
                $table->text('description');
                $table->nullableMorphs('subject', 'subject');
                $table->nullableMorphs('causer', 'causer');
                $table->json('properties')->nullable();
                $table->index('log_name');
                $table->uuid('batch_uuid')->nullable();
                $table->string('event')->nullable();
            },
        );

        $this->tableUpdate(
            function (Blueprint $table) {
                // Assicuriamoci che causer_id sia nullable se esiste
                if ($this->hasColumn('causer_id')) {
                    $table->string('causer_id')->nullable()->change();
                }
                $this->updateTimestamps($table, true);
            },
        );
    }
};
