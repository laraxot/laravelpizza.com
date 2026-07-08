<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaCondizioniLavoro\Models\StabiDirigente;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateUploadsTable extends XotBaseMigration
{
    // protected ?string $model_class = StabiDirigente::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
                $table->integer('user_id')->nullable();
                $table->string('path')->nullable();
                $table->text('note')->nullable();
                $table->timestamps();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('quadrimestre')) {
                    $table->integer('quadrimestre')->nullable();
                }
                if (! $this->hasColumn('anno')) {
                    $table->integer('anno')->nullable();
                }

                // if (! $this->hasColumn('updated_by')) {
                //    $table->string('updated_by')->nullable();
                // }
            }
        );
    }
}
