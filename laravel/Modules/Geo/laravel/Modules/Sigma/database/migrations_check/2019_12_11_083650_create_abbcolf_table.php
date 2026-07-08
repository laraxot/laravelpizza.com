<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAbbcolfTable.
 */
class CreateAbbcolfTable extends XotBaseMigration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('ente');
                $table->integer('emeen1');
                $table->char('emeli1', 10);
                $table->integer('emeen2');
                $table->char('emeli2', 10);
                $table->integer('emeen3');
                $table->char('emeli3', 10);
                $table->integer('emeen4');
                $table->char('emeli4', 10);
                $table->integer('emeen5');
                $table->char('emeli5', 10);
                $table->integer('emeen6');
                $table->char('emeli6', 10);
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('abbcolf');
    }
}
