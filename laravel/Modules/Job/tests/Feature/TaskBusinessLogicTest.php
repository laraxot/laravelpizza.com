<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Modules\Job\Models\Frequency;
use Modules\Job\Models\Result;
use Modules\Job\Models\Task;
use Modules\Job\Tests\TestCase;

uses(TestCase::class);

it('can create task with basic information', function (): void
{
    $taskData = [
        'description' => 'Pulizia database giornaliera',
        'command' => 'db:cleanup',
        'parameters' => '--days=30 --tables=logs,sessions',
        'expression' => '0 2 * * *', // Ogni giorno alle 2:00
        'timezone' => 'Europe/Rome',
        'is_active' => 1,
        'dont_overlap' => 1,
        'run_in_maintenance' => 0,
        'notification_email_address' => 'admin@example.com',
        'notification_phone_number' => '+1234567890',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
        'run_on_one_server' => 1,
        'run_in_background' => 1,
        'auto_cleanup_num' => 7,
        'auto_cleanup_type' => 'days',
        'priority_id' => 'high',
        'status' => 'active',
    ];

    $task = Task::create($taskData);

    $this->assertDatabaseHas('tasks', [
        'description' => 'Pulizia database giornaliera',
        'command' => 'db:cleanup',
        'expression' => '0 2 * * *',
        'timezone' => 'Europe/Rome',
        'is_active' => 1,
    ], 'job');

    expect($task->description)->toBe('Pulizia database giornaliera');
    expect($task->command)->toBe('db:cleanup');
    expect($task->expression)->toBe('0 2 * * *');
    expect($task->is_active)->toBeTrue();
});

