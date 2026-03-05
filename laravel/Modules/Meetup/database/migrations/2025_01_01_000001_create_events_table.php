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
        if (! $this->tableExists()) {
            $this->tableCreate(function (Blueprint $table) {
                $table->id();
                $table->string('title')->index();
                $table->string('slug')->unique();
                $table->string('alternate_name')->nullable();
                $table->text('description')->nullable();
                $table->string('in_language', 10)->default('it');
                $table->dateTime('start_date')->index();
                $table->dateTime('end_date')->index();
                $table->dateTime('start_at')->nullable()->index();
                $table->dateTime('end_at')->nullable()->index();
                $table->string('duration')->nullable();
                $table->string('location')->nullable();
                $table->unsignedBigInteger('location_id')->nullable()->index();
                $table->unsignedBigInteger('venue_id')->nullable()->index();
                $table->string('status')->default('draft')->index();
                $table->string('event_status')->default('EventScheduled')->index();
                $table->string('event_attendance_mode')->default('OfflineEventAttendanceMode')->index();
                $table->integer('attendees_count')->default(0);
                $table->integer('max_attendees')->default(100);
                $table->integer('attendees_current')->default(0);
                $table->integer('attendees_max')->default(100);
                $table->string('cover_image')->nullable();
                $table->string('url')->nullable();
                $table->json('offers')->nullable();
                $table->json('meta_data')->nullable();

                // Schema.org extras
                $table->dateTime('door_time')->nullable();
                $table->boolean('is_accessible_for_free')->default(true);
                $table->json('keywords')->nullable();
                $table->string('typical_age_range')->nullable();
                $table->string('audience')->nullable();
                $table->dateTime('previous_start_date')->nullable();
                $table->timestamp('registration_opens_at')->nullable();
                $table->string('registration_url')->nullable();

                // Scheduling
                $table->string('repeat_frequency')->nullable();
                $table->json('repeat_days')->nullable();
                $table->integer('repeat_count')->nullable();
                $table->dateTime('schedule_end_date')->nullable();
                $table->json('except_dates')->nullable();
                $table->string('schedule_timezone')->default('Europe/Rome');

                // Series
                $table->unsignedBigInteger('super_event_id')->nullable()->index();

                $this->timestamps($table);
            });
        } elseif ($this->hasColumn('title')) {
            $this->tableUpdate(function (Blueprint $table) {
                if (! $this->hasColumn('slug')) {
                    $table->string('slug')->unique()->after('title');
                }
                if (! $this->hasColumn('alternate_name')) {
                    $table->string('alternate_name')->nullable()->after('title');
                }
                if (! $this->hasColumn('in_language')) {
                    $table->string('in_language', 10)->default('it')->after('description');
                }
                if (! $this->hasColumn('start_at')) {
                    $table->dateTime('start_at')->nullable()->index()->after('end_date');
                }
                if (! $this->hasColumn('end_at')) {
                    $table->dateTime('end_at')->nullable()->index()->after('start_at');
                }
                if (! $this->hasColumn('venue_id')) {
                    $table->unsignedBigInteger('venue_id')->nullable()->index()->after('location_id');
                }
                if (! $this->hasColumn('event_status')) {
                    $table->string('event_status')->default('EventScheduled')->index()->after('status');
                }
                if (! $this->hasColumn('event_attendance_mode')) {
                    $table->string('event_attendance_mode')->default('OfflineEventAttendanceMode')->index()->after('event_status');
                }
                if (! $this->hasColumn('door_time')) {
                    $table->dateTime('door_time')->nullable()->after('meta_data');
                }
                if (! $this->hasColumn('is_accessible_for_free')) {
                    $table->boolean('is_accessible_for_free')->default(true)->after('door_time');
                }
                if (! $this->hasColumn('keywords')) {
                    $table->json('keywords')->nullable()->after('is_accessible_for_free');
                }
                if (! $this->hasColumn('typical_age_range')) {
                    $table->string('typical_age_range')->nullable()->after('keywords');
                }
                if (! $this->hasColumn('audience')) {
                    $table->string('audience')->nullable()->after('typical_age_range');
                }
                if (! $this->hasColumn('previous_start_date')) {
                    $table->dateTime('previous_start_date')->nullable()->after('audience');
                }
                if (! $this->hasColumn('registration_opens_at')) {
                    $table->timestamp('registration_opens_at')->nullable()->after('previous_start_date');
                }
                if (! $this->hasColumn('registration_url')) {
                    $table->string('registration_url')->nullable()->after('registration_opens_at');
                }
                if (! $this->hasColumn('attendees_current')) {
                    $table->integer('attendees_current')->default(0)->after('max_attendees');
                }
                if (! $this->hasColumn('attendees_max')) {
                    $table->integer('attendees_max')->default(100)->after('attendees_current');
                }
                if (! $this->hasColumn('repeat_frequency')) {
                    $table->string('repeat_frequency')->nullable()->after('previous_start_date');
                }
                if (! $this->hasColumn('repeat_days')) {
                    $table->json('repeat_days')->nullable()->after('repeat_frequency');
                }
                if (! $this->hasColumn('repeat_count')) {
                    $table->integer('repeat_count')->nullable()->after('repeat_days');
                }
                if (! $this->hasColumn('schedule_end_date')) {
                    $table->dateTime('schedule_end_date')->nullable()->after('repeat_count');
                }
                if (! $this->hasColumn('except_dates')) {
                    $table->json('except_dates')->nullable()->after('schedule_end_date');
                }
                if (! $this->hasColumn('schedule_timezone')) {
                    $table->string('schedule_timezone')->default('Europe/Rome')->after('except_dates');
                }
                if (! $this->hasColumn('super_event_id')) {
                    $table->unsignedBigInteger('super_event_id')->nullable()->index()->after('schedule_timezone');
                }
            });
        }
    }
};
