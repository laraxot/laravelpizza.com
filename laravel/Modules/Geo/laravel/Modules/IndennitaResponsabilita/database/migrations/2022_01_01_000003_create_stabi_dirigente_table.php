<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaResponsabilita\Models\StabiDirigente;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = StabiDirigente::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('stabi')->nullable();
                $table->integer('repar')->nullable();
                $table->string('nome_stabi')->nullable();
                $table->integer('ente')->nullable();
                $table->integer('matr')->nullable();
                $table->string('nome_diri')->nullable();
                $table->string('nome_diri_plus')->nullable();
                $table->decimal('budget', 10, 3)->nullable();
                $table->integer('valutatore_id')->nullable();
                $table->integer('anno')->nullable();
                $table->nullableMorphs('post');
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('nome_diri_plus')) {
                    $table->string('nome_diri_plus')->nullable();
                }

                if (! $this->hasColumn('budget')) {
                    $table->decimal('budget', 10, 3)->nullable();
                }

                if (! $this->hasColumn('valutatore_id')) {
                    $table->integer('valutatore_id')->nullable();
                }
                if (! $this->hasColumn('email')) {
                    $table->string('email')->nullable();
                }
            }
        );
    }
};
