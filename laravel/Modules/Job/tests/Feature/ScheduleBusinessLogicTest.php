<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Illuminate\Support\Carbon;
use Modules\Job\Models\Schedule;
use Modules\Job\Models\ScheduleHistory;
use Modules\Job\Tests\TestCase;

uses(TestCase::class);

it('can create schedule with basic information', function () {
    $scheduleData = [
        'command' => 'backup:run',
        'expression' => '0 2 * * *',
        'even_in_maintenance_mode' => 0,
        'without_overlapping' => 1,
        'on_one_server' => 0,
        'log_success' => 1,
        'log_error' => 1,
        'status' => 1,
        'run_in_background' => 0,
    ];

    $schedule = Schedule::create($scheduleData);

    expect($schedule->command)->toBe('backup:run');
    expect($schedule->expression)->toBe('0 2 * * *');
    expect($schedule->even_in_maintenance_mode)->toBe(0);
    expect($schedule->without_overlapping)->toBe(1);
    expect($schedule->status)->toBe(1);
});

it('can manage schedule activation and deactivation', function () {
    $schedule = Schedule::create([
        'command' => 'test:command',
        'expression' => '0 * * * *',
        'status' => 1,
    ]);

    expect($schedule->status)->toBe(1);

    // Disattiva lo schedule
    $schedule->update([
        'status' => 0,
    ]);

    expect($schedule->status)->toBe(0);
});

it('can handle schedule cron expressions', function () {
    $dailySchedule = Schedule::create([
        'command' => 'daily:task',
        'expression' => '0 9 * * *',
        'status' => 1,
    ]);

    $weeklySchedule = Schedule::create([
        'command' => 'weekly:task',
        'expression' => '0 10 * * 1',
        'status' => 1,
    ]);

    $monthlySchedule = Schedule::create([
        'command' => 'monthly:task',
        'expression' => '0 8 1 * *',
        'status' => 1,
    ]);

    expect($dailySchedule->expression)->toBe('0 9 * * *');
    expect($weeklySchedule->expression)->toBe('0 10 * * 1');
    expect($monthlySchedule->expression)->toBe('0 8 1 * *');
});

it('can manage schedule execution settings', function () {
    $schedule = Schedule::create([
        'command' => 'limited:command',
        'expression' => '*/15 * * * *',
        'even_in_maintenance_mode' => 1,
        'without_overlapping' => 1,
        'on_one_server' => 1,
        'run_in_background' => 1,
    ]);

    expect($schedule->even_in_maintenance_mode)->toBe(1);
    expect($schedule->without_overlapping)->toBe(1);
    expect($schedule->on_one_server)->toBe(1);
    expect($schedule->run_in_background)->toBe(1);
});

it('can handle schedule history logging', function () {
    $schedule = Schedule::create([
        'command' => 'history:command',
        'expression' => '0 * * * *',
        'status' => 1,
    ]);

    // Crea cronologia esecuzioni
    $history1 = ScheduleHistory::create([
        'schedule_id' => $schedule->id,
        'created_at' => now()->subHour(),
        'updated_at' => now()->subHour(),
    ]);

    $history2 = ScheduleHistory::create([
        'schedule_id' => $schedule->id,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    expect($schedule->histories)->toHaveCount(2);
    expect($schedule->histories->contains($history1))->toBeTrue();
    expect($schedule->histories->contains($history2))->toBeTrue();
});

it('can manage schedule environments', function () {
    $schedule = Schedule::create([
        'command' => 'env:command',
        'expression' => '0 * * * *',
        'environments' => json_encode(['production', 'staging']),
        'status' => 1,
    ]);

    expect($schedule->environments)->toBeArray();
    expect($schedule->environments)->toContain(['production', 'staging']);
});

it('can handle schedule notifications', function () {
    $schedule = Schedule::create([
        'command' => 'notify:command',
        'expression' => '0 * * * *',
        'webhook_before' => 'https://webhook.example.com/before',
        'webhook_after' => 'https://webhook.example.com/after',
        'email_output' => 'admin@example.com',
        'sendmail_error' => 1,
        'sendmail_success' => 1,
        'status' => 1,
    ]);

    expect($schedule->webhook_before)->toBe('https://webhook.example.com/before');
    expect($schedule->webhook_after)->toBe('https://webhook.example.com/after');
    expect($schedule->email_output)->toBe('admin@example.com');
    expect($schedule->sendmail_error)->toBe(1);
    expect($schedule->sendmail_success)->toBe(1);
});

it('can handle schedule logging options', function () {
    $schedule = Schedule::create([
        'command' => 'log:command',
        'expression' => '0 * * * *',
        'log_success' => 1,
        'log_error' => 1,
        'log_filename' => 'custom_log_file.log',
        'status' => 1,
    ]);

    expect($schedule->log_success)->toBe(1);
    expect($schedule->log_error)->toBe(1);
    expect($schedule->log_filename)->toBe('custom_log_file.log');
});