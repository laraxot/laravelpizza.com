<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
// ----- models -----
use Modules\Rating\Datas\RatingData;
use Modules\Xot\Database\Migrations\XotBaseMigration;

/*
 * Class CreateRatingsTable.
 */
return new class extends XotBaseMigration
{
    /**
     * db up.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
                $table->string('title')->nullable();
                $table->string('slug')->nullable();
                $table->string('color')->nullable();
                $table->string('icon')->nullable();
                $table->string('rule')->nullable();
                $table->text('txt')->nullable();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                RatingData::updateColumns($table, $this);

                // `updateTimestamps()` resta qui e non dentro RatingData: in questa
                // migrazione il `tableCreate()` non dichiara i timestamp, quindi è
                // questa riga a crearli su un'installazione nuova. Le migrazioni degli
                // altri moduli li dichiarano in creazione e non ne hanno bisogno —
                // e' il motivo per cui l'helper condiviso non li impone a tutti.
                $this->updateTimestamps(table: $table, hasSoftDeletes: false);
            }
        );
    }
};
