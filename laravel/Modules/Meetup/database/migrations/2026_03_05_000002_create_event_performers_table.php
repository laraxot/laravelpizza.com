<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\EventPerformer;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = EventPerformer::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('event_id')->index();
            $table->uuid('performer_id')->index();
            $table->string('role')->nullable();
            $table->integer('sort_order')->nullable()->default(0);
            $this->updateTimestamps($table, true);
        });
    }
};