it('can manage task activation and deactivation', function (): void
{
    $task = Task::create([
        'description' => 'Test Task',
        'command' => 'test:command',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    expect($task->is_active)->toBeTrue();
    expect($task->status)->toBe('active');

    // Disattiva il task
    $task->update([
        'is_active' => 0,
        'status' => 'inactive',
    ]);

    expect($task->is_active)->toBeFalse();
    expect($task->status)->toBe('inactive');
});

it('can handle task parameters and compilation', function (): void
{
    $task = Task::create([
        'description' => 'Task con parametri',
        'command' => 'user:process',
        'parameters' => '--user-id={{user_id}} --action={{action}}',
        'expression' => '0 1 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    // Compila parametri per lo scheduler
    $schedulerParams = $task->compileParameters(true);
    expect($schedulerParams)->toBe('--user-id={{user_id}} --action={{action}}');

    // Compila parametri per l'esecuzione
    $executionParams = $task->compileParameters(false);
    expect($executionParams)->toBe('--user-id={{user_id}} --action={{action}}');
});

it('can manage task frequencies', function (): void
{
    $task = Task::create([
        'description' => 'Task con frequenze',
        'command' => 'report:generate',
        'expression' => '0 9 * * 1', // Ogni lunedì alle 9:00
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    // Crea frequenze associate
    $frequency1 = Frequency::create([
        'task_id' => $task->id,
        'frequency' => 'daily',
        'parameters' => json_encode(['time' => '09:00']),
    ]);

    $frequency2 = Frequency::create([
        'task_id' => $task->id,
        'frequency' => 'weekly',
        'parameters' => json_encode(['day' => 'monday', 'time' => '09:00']),
    ]);

    expect($task->frequencies)->toHaveCount(2);
    expect($task->frequencies->contains($frequency1))->toBeTrue();
    expect($task->frequencies->contains($frequency2))->toBeTrue();
});

it('can handle task notifications', function (): void
{
    $task = Task::create([
        'description' => 'Task con notifiche',
        'command' => 'backup:create',
        'expression' => '0 3 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'notification_email_address' => 'admin@example.com',
        'notification_phone_number' => '+1234567890',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/...',
    ]);

    expect($task->notification_email_address)->toBe('admin@example.com');
    expect($task->notification_phone_number)->toBe('+1234567890');
    expect($task->notification_slack_webhook)->toBe('https://hooks.slack.com/services/...');
});

it('can manage task execution settings', function (): void
{
    $task = Task::create([
        'description' => 'Task con impostazioni esecuzione',
        'command' => 'heavy:process',
        'expression' => '0 */6 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'dont_overlap' => 1,
        'run_in_maintenance' => 1,
        'run_on_one_server' => 1,
        'run_in_background' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    expect($task->dont_overlap)->toBeTrue();
    expect($task->run_in_maintenance)->toBeTrue();
    expect($task->run_on_one_server)->toBeTrue();
    expect($task->run_in_background)->toBeTrue();
});

it('can handle task cleanup settings', function (): void
{
    $task = Task::create([
        'description' => 'Task con pulizia automatica',
        'command' => 'logs:cleanup',
        'expression' => '0 4 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'auto_cleanup_num' => 30,
        'auto_cleanup_type' => 'days',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    expect($task->auto_cleanup_num)->toBe(30);
    expect($task->auto_cleanup_type)->toBe('days');
});

it('can manage task results and history', function (): void
{
    $task = Task::create([
        'description' => 'Task con risultati',
        'command' => 'test:command',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    // Crea risultati associati
    $result1 = Result::create([
        'task_id' => $task->id,
        'started_at' => now()->subHour(),
        'finished_at' => now()->subHour()->addMinutes(5),
        'result' => 'success',
        'output' => 'Task completato con successo',
    ]);

    $result2 = Result::create([
        'task_id' => $task->id,
        'started_at' => now(),
        'finished_at' => null,
        'result' => 'running',
        'output' => 'Task in esecuzione',
    ]);

    expect($task->results)->toHaveCount(2);
    expect($task->results->contains($result1))->toBeTrue();
    expect($task->results->contains($result2))->toBeTrue();
});

it('can handle task priority management', function (): void
{
    $highPriorityTask = Task::create([
        'description' => 'Task alta priorità',
        'command' => 'critical:process',
        'expression' => '*/5 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'priority_id' => 'high',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    $lowPriorityTask = Task::create([
        'description' => 'Task bassa priorità',
        'command' => 'maintenance:cleanup',
        'expression' => '0 2 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'priority_id' => 'low',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    expect($highPriorityTask->priority_id)->toBe('high');
    expect($lowPriorityTask->priority_id)->toBe('low');
});

it('can manage task timezone handling', function (): void
{
    $romeTask = Task::create([
        'description' => 'Task Roma',
        'command' => 'local:process',
        'expression' => '0 9 * * 1',
        'timezone' => 'Europe/Rome',
        'is_active' => 1,
        'status' => 'active',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    $utcTask = Task::create([
        'description' => 'Task UTC',
        'command' => 'global:process',
        'expression' => '0 9 * * 1',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    expect($romeTask->timezone)->toBe('Europe/Rome');
    expect($utcTask->timezone)->toBe('UTC');
});

it('can handle task status transitions', function (): void
{
    $task = Task::create([
        'description' => 'Task con transizioni stato',
        'command' => 'status:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    expect($task->status)->toBe('active');

    // Cambia stato a pausa
    $task->update(['status' => 'paused']);
    expect($task->status)->toBe('paused');

    // Cambia stato a errore
    $task->update(['status' => 'error']);
    expect($task->status)->toBe('error');

    // Ripristina stato attivo
    $task->update(['status' => 'active']);
    expect($task->status)->toBe('active');
});

it('can handle task ordering and sorting', function (): void
{
    $task1 = Task::create([
        'description' => 'Primo task',
        'command' => 'first:command',
        'expression' => '0 1 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'order_column' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    $task2 = Task::create([
        'description' => 'Secondo task',
        'command' => 'second:command',
        'expression' => '0 2 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'order_column' => 2,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    expect($task1->order_column)->toBe(1);
    expect($task2->order_column)->toBe(2);
});

it('can handle task maintenance mode', function (): void
{
    $maintenanceTask = Task::create([
        'description' => 'Task manutenzione',
        'command' => 'maintenance:task',
        'expression' => '0 3 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'run_in_maintenance' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    $normalTask = Task::create([
        'description' => 'Task normale',
        'command' => 'normal:task',
        'expression' => '0 4 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'status' => 'active',
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    expect($maintenanceTask->run_in_maintenance)->toBeTrue();
    expect($normalTask->run_in_maintenance)->toBeFalse();
});
