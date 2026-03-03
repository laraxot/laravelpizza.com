<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Modules\Job\Models\Schedule;
use Modules\Job\Models\ScheduleHistory;
use Modules\Job\Tests\TestCase;

uses(TestCase::class);

it('can create schedule with basic information', function (): void {
    $scheduleData = [
        'name' => 'Backup giornaliero',
        'description' => 'Backup automatico del database ogni giorno alle 2:00',
        'cron_expression' => '0 2 * * *',
        'timezone' => 'Europe/Rome',
        'is_active' => 1,
        'max_executions' => 1000,
        'retry_attempts' => 3,
        'retry_delay' => 300,
        'priority' => 'medium',
        'status' => 'active',
    ];

    $schedule = Schedule::create($scheduleData);

    $this->assertDatabaseHas('schedules', [
        'id' => $schedule->id,
        'name' => 'Backup giornaliero',
        'description' => 'Backup automatico del database ogni giorno alle 2:00',
        'cron_expression' => '0 2 * * *',
        'timezone' => 'Europe/Rome',
        'is_active' => 1,
    ]);

    expect($schedule->name)->toBe('Backup giornaliero');
    expect($schedule->cron_expression)->toBe('0 2 * * *');
    expect($schedule->timezone)->toBe('Europe/Rome');
    expect($schedule->is_active)->toBeTrue();
});

