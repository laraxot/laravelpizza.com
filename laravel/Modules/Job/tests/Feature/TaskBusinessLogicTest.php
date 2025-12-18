<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Modules\Job\Models\Frequency;
use Modules\Job\Models\Result;
use Modules\Job\Models\Task;
use Tests\TestCase;

class TaskBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_task_with_basic_information(): void
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
            'run_on_one_server' => 1,
            'run_in_background' => 1,
            'auto_cleanup_num' => 7,
            'auto_cleanup_type' => 'days',
            'priority_id' => 'high',
            'status' => 'active',
        ];

        $task = Task::create($taskData);

        $this->assertDatabaseHas('tasks', [
            'id' => $task->id,
            'description' => 'Pulizia database giornaliera',
            'command' => 'db:cleanup',
            'expression' => '0 2 * * *',
            'timezone' => 'Europe/Rome',
            'is_active' => 1,
        ]);

        $this->assertEquals('Pulizia database giornaliera', $task->description);
        $this->assertEquals('db:cleanup', $task->command);
        $this->assertEquals('0 2 * * *', $task->expression);
        $this->assertTrue($task->is_active);
    }

    /** @test */
    public function it_can_manage_task_activation_and_deactivation(): void
    {
        $task = Task::create([
            'description' => 'Test Task',
            'command' => 'test:command',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $this->assertTrue($task->is_active);
        $this->assertEquals('active', $task->status);

        // Disattiva il task
        $task->update([
            'is_active' => 0,
            'status' => 'inactive',
        ]);

        $this->assertFalse($task->is_active);
        $this->assertEquals('inactive', $task->status);
    }

    /** @test */
    public function it_can_handle_task_parameters_and_compilation(): void
    {
        $task = Task::create([
            'description' => 'Task con parametri',
            'command' => 'user:process',
            'parameters' => '--user-id={{user_id}} --action={{action}}',
            'expression' => '0 1 * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        // Compila parametri per lo scheduler
        $schedulerParams = $task->compileParameters(true);
        $this->assertEquals('--user-id={{user_id}} --action={{action}}', $schedulerParams);

        // Compila parametri per l'esecuzione
        $executionParams = $task->compileParameters(false);
        $this->assertEquals('--user-id={{user_id}} --action={{action}}', $executionParams);
    }

    /** @test */
    public function it_can_manage_task_frequencies(): void
    {
        $task = Task::create([
            'description' => 'Task con frequenze',
            'command' => 'report:generate',
            'expression' => '0 9 * * 1', // Ogni lunedì alle 9:00
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
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

        $this->assertCount(2, $task->frequencies);
        $this->assertTrue($task->frequencies->contains($frequency1));
        $this->assertTrue($task->frequencies->contains($frequency2));
    }

    /** @test */
    public function it_can_handle_task_notifications(): void
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

        $this->assertEquals('admin@example.com', $task->notification_email_address);
        $this->assertEquals('+1234567890', $task->notification_phone_number);
        $this->assertEquals('https://hooks.slack.com/services/...', $task->notification_slack_webhook);
    }

    /** @test */
    public function it_can_manage_task_execution_settings(): void
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
        ]);

        $this->assertTrue($task->dont_overlap);
        $this->assertTrue($task->run_in_maintenance);
        $this->assertTrue($task->run_on_one_server);
        $this->assertTrue($task->run_in_background);
    }

    /** @test */
    public function it_can_handle_task_cleanup_settings(): void
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
        ]);

        $this->assertEquals(30, $task->auto_cleanup_num);
        $this->assertEquals('days', $task->auto_cleanup_type);
    }

    /** @test */
    public function it_can_manage_task_results_and_history(): void
    {
        $task = Task::create([
            'description' => 'Task con risultati',
            'command' => 'test:command',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
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

        $this->assertCount(2, $task->results);
        $this->assertTrue($task->results->contains($result1));
        $this->assertTrue($task->results->contains($result2));
    }

    /** @test */
    public function it_can_handle_task_priority_management(): void
    {
        $highPriorityTask = Task::create([
            'description' => 'Task alta priorità',
            'command' => 'critical:process',
            'expression' => '*/5 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
            'priority_id' => 'high',
        ]);

        $lowPriorityTask = Task::create([
            'description' => 'Task bassa priorità',
            'command' => 'maintenance:cleanup',
            'expression' => '0 2 * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
            'priority_id' => 'low',
        ]);

        $this->assertEquals('high', $highPriorityTask->priority_id);
        $this->assertEquals('low', $lowPriorityTask->priority_id);
    }

    /** @test */
    public function it_can_manage_task_timezone_handling(): void
    {
        $romeTask = Task::create([
            'description' => 'Task Roma',
            'command' => 'local:process',
            'expression' => '0 9 * * 1',
            'timezone' => 'Europe/Rome',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $utcTask = Task::create([
            'description' => 'Task UTC',
            'command' => 'global:process',
            'expression' => '0 9 * * 1',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $this->assertEquals('Europe/Rome', $romeTask->timezone);
        $this->assertEquals('UTC', $utcTask->timezone);
    }

    /** @test */
    public function it_can_handle_task_status_transitions(): void
    {
        $task = Task::create([
            'description' => 'Task con transizioni stato',
            'command' => 'status:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $this->assertEquals('active', $task->status);

        // Cambia stato a pausa
        $task->update(['status' => 'paused']);
        $this->assertEquals('paused', $task->status);

        // Cambia stato a errore
        $task->update(['status' => 'error']);
        $this->assertEquals('error', $task->status);

        // Ripristina stato attivo
        $task->update(['status' => 'active']);
        $this->assertEquals('active', $task->status);
    }

    /** @test */
    public function it_can_handle_task_ordering_and_sorting(): void
    {
        $task1 = Task::create([
            'description' => 'Primo task',
            'command' => 'first:command',
            'expression' => '0 1 * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
            'order_column' => 1,
        ]);

        $task2 = Task::create([
            'description' => 'Secondo task',
            'command' => 'second:command',
            'expression' => '0 2 * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
            'order_column' => 2,
        ]);

        $this->assertEquals(1, $task1->order_column);
        $this->assertEquals(2, $task2->order_column);
    }

    /** @test */
    public function it_can_handle_task_maintenance_mode(): void
    {
        $maintenanceTask = Task::create([
            'description' => 'Task manutenzione',
            'command' => 'maintenance:task',
            'expression' => '0 3 * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
            'run_in_maintenance' => 1,
        ]);

        $normalTask = Task::create([
            'description' => 'Task normale',
            'command' => 'normal:task',
            'expression' => '0 4 * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
            'run_in_maintenance' => 0,
        ]);

        $this->assertTrue($maintenanceTask->run_in_maintenance);
        $this->assertFalse($normalTask->run_in_maintenance);
    }
}
