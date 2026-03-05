<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Support;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

trait EnsuresMeetupDatabaseSchema
{
    protected function ensureMeetupDatabaseSchema(): void
    {
        if (! Schema::connection('user')->hasTable('users')) {
            Schema::connection('user')->create('users', function (Blueprint $table): void {
                $table->string('id')->primary();
                $table->string('name')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->string('remember_token', 100)->nullable();
                $table->boolean('is_active')->default(true);
                $table->boolean('is_otp')->default(false);
                $table->string('lang')->nullable();
                $table->string('type')->nullable();
                $table->string('state')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::connection('meetup')->hasTable('events')) {
            Schema::connection('meetup')->create('events', function (Blueprint $table): void {
                $table->increments('id');
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
                $table->unsignedInteger('attendees_count')->default(0);
                $table->unsignedInteger('max_attendees')->default(100);
                $table->string('cover_image')->nullable();
                $table->string('url')->nullable();
                $table->json('offers')->nullable();
                $table->json('meta_data')->nullable();
                $table->string('user_id')->nullable();
                $table->string('organizer_id')->nullable();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::connection('meetup')->hasTable('performers')) {
            Schema::connection('meetup')->create('performers', function (Blueprint $table): void {
                $table->increments('id');
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

        if (! Schema::connection('meetup')->hasTable('profiles')) {
            Schema::connection('meetup')->create('profiles', function (Blueprint $table): void {
                $table->string('id')->primary();
                $table->string('user_id')->nullable();
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('fiscal_code')->nullable();
                $table->string('phone')->nullable();
                $table->string('email')->nullable();
                $table->text('notes')->nullable();
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::connection('meetup')->hasTable('event_user')) {
            Schema::connection('meetup')->create('event_user', function (Blueprint $table): void {
                $table->increments('id');
                $table->string('user_id')->nullable();
                $table->unsignedInteger('event_id')->nullable();
                $table->string('status')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::connection('meetup')->hasTable('event_performer')) {
            Schema::connection('meetup')->create('event_performer', function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('event_id')->nullable();
                $table->unsignedInteger('performer_id')->nullable();
                $table->string('name')->nullable();
                $table->string('type')->nullable();
                $table->string('role')->nullable();
                $table->unsignedInteger('order')->nullable();
                $table->timestamps();
            });
        }

        if (! Schema::connection('meetup')->hasTable('event_sponsor')) {
            Schema::connection('meetup')->create('event_sponsor', function (Blueprint $table): void {
                $table->increments('id');
                $table->unsignedInteger('event_id')->nullable();
                $table->string('name')->nullable();
                $table->string('level')->nullable();
                $table->timestamps();
            });
        }
    }
}