it('can manage schedule activation and deactivation', function (): void {
    $schedule = Schedule::create([
        'name' => 'Test Schedule',
        'description' => 'Test Description',
        'cron_expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    expect($schedule->is_active)->toBeTrue();
    expect($schedule->status)->toBe('active');

    // Disattiva lo schedule
    $schedule->update([
        'is_active' => 0,
        'status' => 'inactive',
    ]);

    expect($schedule->is_active)->toBeFalse();
    expect($schedule->status)->toBe('inactive');
});

it('can handle schedule cron expressions', function (): void {
    $dailySchedule = Schedule::create([
        'name' => 'Daily Schedule',
        'description' => 'Eseguito ogni giorno',
        'cron_expression' => '0 9 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    $weeklySchedule = Schedule::create([
        'name' => 'Weekly Schedule',
        'description' => 'Eseguito ogni lunedì',
        'cron_expression' => '0 10 * * 1',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    $monthlySchedule = Schedule::create([
        'name' => 'Monthly Schedule',
        'description' => 'Eseguito il primo del mese',
        'cron_expression' => '0 8 1 * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    expect($dailySchedule->cron_expression)->toBe('0 9 * * *');
    expect($weeklySchedule->cron_expression)->toBe('0 10 * * 1');
    expect($monthlySchedule->cron_expression)->toBe('0 8 1 * *');
});

it('can manage schedule execution limits', function (): void {
    $schedule = Schedule::create([
        'name' => 'Limited Schedule',
        'description' => 'Schedule con limiti di esecuzione',
        'cron_expression' => '*/15 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'max_executions' => 100,
        'retry_attempts' => 5,
        'retry_delay' => 600,
    ]);

    expect($schedule->max_executions)->toBe(100);
    expect($schedule->retry_attempts)->toBe(5);
    expect($schedule->retry_delay)->toBe(600);
});

it('can handle schedule priority management', function (): void {
    $highPrioritySchedule = Schedule::create([
        'name' => 'High Priority',
        'description' => 'Schedule alta priorità',
        'cron_expression' => '*/5 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'priority' => 'high',
    ]);

    $mediumPrioritySchedule = Schedule::create([
        'name' => 'Medium Priority',
        'description' => 'Schedule media priorità',
        'cron_expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'priority' => 'medium',
    ]);

    $lowPrioritySchedule = Schedule::create([
        'name' => 'Low Priority',
        'description' => 'Schedule bassa priorità',
        'cron_expression' => '0 2 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'priority' => 'low',
    ]);

    expect($highPrioritySchedule->priority)->toBe('high');
    expect($mediumPrioritySchedule->priority)->toBe('medium');
    expect($lowPrioritySchedule->priority)->toBe('low');
});

it('can manage schedule timezone handling', function (): void {
    $romeSchedule = Schedule::create([
        'name' => 'Rome Schedule',
        'description' => 'Schedule fuso orario Roma',
        'cron_expression' => '0 9 * * 1',
        'timezone' => 'Europe/Rome',
        'is_active' => 1,
        'status' => 'active',
    ]);

    $utcSchedule = Schedule::create([
        'name' => 'UTC Schedule',
        'description' => 'Schedule UTC',
        'cron_expression' => '0 9 * * 1',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    $tokyoSchedule = Schedule::create([
        'name' => 'Tokyo Schedule',
        'description' => 'Schedule fuso orario Tokyo',
        'cron_expression' => '0 9 * * 1',
        'timezone' => 'Asia/Tokyo',
        'is_active' => 1,
        'status' => 'active',
    ]);

    expect($romeSchedule->timezone)->toBe('Europe/Rome');
    expect($utcSchedule->timezone)->toBe('UTC');
    expect($tokyoSchedule->timezone)->toBe('Asia/Tokyo');
});

it('can handle schedule status transitions', function (): void {
    $schedule = Schedule::create([
        'name' => 'Status Test Schedule',
        'description' => 'Test transizioni stato',
        'cron_expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    expect($schedule->status)->toBe('active');

    // Cambia stato a pausa
    $schedule->update(['status' => 'paused']);
    expect($schedule->status)->toBe('paused');

    // Cambia stato a errore
    $schedule->update(['status' => 'error']);
    expect($schedule->status)->toBe('error');

    // Cambia stato a manutenzione
    $schedule->update(['status' => 'maintenance']);
    expect($schedule->status)->toBe('maintenance');

    // Ripristina stato attivo
    $schedule->update(['status' => 'active']);
    expect($schedule->status)->toBe('active');
});

it('can manage schedule history and logging', function (): void {
    $schedule = Schedule::create([
        'name' => 'History Test Schedule',
        'description' => 'Test cronologia esecuzioni',
        'cron_expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    // Crea cronologia esecuzioni
    $history1 = ScheduleHistory::create([
        'schedule_id' => $schedule->id,
        'executed_at' => now()->subHour(),
        'status' => 'success',
        'output' => 'Esecuzione completata con successo',
        'execution_time' => 5.2,
    ]);

    $history2 = ScheduleHistory::create([
        'schedule_id' => $schedule->id,
        'executed_at' => now(),
        'status' => 'running',
        'output' => 'Esecuzione in corso',
        'execution_time' => null,
    ]);

    expect($schedule->scheduleHistories)->toHaveCount(2);
    expect($schedule->scheduleHistories->contains($history1))->toBeTrue();
    expect($schedule->scheduleHistories->contains($history2))->toBeTrue();
});

it('can handle schedule retry logic', function (): void {
    $schedule = Schedule::create([
        'name' => 'Retry Test Schedule',
        'description' => 'Test logica retry',
        'cron_expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'retry_attempts' => 3,
        'retry_delay' => 300,
    ]);

    expect($schedule->retry_attempts)->toBe(3);
    expect($schedule->retry_delay)->toBe(300);

    // Simula fallimento e retry
    $schedule->update(['status' => 'failed']);
    expect($schedule->status)->toBe('failed');

    // Simula retry
    $schedule->update(['status' => 'retrying']);
    expect($schedule->status)->toBe('retrying');
});

it('can handle schedule execution tracking', function (): void {
    $schedule = Schedule::create([
        'name' => 'Execution Test Schedule',
        'description' => 'Test tracking esecuzioni',
        'cron_expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'max_executions' => 1000,
    ]);

    expect($schedule->max_executions)->toBe(1000);

    // Simula esecuzioni multiple
    for ($i = 1; $i <= 5; $i++) {
        ScheduleHistory::create([
            'schedule_id' => $schedule->id,
            'executed_at' => now()->subMinutes($i * 10),
            'status' => 'success',
            'output' => "Esecuzione {$i} completata",
            'execution_time' => rand(1, 10),
        ]);
    }

    expect($schedule->scheduleHistories)->toHaveCount(5);
});

it('can handle schedule validation and constraints', function (): void {
    // Schedule con espressione cron valida
    $validSchedule = Schedule::create([
        'name' => 'Valid Schedule',
        'description' => 'Schedule valido',
        'cron_expression' => '0 9 * * 1-5',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    expect($validSchedule->id)->not->toBeNull();

    // Schedule con espressione cron complessa
    $complexSchedule = Schedule::create([
        'name' => 'Complex Schedule',
        'description' => 'Schedule con espressione complessa',
        'cron_expression' => '0 9-17 * * 1-5',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
    ]);

    expect($complexSchedule->id)->not->toBeNull();
});

it('can handle schedule batch operations', function (): void {
    // Crea un batch di schedule
    $batchSchedules = [];
    $priorities = ['high', 'medium', 'low'];

    for ($i = 1; $i <= 3; $i++) {
        $batchSchedules[] = Schedule::create([
            'name' => "Batch Schedule {$i}",
            'description' => "Schedule batch numero {$i}",
            'cron_expression' => "0 {$i} * * *",
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
            'priority' => $priorities[$i - 1],
        ]);
    }

    expect($batchSchedules)->toHaveCount(3);

    foreach ($batchSchedules as $index => $schedule) {
        expect($schedule->name)->toBe('Batch Schedule '.($index + 1));
        expect($schedule->cron_expression)->toBe('0 '.($index + 1).' * * *');
        expect($schedule->priority)->toBe($priorities[$index]);
    }
});
