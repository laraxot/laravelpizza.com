<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration {
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
            $table->increments('id');
            $table->unsignedInteger('mail_template_id');
            $table->integer('version');
            $table->text('subject')->nullable();
            $table->longText('html_template');
            $table->longText('text_template')->nullable();
            $table->json('metadata')->nullable();
            $table->string('created_by')->nullable();
            $table->text('change_notes')->nullable();

            $table->foreign('mail_template_id')->references('id')->on('mail_templates')->onDelete('cascade');

            $table->unique(['mail_template_id', 'version']);
        });

        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, true);
        });
    }
};
