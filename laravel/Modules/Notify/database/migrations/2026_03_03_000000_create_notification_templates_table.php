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
        // @var mixed tableCreate(
            function (Blueprint $table): void {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('code')->index();
                $table->string('description')->nullable();
                $table->json('subject');
                $table->json('body_html')->nullable();
                $table->json('body_text')->nullable();
                $table->json('channels');
                $table->json('variables');
                $table->json('conditions')->nullable();
                $table->json('preview_data')->nullable();
                $table->json('metadata')->nullable();
                $table->string('category')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('version')->default(1);
                $table->string('tenant_id')->nullable();
                $table->json('grapesjs_data')->nullable();
                $table->string('type');

                $table->timestamps();
                $table->softDeletes();
                $table->string('updated_by')->nullable();
                $table->string('created_by')->nullable();
                $table->string('deleted_by')->nullable();
            }
        );
    }
};
