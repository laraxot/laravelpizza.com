<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\IndennitaResponsabilita\Models\Message;
use Modules\Xot\Database\Migrations\XotBaseMigration;

class CreateIrMessageTable extends XotBaseMigration
{
    protected ?string $model_class = Message::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            static function (Blueprint $table): void {
                $table->id();
            }
        );

        // -- UPDATE --
        $this->tableUpdate(
            function (Blueprint $table): void {
                if (! $this->hasColumn('parent_id')) {
                    $table->unsignedBigInteger('parent_id')->nullable();
                }
            }
        );
    }
}
