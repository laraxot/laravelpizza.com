<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateMov01k5Table.
 */
class CreateMov01k5Table extends XotBaseMigration
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
                $table->text('matr')->nullable();
                $table->text('mo1tip')->nullable();
                $table->text('mo1cod')->nullable();
                $table->text('mo1aa')->nullable();
                $table->text('mo1mm')->nullable();
                $table->text('mo1gg')->nullable();
                $table->text('mo1qta')->nullable();
                $table->text('mo1tmo')->nullable();
                $table->text('mo1all')->nullable();
                $table->text('mo1qtv')->nullable();
                $table->text('mo1um')->nullable();
                $table->text('mo1oi')->nullable();
                $table->text('mo1of')->nullable();
                $table->text('mo1ann')->nullable();
                $table->text('mov2kn')->nullable();
                $table->text('mov2kz')->nullable();
                $table->text('mov001')->nullable();
                $table->text('mov002')->nullable();
                $table->text('mov003')->nullable();
                $table->text('mov004')->nullable();
                $table->text('mov005')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('mov01k5');
    }
}
