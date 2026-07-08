<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateValo1l1Table.
 */
class CreateValo1l1Table extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->integer('id', true);
                $table->text('ente')->nullable();
                $table->text('cont')->nullable();
                $table->text('va1rap')->nullable();
                $table->text('va1ora')->nullable();
                $table->text('va12kd')->nullable();
                $table->text('va12ka')->nullable();
                $table->text('va1o')->nullable();
                $table->text('va1g')->nullable();
                $table->text('va1s')->nullable();
                $table->text('va1m')->nullable();
                $table->text('va1ann')->nullable();
                $table->text('va1001')->nullable();
                $table->text('va1002')->nullable();
                $table->text('va1003')->nullable();
                $table->text('va1004')->nullable();
                $table->text('va1005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('valo1l1');
    }
}
