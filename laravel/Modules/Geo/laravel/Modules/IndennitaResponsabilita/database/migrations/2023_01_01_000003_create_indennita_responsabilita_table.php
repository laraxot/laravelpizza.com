<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = IndennitaResponsabilita::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->increments('id');
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('valutatore_id')) {
                    $table->integer('valutatore_id')->nullable();
                }
                if (! $this->hasColumn('note')) {
                    $table->text('note')->nullable();
                }
            }
        );
    }
};
