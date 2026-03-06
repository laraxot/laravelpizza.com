<?php

declare(strict_types=1);

use Illuminate\Database\Schema\Blueprint;
use Modules\Meetup\Models\Event;
use Modules\Xot\Database\Migrations\XotBaseMigration;

return new class extends XotBaseMigration
{
    protected ?string $model_class = Event::class;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $this->tableUpdate(function (Blueprint $table) {
            // First ensure user_id exists (required for organizer_id to work)
            if (! $this->hasColumn('user_id')) {
                // user_id should already exist via timestamps() in create_events_table
                // If it doesn't exist, add it after super_event_id
                $table->string('user_id', 36)->nullable()->index()->after('super_event_id');
            } else {
                // If user_id is bigint (from foreignIdFor), convert to string
                if ($this->getColumnType('user_id') === 'bigint') {
                    $table->string('user_id', 36)->nullable()->index()->change();
                }
            }

            // Now add organizer_id after user_id
            if (! $this->hasColumn('organizer_id')) {
                $table->string('organizer_id', 36)->nullable()->index()->after('user_id');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $this->tableUpdate(function (Blueprint $table) {
            if ($this->hasColumn('organizer_id')) {
                $table->dropColumn('organizer_id');
            }
        });
    }
};
