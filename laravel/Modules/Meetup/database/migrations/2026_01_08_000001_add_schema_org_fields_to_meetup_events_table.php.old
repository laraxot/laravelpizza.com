<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add Schema.org Event fields to meetup_events table.
 *
 * Implements Schema.org Event type properties for SEO and structured data.
 *
 * @see https://schema.org/Event
 * @see Modules/Meetup/docs/event-schema-org-implementation.md
 */
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('meetup_events', function (Blueprint $table): void {
            // High Priority Fields
            $table->string('event_status')
                ->default('EventScheduled')
                ->after('status')
                ->comment('Schema.org EventStatusType');

            $table->string('event_attendance_mode')
                ->default('OfflineEventAttendanceMode')
                ->after('event_status')
                ->comment('Schema.org EventAttendanceModeEnumeration');

            $table->string('url')->nullable()
                ->after('cover_image')
                ->comment('Public URL of event page');

            $table->unsignedBigInteger('organizer_id')->nullable()
                ->after('user_id')
                ->comment('Event organizer (Schema.org organizer property)');

            // Medium Priority Fields
            $table->json('offers')->nullable()
                ->after('meta_data')
                ->comment('Schema.org Offer - ticket/price info');

            $table->string('duration')->nullable()
                ->after('end_date')
                ->comment('ISO 8601 duration (e.g., PT2H for 2 hours)');

            $table->string('in_language', 10)->nullable()
                ->after('description')
                ->comment('ISO 639-1 language code (it, en)');

            $table->unsignedBigInteger('location_id')->nullable()
                ->after('location')
                ->comment('FK to places/venues table (Phase 2)');

            // Foreign Keys
            $table->foreign('organizer_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            // Indexes
            $table->index('event_status');
            $table->index('event_attendance_mode');
            $table->index('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('meetup_events', function (Blueprint $table): void {
            $table->dropForeign(['organizer_id']);
            $table->dropIndex(['event_status']);
            $table->dropIndex(['event_attendance_mode']);
            $table->dropIndex(['url']);

            $table->dropColumn([
                'event_status',
                'event_attendance_mode',
                'url',
                'organizer_id',
                'offers',
                'duration',
                'in_language',
                'location_id',
            ]);
        });
    }
};
