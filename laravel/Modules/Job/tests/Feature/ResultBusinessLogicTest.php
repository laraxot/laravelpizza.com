<?php

declare(strict_types=1);

use Modules\Job\Models\Result;
use Modules\Job\Models\Task;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('can create result with basic information', function (): void {
    $task = Task::create([
        'description' => 'Test Task',
        'command' => 'test:command',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    $resultData = [
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '5.2',
        'result' => 'success',
    ];

    $result = Result::create($resultData);

    Assert::assertSame($task->id, $result->task_id);
    Assert::assertSame('success', $result->result);
    Assert::assertSame('5.2', $result->duration);
});

it('can manage result execution lifecycle', function (): void {
    $task = Task::create([
        'description' => 'Lifecycle Task',
        'command' => 'lifecycle:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    // Crea risultato
    $result = Result::create([
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '3.5',
        'result' => 'success',
    ]);

    Assert::assertSame('success', $result->result);
    Assert::assertSame('3.5', $result->duration);
});

it('can handle result relationships with task', function (): void {
    $task = Task::create([
        'description' => 'Relationship Task',
        'command' => 'relationship:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    // Crea risultati multipli per lo stesso task
    $result1 = Result::create([
        'task_id' => $task->id,
        'ran_at' => now()->subHour(),
        'duration' => '2.0',
        'result' => 'success',
    ]);

    $result2 = Result::create([
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '1.0',
        'result' => 'success',
    ]);

    Assert::assertCount(2, $task->results);
    Assert::assertTrue($task->results->contains($result1));
    Assert::assertTrue($task->results->contains($result2));
});

it('can manage result status variations', function (): void {
    $task = Task::create([
        'description' => 'Status Task',
        'command' => 'status:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    $result = Result::create([
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '1.2',
        'result' => 'failed',
    ]);

    Assert::assertSame('failed', $result->result);
    // Aggiorna risultato
    $result->update([
        'result' => 'success',
        'duration' => '2.5',
    ]);

    Assert::assertSame('success', $result->result);
    Assert::assertSame('2.5', $result->duration);
});

it('can handle result with different durations', function (): void {
    $task = Task::create([
        'description' => 'Duration Task',
        'command' => 'duration:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    $result = Result::create([
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '0.001',
        'result' => 'success',
    ]);

    Assert::assertSame('0.001', $result->duration);
});

it('can validate result data integrity', function (): void {
    $task = Task::create([
        'description' => 'Validation Task',
        'command' => 'validation:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    // Test con risultato valido
    $validResult = Result::create([
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '1.0',
        'result' => 'success',
    ]);

    Assert::assertNotNull($validResult->id);
    Assert::assertSame('1.0', $validResult->duration);
});

it('can manage multiple results for same task', function (): void {
    $task = Task::create([
        'description' => 'Batch Task',
        'command' => 'batch:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    // Crea un batch di risultati
    $results = [];
    $statuses = ['success', 'failed', 'success', 'success', 'failed'];

    for ($i = 1; $i <= 5; $i++) {
        $results[] = Result::create([
            'task_id' => $task->id,
            'ran_at' => now()->subMinutes($i),
            'duration' => (string) (0.5 * $i),
            'result' => $statuses[$i - 1],
        ]);
    }

    Assert::assertCount(5, $results);
    $taskFresh = $task->fresh();
    Assert::assertNotNull($taskFresh);
    $taskResults = $taskFresh->results;
    Assert::assertCount(5, $taskResults);
    $successCount = $taskResults->where('result', 'success')->count();
    $failedCount = $taskResults->where('result', 'failed')->count();

    Assert::assertSame(3, $successCount);
    Assert::assertSame(2, $failedCount);
});

it('can access task last result', function (): void {
    $task = Task::create([
        'description' => 'Last Result Task',
        'command' => 'last-result:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    // Crea risultati in sequenza
    Result::create([
        'task_id' => $task->id,
        'ran_at' => now()->subMinutes(2),
        'duration' => '1.0',
        'result' => 'success',
    ]);

    $latestResult = Result::create([
        'task_id' => $task->id,
        'ran_at' => now()->subMinute(),
        'duration' => '1.5',
        'result' => 'failed',
    ]);

    // Verifica che l'ultimo risultato sia quello atteso
    $taskWithLastResult = $task->fresh();
    Assert::assertNotNull($taskWithLastResult);
    $lastResult = $taskWithLastResult->last_result;
    Assert::assertNotNull($lastResult);
    Assert::assertSame($latestResult->id, $lastResult->id);
    Assert::assertSame('failed', $lastResult->result);
});

it('can calculate average runtime', function (): void {
    $task = Task::create([
        'description' => 'Average Runtime Task',
        'command' => 'avg-runtime:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    // Crea risultati con diversi tempi di esecuzione
    Result::create([
        'task_id' => $task->id,
        'ran_at' => now()->subMinutes(3),
        'duration' => '1.0',
        'result' => 'success',
    ]);

    Result::create([
        'task_id' => $task->id,
        'ran_at' => now()->subMinutes(2),
        'duration' => '2.0',
        'result' => 'success',
    ]);

    Result::create([
        'task_id' => $task->id,
        'ran_at' => now()->subMinute(),
        'duration' => '3.0',
        'result' => 'success',
    ]);

    // Verifica che il calcolo della media funzioni
    $taskWithAvg = $task->fresh();
    Assert::assertNotNull($taskWithAvg);
    Assert::assertGreaterThan(0, $taskWithAvg->average_runtime);
});

it('can handle result with empty values', function (): void {
    $task = Task::create([
        'description' => 'Empty Result Task',
        'command' => 'empty:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    $result = Result::create([
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '0.0',
        'result' => 'pending',
    ]);

    Assert::assertSame('0.0', $result->duration);
    Assert::assertSame('pending', $result->result);
});

it('can handle result with large duration', function (): void {
    $task = Task::create([
        'description' => 'Large Duration Task',
        'command' => 'large-duration:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    $result = Result::create([
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '3600.0', // 1 hour
        'result' => 'success',
    ]);

    Assert::assertSame('3600.0', $result->duration);
});

it('can manage result timestamps', function (): void {
    $task = Task::create([
        'description' => 'Timestamp Task',
        'command' => 'timestamp:test',
        'expression' => '0 * * * *',
        'timezone' => 'UTC',
        'is_active' => 1,
        'dont_overlap' => 0,
        'run_in_maintenance' => 0,
        'notification_slack_webhook' => '',
        'auto_cleanup_num' => 0,
        'run_on_one_server' => 0,
        'run_in_background' => 0,
    ]);

    $result = Result::create([
        'task_id' => $task->id,
        'ran_at' => now(),
        'duration' => '1.0',
        'result' => 'success',
    ]);

    Assert::assertNotNull($result->created_at);
    Assert::assertNotNull($result->updated_at);
});
