<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateAgg00fTable.
 */
class CreateAgg00fTable extends XotBaseMigration
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
                $table->text('aggaa')->nullable();
                $table->text('aggtc')->nullable();
                $table->text('mid01')->nullable();
                $table->text('mid02')->nullable();
                $table->text('mid03')->nullable();
                $table->text('mid04')->nullable();
                $table->text('mid05')->nullable();
                $table->text('mid06')->nullable();
                $table->text('mid07')->nullable();
                $table->text('mid08')->nullable();
                $table->text('mid09')->nullable();
                $table->text('mid10')->nullable();
                $table->text('mid11')->nullable();
                $table->text('mid12')->nullable();
                $table->text('mie01')->nullable();
                $table->text('mie02')->nullable();
                $table->text('mie03')->nullable();
                $table->text('mie04')->nullable();
                $table->text('mie05')->nullable();
                $table->text('mie06')->nullable();
                $table->text('mie07')->nullable();
                $table->text('mie08')->nullable();
                $table->text('mie09')->nullable();
                $table->text('mie10')->nullable();
                $table->text('mie11')->nullable();
                $table->text('mie12')->nullable();
                $table->text('tid')->nullable();
                $table->text('tie')->nullable();
                $table->text('tideu')->nullable();
                $table->text('tieeu')->nullable();
                $table->text('mld01')->nullable();
                $table->text('mld02')->nullable();
                $table->text('mld03')->nullable();
                $table->text('mld04')->nullable();
                $table->text('mld05')->nullable();
                $table->text('mld06')->nullable();
                $table->text('mld07')->nullable();
                $table->text('mld08')->nullable();
                $table->text('mld09')->nullable();
                $table->text('mld10')->nullable();
                $table->text('mld11')->nullable();
                $table->text('mld12')->nullable();
                $table->text('tld')->nullable();
                $table->text('tldeu')->nullable();
                $table->text('tmm')->nullable();
                $table->text('tle')->nullable();
                $table->text('tleeu')->nullable();
                $table->text('ted')->nullable();
                $table->text('tee')->nullable();
                $table->text('tedeu')->nullable();
                $table->text('teeeu')->nullable();
                $table->text('tcd')->nullable();
                $table->text('tce')->nullable();
                $table->text('tcdeu')->nullable();
                $table->text('tceeu')->nullable();
            });
    }

    /**
     * Reverse the migrations.
     */
    #[Override]
    public function down(): void
    {
        Schema::drop('agg00f');
    }
}
