<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Class CreateCoeffTable.
 */
return new class extends XotBaseMigration
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
                $table->decimal('gg_in_sede', 10, 3)->nullable();
                $table->decimal('gg_fuori_sede', 10, 3)->nullable();
                $table->decimal('gg_propro_in_sede', 10, 3)->nullable();
                $table->decimal('gg_propro_fuori_sede', 10, 3)->nullable();
                $table->decimal('gg_propro_posfun_in_sede', 10, 3)->nullable();
                $table->decimal('gg_propro_posfun_fuori_sede', 10, 3)->nullable();
                $table->decimal('gg_no_propro_posfun_in_sede', 10, 3)->nullable();
                $table->decimal('gg_no_propro_posfun_fuori_sede', 10, 3)->nullable();
                $table->integer('anno')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->softDeletes();
                $table->string('deleted_by')->nullable();
                $table->string('deleted_ip')->nullable();
                $table->string('created_ip')->nullable();
                $table->string('updated_ip')->nullable();
                $table->string('guid')->nullable();
            });
    }
};
