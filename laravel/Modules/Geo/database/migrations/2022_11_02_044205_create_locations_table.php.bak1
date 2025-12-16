<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Geo\Models\Location;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration {
    protected ?string $model_class = Location::class;

    public function up(): void
    {
        // -- CREATE --
        $this->tableCreate(
            function (Blueprint $table): void {
                $table->id();
                $table->nullableUuidMorphs('model');
                $table->string('name', 256)->nullable();
                $table->string('lat', 32)->nullable();
                $table->string('lng', 32)->nullable();
                $table->string('street')->nullable();
                $table->string('city')->nullable();
                $table->string('state')->nullable();
                $table->string('zip')->nullable();
                $table->string('formatted_address', 1024)->nullable();
                $table->text('description')->nullable();
                // $table->foreignId('state_id')->nullable()->constrained();
                $table->tinyInteger('processed')->nullable();
            }
        );
        $this->tableUpdate(
            function (Blueprint $table): void {
                // if (! $this->hasColumn('post_type')) {
                //    $blueprint->string('post_type', 50)->index()->nullable();
                // }
                $this->updateTimestamps($table, true);
            }
        );
    }
};
