<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\EventUser;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = EventUser::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableCreate(function (Blueprint $table): void {
                $table->id();
                $table->unsignedBigInteger('event_id')->index();
                $table->string('status')->default('attending')->index();
                $table->timestamp('registered_at')->nullable();
                $table->unique(['event_id', 'user_id']);
                $this->updateTimestamps(table: $table);
        });

        $this->tableUpdate(function (Blueprint $table): void {
                if (! $this->hasColumn('event_id')) {
                    $table->unsignedBigInteger('event_id')->index()->after('id');
                }
                if (! $this->hasColumn('status')) {
                    $table->string('status')->default('attending')->index()->after('user_id');
                }
                if (! $this->hasColumn('registered_at')) {
                    $table->timestamp('registered_at')->nullable()->after('status');
                }

                $this->updateTimestamps(table: $table);
        });
    }
};
