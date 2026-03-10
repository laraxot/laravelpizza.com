<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
<<<<<<< HEAD
        $this->tableCreate(function (Blueprint $table): void {
=======
        $this->tableCreate(function (Blueprint $table) {
>>>>>>> 74e589dbb (.)
            $table->id();
            $table->string('uuid', 36)->nullable()->index();
            $table->string('email')->index();
            $table->string('token');
            // $table->timestamp('created_at')->nullable();
            $this->timestamps($table);
        });

        // -- UPDATE --
<<<<<<< HEAD
        $this->tableUpdate(function (Blueprint $table): void {
=======
        $this->tableUpdate(function (Blueprint $table) {
>>>>>>> 74e589dbb (.)
            // if (! $this->hasColumn('email'))
            //    $table->string('email')->nullable();
            // }
            // $this->updateUser($table);
            if ('uuid' === $this->getColumnType('id')) {
                $table->dropColumn('id');
            }
            if (! $this->hasColumn('id')) {
                $table->id();
            }
        });
    }
};
