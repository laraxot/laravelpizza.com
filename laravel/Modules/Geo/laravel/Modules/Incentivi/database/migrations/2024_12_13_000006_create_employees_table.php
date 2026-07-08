<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Incentivi\Models\Employee;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Employee::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->integer('matricola')->nullable()->default(00000);
                $table->string('cognome');
                $table->string('nome');
                $table->string('sesso');
                $table->string('codice_fiscale')->nullable();
                $table->string('posizione_inail')->nullable();
                $table->string('tipologia');
                $table->timestamps();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('tipologia')) {
                    $table->string('tipologia');
                }
                if ($this->hasColumn('posizione_inail')) {
                    $table->string('posizione_inail')->nullable()->change();
                }
                if (! $this->hasColumn('tqu00f_desc1')) {
                    $table->string('tqu00f_desc1')->nullable();
                }
                if (! $this->hasColumn('tqu00f_desc2')) {
                    $table->string('tqu00f_desc2')->nullable();
                }

                // if ($this->hasColumn('matricola')) {
                //     $table->dropColumn('matricola');
                //     $table->integer('matricola')->nullable()->default(00000);
                // }
                // if ($this->hasColumn('codice_fiscale')) {
                //     $table->dropColumn('codice_fiscale');
                //     $table->string('codice_fiscale')->nullable();
                // }
                // if ($this->hasColumn('posizione_inail')) {
                //     $table->dropColumn('posizione_inail');
                //     $table->string('posizione_inail')->nullable();
                // }
                $this->updateTimestamps($table);
            }
        );
    }
};
