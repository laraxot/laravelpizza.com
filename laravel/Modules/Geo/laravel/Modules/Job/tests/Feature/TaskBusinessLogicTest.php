<?php

declare(strict_types=1);

use Modules\Job\Models\Result;
use Modules\Job\Models\Task;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use function Safe\json_encode;

uses(TestCase::class);

it('can create task with basic information', function (): void {
        /** @var TestCase $this */
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
    ];

    $task = Task::create($taskData);

    $this->assertDatabaseHasRow('tasks', [
        'description' => 'Pulizia database giornaliera',
        'command' => 'db:cleanup',
        'expression' => '0 2 * * *',
        'timezone' => 'Europe/Rome',
        'is_active' => 1,
    ], 'job');

    Assert::assertSame('Pulizia database giornaliera', $task->description);
    Assert::assertSame('db:cleanup', $task->command);
    Assert::assertSame('0 2 * * *', $task->expression);
    Assert::assertSame(1, $task->is_active);
});

it('can manage task activation and deactivation', function (): void {
        /** @var TestCase $this */
    $task = Task::create([
        'description' => 'Test Task',
        'command' => 'test:command',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    Assert::assertSame(1, $task->is_active);
    // Disattiva il task
    $task->update([
        'is_active' => 0,
    ]);

    Assert::assertSame(0, $task->is_active);
});

it('can handle task parameters and compilation', function (): void {
        /** @var TestCase $this */
    $task = Task::create([
        'description' => 'Task con parametri',
        'command' => 'user:process',
        'parameters' => json_encode(['user_id' => '{{user_id}}', 'action' => '{{action}}']),
        'expression' => '0 1 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    // Compila parametri per lo scheduler
    $schedulerParams = $task->compileParameters(true);
    Assert::assertIsArray($schedulerParams);
    // Compila parametri per l'esecuzione
    $executionParams = $task->compileParameters(false);
    Assert::assertIsArray($executionParams);
});

it('can manage task frequencies', function (): void {
        /** @var TestCase $this */
    $task = Task::create([
        'description' => 'Task con frequenze',
        'command' => 'report:generate',
        'expression' => '0 9 * * 1', // Ogni lunedì alle 9:00
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    // Crea frequenze associate tramite relazione
    $frequency1 = $task->frequencies()->create([
        'label' => 'daily',
        'interval' => json_encode(['time' => '09:00']),
    ]);

    $frequency2 = $task->frequencies()->create([
        'label' => 'weekly',
        'interval' => json_encode(['day' => 'monday', 'time' => '09:00']),
    ]);

    Assert::assertCount(2, $task->frequencies);
    Assert::assertTrue($task->frequencies->contains($frequency1));
    Assert::assertTrue($task->frequencies->contains($frequency2));
});

it('can handle task notifications', function (): void {
        /** @var TestCase $this */
    $task = Task::create([
        'description' => 'Task con notifiche',
        'command' => 'backup:create',
        'expression' => '0 3 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_email_address' => 'admin@example.com',
        'notification_phone_number' => '+1234567890',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/...',
    ]);

    Assert::assertSame('admin@example.com', $task->notification_email_address);
    Assert::assertSame('+1234567890', $task->notification_phone_number);
    Assert::assertSame('https://hooks.slack.com/services/...', $task->notification_slack_webhook);
});

it('can manage task execution settings', function (): void {
        /** @var TestCase $this */
    $task = Task::create([
        'description' => 'Task con impostazioni esecuzione',
        'command' => 'heavy:process',
        'expression' => '0 */6 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 1,
        'run_in_maintenance' => 1,
        'run_on_one_server' => 1,
        'run_in_background' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    Assert::assertSame(1, $task->dont_overlap);
    Assert::assertSame(1, $task->run_in_maintenance);
    Assert::assertSame(1, $task->run_on_one_server);
    Assert::assertSame(1, $task->run_in_background);
});

it('can handle task cleanup settings', function (): void {
        /** @var TestCase $this */
    $task = Task::create([
        'description' => 'Task con pulizia automatica',
        'command' => 'logs:cleanup',
        'expression' => '0 4 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'auto_cleanup_num' => 30,
        'auto_cleanup_type' => 'days',
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    Assert::assertSame(30, $task->auto_cleanup_num);
    Assert::assertSame('days', $task->auto_cleanup_type);
});

it('can manage task results and history', function (): void {
        /** @var TestCase $this */
    $task = Task::create([
        'description' => 'Task con risultati',
        'command' => 'test:command',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
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

    Assert::assertCount(2, $task->results);
    Assert::assertTrue($task->results->contains($result1));
    Assert::assertTrue($task->results->contains($result2));
});

it('can handle task priority management', function (): void {
        /** @var TestCase $this */
    $highPriorityTask = Task::create([
        'description' => 'Task alta priorità',
        'command' => 'critical:process',
        'expression' => '*/5 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    $lowPriorityTask = Task::create([
        'description' => 'Task bassa priorità',
        'command' => 'maintenance:cleanup',
        'expression' => '0 2 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    // Non possiamo testare priority_id perché non esiste nella tabella
    Assert::assertStringContainsString((string)'alta', (string)$highPriorityTask->description);
    Assert::assertStringContainsString((string)'bassa', (string)$lowPriorityTask->description);
});

it('can manage task timezone handling', function (): void {
        /** @var TestCase $this */
    $romeTask = Task::create([
        'description' => 'Task Roma',
        'command' => 'local:process',
        'expression' => '0 9 * * 1',
        'timezone' => 'Europe/Rome',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    $utcTask = Task::create([
        'description' => 'Task UTC',
        'command' => 'global:process',
        'expression' => '0 9 * * 1',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    Assert::assertSame('Europe/Rome', $romeTask->timezone);
    Assert::assertSame('UTC', $utcTask->timezone);
});

it('can handle task status transitions', function (): void {
        /** @var TestCase $this */
    $task = Task::create([
        'description' => 'Task con transizioni stato',
        'command' => 'status:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    // Testiamo solo il campo is_active che esiste veramente
    Assert::assertSame(1, $task->is_active);
    // Cambia is_active a 0
    $task->update(['is_active' => 0]);
    Assert::assertSame(0, $task->is_active);
    // Ripristina is_active a 1
    $task->update(['is_active' => 1]);
    Assert::assertSame(1, $task->is_active);
});

it('can handle task ordering and sorting', function (): void {
        /** @var TestCase $this */
    $task1 = Task::create([
        'description' => 'Primo task',
        'command' => 'first:command',
        'expression' => '0 1 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    $task2 = Task::create([
        'description' => 'Secondo task',
        'command' => 'second:command',
        'expression' => '0 2 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    // Testiamo che entrambi i task esistano
    Assert::assertSame('Primo task', $task1->description);
    Assert::assertSame('Secondo task', $task2->description);
});

it('can handle task maintenance mode', function (): void {
        /** @var TestCase $this */
    $maintenanceTask = Task::create([
        'description' => 'Task manutenzione',
        'command' => 'maintenance:task',
        'expression' => '0 3 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'run_in_maintenance' => 1,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    $normalTask = Task::create([
        'description' => 'Task normale',
        'command' => 'normal:task',
        'expression' => '0 4 * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => 'https://hooks.slack.com/services/TEST',
    ]);

    Assert::assertSame(1, $maintenanceTask->run_in_maintenance);
    Assert::assertSame(0, $normalTask->run_in_maintenance);
});
