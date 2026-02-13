<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class() extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(static function (Blueprint $table): void {
            $table->id();
            $table->string('command');
            $table->string('command_custom')->nullable()->default(null);
            $table->text('params')->nullable();
            $table->string('expression');
            $table->string('environments')->nullable();
            $table->text('options')->nullable();
            $table->text('options_with_value')->nullable();
            $table->string('log_filename')->nullable();
            $table->boolean('even_in_maintenance_mode')->default(false);
            $table->boolean('without_overlapping')->default(false);
            $table->boolean('on_one_server')->default(false);
            $table->string('webhook_before')->nullable();
            $table->string('webhook_after')->nullable();
            $table->string('email_output')->nullable();
            $table->boolean('sendmail_error')->default(false);
            $table->boolean('log_success')->default(true);
            $table->boolean('log_error')->default(true);
            $table->boolean('status')->default(true);
            $table->boolean('run_in_background')->default(false);
            $table->boolean('sendmail_success')->default(false);

            $table->softDeletes();
        });
        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
