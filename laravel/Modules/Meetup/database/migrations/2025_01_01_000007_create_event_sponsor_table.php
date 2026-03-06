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
        $this->tableCreate(function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('event_id')->index();
                $table->unsignedBigInteger('sponsor_id')->index();
                $table->json('sponsorship_details')->nullable();
                $table->unique(['event_id', 'sponsor_id']);
                $this->timestamps($table);
        });

        $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('event_id')) {
                    $table->unsignedBigInteger('event_id')->index()->after('id');
                }
                if (! $this->hasColumn('sponsor_id')) {
                    $table->unsignedBigInteger('sponsor_id')->index()->after('event_id');
                }
                if (! $this->hasColumn('sponsorship_details')) {
                    $table->json('sponsorship_details')->nullable()->after('sponsor_id');
                }
        });
    }
};
