<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/**
 * Migration to create the options table in the Ptv module.
 *
 * This table is used by the Option model to store hierarchical configuration
 * and evaluation options. It supports adjacency lists (parent_id) and
 * manual sorting (pos).
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
            function (Blueprint $table): void {
                $table->increments('id');
                $table->string('option_type')->nullable()->index();
                $table->integer('option_id')->nullable()->index();
                $table->bigInteger('parent_id')->nullable()->index();
                $table->integer('pos')->nullable()->index();
                $table->string('name')->nullable()->index();
                $table->string('value')->nullable();
                $table->integer('year')->nullable()->index();
                $table->string('txt')->nullable();
                $table->string('txt1')->nullable();

                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                // Future updates can be added here
            }
        );
    }
};
