<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\EventSponsor;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = EventSponsor::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('event_id')->index();
            $table->uuid('sponsor_id')->index();
            $table->string('sponsorship_details')->nullable();
            $this->updateTimestamps($table, true);
        });
    }
};
