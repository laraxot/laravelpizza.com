<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Incentivi\Models\CapitalPercentage;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = CapitalPercentage::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->string('nome');
                $table->string('descrizione');
                $table->decimal('valore');
                $table->timestamps();
            });

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('tipologia')) {
                    $table->string('tipologia');
                }
                if (! $this->hasColumn('da')) {
                    $table->decimal('da', 10, 3);
                }
                if (! $this->hasColumn('a')) {
                    $table->decimal('a', 10, 3);
                }

                $table->decimal('da', 12, 3)->change();
                $table->decimal('a', 12, 3)->change();

                $this->updateTimestamps($table);
            }
        );
    }
};
