<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(function (Blueprint $table): void {
            $table->id();
            $table->string('post_type')->nullable();
            $table->integer('post_id')->nullable();
            $table->string('color')->nullable();
            $table->string('bg_color')->nullable();
            $table->integer('font_family')->nullable();
            $table->integer('font_style')->nullable();
            $table->integer('font_size')->nullable();
            $table->integer('y_grace')->nullable();
            $table->boolean('yaxis_hide')->default(false);
            $table->string('list_color')->nullable();
            $table->string('grace')->nullable();
            $table->string('x_label_angle')->nullable();
            $table->boolean('show_box')->default(false);
            $table->integer('x_label_margin')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('type')->nullable();
            $table->integer('plot_perc_width')->nullable();
            $table->boolean('plot_value_show')->default(false);
            $table->string('plot_value_format')->nullable();
            $table->integer('plot_value_pos')->nullable();
            $table->string('plot_value_color')->nullable();
            $table->string('group_by')->nullable();
            $table->string('sort_by')->nullable();
            $table->string('lang')->nullable();
            $table->string('transparency')->nullable();
            $table->json('colors')->nullable();
            $table->timestamps();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
        });

        // -- UPDATE --
        $this->tableUpdate(function (Blueprint $table): void {
            $this->updateTimestamps($table, true);
        });
    }
};