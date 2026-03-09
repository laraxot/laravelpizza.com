<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Meetup\Providers\MeetupServiceProvider;
use Modules\User\Providers\UserServiceProvider;
use Modules\Xot\Tests\XotBaseTestCase;

/**
 * Base test case for Meetup module.
 *
 * Extends XotBaseTestCase (DRY + KISS + Laraxot).
 */
abstract class TestCase extends XotBaseTestCase
{
    protected static bool $meetupSchemaBootstrapped = false;

    /** @var array<int, string> */
    protected array $connectionsToTransact = [
        'mysql',
        'meetup',
        'user',
    ];

    /**
     * @return array<int, class-string<\Illuminate\Support\ServiceProvider>>
     */
    protected function getPackageProviders($app): array
    {
        return [
            ...parent::getPackageProviders($app),
            UserServiceProvider::class,
            MeetupServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->ensureMeetupConnection();

        if (! self::$meetupSchemaBootstrapped) {
            $this->bootstrapMeetupTestingSchema();
            self::$meetupSchemaBootstrapped = true;
        }
    }

    private function ensureMeetupConnection(): void
    {
        if (config('database.connections.meetup') !== null) {
            return;
        }

        /** @var array<string, mixed>|null $mysqlConfig */
        $mysqlConfig = config('database.connections.mysql');
        if (! is_array($mysqlConfig)) {
            return;
        }

        config(['database.connections.meetup' => $mysqlConfig]);
    }

    private function bootstrapMeetupTestingSchema(): void
    {
        $userSchema = Schema::connection('user');
        if (! $userSchema->hasTable('users')) {
            $userSchema->create('users', function (Blueprint $table): void {
                $table->string('id', 36)->primary();
                $table->string('name')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->string('remember_token', 100)->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_otp')->default(false);
                $table->string('lang', 5)->default('it');
                $table->string('type')->default('customer_user');
                $table->string('state')->default('active');
                $table->timestamps();
            });
        }

        $schema = Schema::connection('meetup');

        if (! $schema->hasTable('events')) {
            $schema->create('events', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('title');
                $table->string('slug')->nullable();
                $table->text('description')->nullable();
                $table->string('in_language')->nullable();
                $table->dateTime('start_date')->nullable();
                $table->dateTime('end_date')->nullable();
                $table->string('location')->nullable();
                $table->unsignedBigInteger('location_id')->nullable();
                $table->string('status')->default('draft');
                $table->string('event_status')->default('EventScheduled');
                $table->string('event_attendance_mode')->default('OfflineEventAttendanceMode');
                $table->integer('attendees_count')->default(0);
                $table->integer('max_attendees')->default(100);
                $table->string('cover_image')->nullable();
                $table->string('url')->nullable();
                $table->json('offers')->nullable();
                $table->json('meta_data')->nullable();
                $table->string('user_id', 36)->nullable();
                $table->string('organizer_id', 36)->nullable();
                $table->string('created_by', 36)->nullable();
                $table->string('updated_by', 36)->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('performers')) {
            $schema->create('performers', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('type')->nullable();
                $table->text('bio')->nullable();
                $table->string('photo')->nullable();
                $table->string('website')->nullable();
                $table->string('email')->nullable();
                $table->string('company')->nullable();
                $table->string('twitter')->nullable();
                $table->string('linkedin')->nullable();
                $table->string('github')->nullable();
                $table->json('meta_data')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('sponsors')) {
            $schema->create('sponsors', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->string('name')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('profiles')) {
            $schema->create('profiles', function (Blueprint $table): void {
                $table->string('id', 36)->primary();
                $table->string('user_id', 36)->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('fiscal_code')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('event_user')) {
            $schema->create('event_user', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('event_id');
                $table->string('user_id', 36);
                $table->string('role')->nullable();
                $table->unsignedInteger('order')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('event_performer')) {
            $schema->create('event_performer', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('event_id');
                $table->unsignedBigInteger('performer_id');
                $table->string('role')->nullable();
                $table->unsignedInteger('order')->nullable();
                $table->timestamps();
            });
        }

        if (! $schema->hasTable('event_sponsor')) {
            $schema->create('event_sponsor', function (Blueprint $table): void {
                $table->bigIncrements('id');
                $table->unsignedBigInteger('event_id');
                $table->unsignedBigInteger('sponsor_id');
                $table->string('role')->nullable();
                $table->unsignedInteger('order')->nullable();
                $table->timestamps();
            });
        }
    }
}
