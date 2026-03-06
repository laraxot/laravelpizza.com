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
        if (! $this->tableExists()) {
            $this->tableCreate(function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('event_id')->index();
                $table->unsignedBigInteger('performer_id')->index();
                $table->string('role')->nullable();
                $table->unsignedInteger('order')->default(0);
                $table->unique(['event_id', 'performer_id']);
                $this->timestamps($table);
            });
        } else {
            $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('event_id')) {
                    $table->unsignedBigInteger('event_id')->index()->after('id');
                }
                if (! $this->hasColumn('performer_id')) {
                    $table->unsignedBigInteger('performer_id')->index()->after('event_id');
                }
                if (! $this->hasColumn('role')) {
                    $table->string('role')->nullable()->after('performer_id');
                }
                if (! $this->hasColumn('order')) {
                    $table->unsignedInteger('order')->default(0)->after('role');
                }
            });
        }
    }
};
