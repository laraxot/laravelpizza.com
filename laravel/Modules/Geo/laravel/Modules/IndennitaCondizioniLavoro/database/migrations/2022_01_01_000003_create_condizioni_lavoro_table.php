<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateCondizioniLavoroTable extends XotBaseMigration
{
    // protected ?string $model_class = StabiDirigente::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('updated_at')) {
                    $table->timestamps();
                }

                if (! $this->hasColumn('created_by')) {
                    $table->string('created_by')->nullable();
                }

                if (! $this->hasColumn('updated_by')) {
                    $table->string('updated_by')->nullable();
                }

                if (! $this->hasColumn('valutatore_id')) {
                    $table->integer('valutatore_id')->nullable();
                }

                if (! $this->hasColumn('quadrimestre')) {
                    $table->integer('quadrimestre')->nullable();
                }
            }
        );
    }
}
