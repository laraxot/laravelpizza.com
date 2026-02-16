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
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('user_id', 36)->index()->nullable();
            $table->string('first_name')->nullable()->index();
            $table->string('last_name')->nullable()->index();
            $table->string('fiscal_code')->nullable()->index();
            $table->string('phone')->nullable();
            $table->string('email')->nullable()->index();
            $table->text('notes')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {

            if (in_array($this->getColumnType('id'), ['varchar'], strict: true)) {
                $table->id('id')->change();
            }

            if (in_array($this->getColumnType('user_id'), ['integer'], strict: true)) {
                $table->string('user_id', 36)->index()->nullable()->change();
            }

            $this->updateTimestamps(
                table: $table,
                hasSoftDeletes: true,
            );
        });
    }
};
