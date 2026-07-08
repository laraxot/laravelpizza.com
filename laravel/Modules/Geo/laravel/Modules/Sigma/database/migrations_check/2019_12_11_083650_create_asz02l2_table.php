<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAsz02l2Table.
 */
class CreateAsz02l2Table extends XotBaseMigration
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
                $table->text('as2tip')->nullable();
                $table->text('as2cod')->nullable();
                $table->text('as2dat')->nullable();
                $table->text('as2an')->nullable();
                $table->text('as2me')->nullable();
                $table->text('as2gg')->nullable();
                $table->text('as2qta')->nullable();
                $table->text('as2qtv')->nullable();
                $table->text('as2umi')->nullable();
                $table->text('as2lir')->nullable();
                $table->text('as2ri1')->nullable();
                $table->text('as2ri2')->nullable();
                $table->text('as2ri3')->nullable();
                $table->text('as2ri4')->nullable();
                $table->text('as2ri5')->nullable();
                $table->text('as2tim')->nullable();
                $table->text('as2pro')->nullable();
                $table->text('as2001')->nullable();
                $table->text('as2002')->nullable();
                $table->text('as2003')->nullable();
                $table->text('as2004')->nullable();
                $table->text('as2005')->nullable();
                $table->text('as2ann')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('asz02l2');
    }
}
