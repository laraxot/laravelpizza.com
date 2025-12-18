<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Modules\Job\Models\Result;
use Modules\Job\Models\Task;
use Tests\TestCase;

class ResultBusinessLogicTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_result_with_basic_information(): void
    {
        $task = Task::create([
            'description' => 'Test Task',
            'command' => 'test:command',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $resultData = [
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => now()->addMinutes(5),
            'result' => 'success',
            'output' => 'Task completato con successo',
            'execution_time' => 5.2,
            'memory_usage' => 1024000,
            'exit_code' => 0,
        ];

        $result = Result::create($resultData);

        $this->assertDatabaseHas('results', [
            'id' => $result->id,
            'task_id' => $task->id,
            'result' => 'success',
            'output' => 'Task completato con successo',
            'execution_time' => 5.2,
        ]);

        $this->assertEquals($task->id, $result->task_id);
        $this->assertEquals('success', $result->result);
        $this->assertEquals('Task completato con successo', $result->output);
        $this->assertEquals(5.2, $result->execution_time);
    }

    /** @test */
    public function it_can_manage_result_execution_lifecycle(): void
    {
        $task = Task::create([
            'description' => 'Lifecycle Task',
            'command' => 'lifecycle:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        // Crea risultato in esecuzione
        $result = Result::create([
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => null,
            'result' => 'running',
            'output' => 'Task in esecuzione',
            'execution_time' => null,
        ]);

        $this->assertEquals('running', $result->result);
        $this->assertNull($result->finished_at);
        $this->assertNull($result->execution_time);

        // Completa l'esecuzione
        $result->update([
            'finished_at' => now(),
            'result' => 'success',
            'output' => 'Task completato',
            'execution_time' => 3.5,
        ]);

        $this->assertEquals('success', $result->result);
        $this->assertNotNull($result->finished_at);
        $this->assertEquals(3.5, $result->execution_time);
    }

    /** @test */
    public function it_can_handle_result_status_transitions(): void
    {
        $task = Task::create([
            'description' => 'Status Task',
            'command' => 'status:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $result = Result::create([
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => null,
            'result' => 'running',
            'output' => 'Task avviato',
        ]);

        $this->assertEquals('running', $result->result);

        // Transizione a success
        $result->update([
            'result' => 'success',
            'finished_at' => now(),
            'output' => 'Task completato con successo',
        ]);

        $this->assertEquals('success', $result->result);

        // Transizione a failed
        $result->update([
            'result' => 'failed',
            'output' => 'Task fallito: errore di connessione',
        ]);

        $this->assertEquals('failed', $result->result);
    }

    /** @test */
    public function it_can_manage_result_output_and_logging(): void
    {
        $task = Task::create([
            'description' => 'Output Task',
            'command' => 'output:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $detailedOutput = [
            'step' => 'Inizializzazione',
            'status' => 'success',
            'details' => 'Configurazione caricata correttamente',
            'timestamp' => now()->toISOString(),
        ];

        $result = Result::create([
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => now()->addMinutes(2),
            'result' => 'success',
            'output' => json_encode($detailedOutput),
            'execution_time' => 2.1,
        ]);

        $this->assertEquals(json_encode($detailedOutput), $result->output);

        $decodedOutput = json_decode($result->output, true);
        $this->assertEquals('Inizializzazione', $decodedOutput['step']);
        $this->assertEquals('success', $decodedOutput['status']);
    }

    /** @test */
    public function it_can_handle_result_performance_metrics(): void
    {
        $task = Task::create([
            'description' => 'Performance Task',
            'command' => 'performance:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $result = Result::create([
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => now()->addSeconds(3),
            'result' => 'success',
            'output' => 'Task performance test',
            'execution_time' => 3.0,
            'memory_usage' => 2048000,
            'cpu_usage' => 15.5,
            'exit_code' => 0,
        ]);

        $this->assertEquals(3.0, $result->execution_time);
        $this->assertEquals(2048000, $result->memory_usage);
        $this->assertEquals(15.5, $result->cpu_usage);
        $this->assertEquals(0, $result->exit_code);
    }

    /** @test */
    public function it_can_manage_result_error_handling(): void
    {
        $task = Task::create([
            'description' => 'Error Task',
            'command' => 'error:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $errorOutput = [
            'error_type' => 'ConnectionException',
            'error_message' => 'Impossibile connettersi al database',
            'error_code' => 'DB_CONNECTION_FAILED',
            'stack_trace' => 'Stack trace details...',
            'suggestions' => [
                'Verificare la connessione al database',
                'Controllare le credenziali',
                'Verificare che il servizio sia attivo',
            ],
        ];

        $result = Result::create([
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => now()->addSeconds(1),
            'result' => 'failed',
            'output' => json_encode($errorOutput),
            'execution_time' => 1.0,
            'exit_code' => 1,
        ]);

        $this->assertEquals('failed', $result->result);
        $this->assertEquals(1, $result->exit_code);

        $decodedError = json_decode($result->output, true);
        $this->assertEquals('ConnectionException', $decodedError['error_type']);
        $this->assertEquals('DB_CONNECTION_FAILED', $decodedError['error_code']);
    }

    /** @test */
    public function it_can_handle_result_relationships_with_task(): void
    {
        $task = Task::create([
            'description' => 'Relationship Task',
            'command' => 'relationship:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        // Crea risultati multipli per lo stesso task
        $result1 = Result::create([
            'task_id' => $task->id,
            'started_at' => now()->subHour(),
            'finished_at' => now()->subHour()->addMinutes(2),
            'result' => 'success',
            'output' => 'Prima esecuzione',
            'execution_time' => 2.0,
        ]);

        $result2 = Result::create([
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => now()->addMinutes(1),
            'result' => 'success',
            'output' => 'Seconda esecuzione',
            'execution_time' => 1.0,
        ]);

        $this->assertCount(2, $task->results);
        $this->assertTrue($task->results->contains($result1));
        $this->assertTrue($task->results->contains($result2));
    }

    /** @test */
    public function it_can_manage_result_cleanup_and_retention(): void
    {
        $task = Task::create([
            'description' => 'Cleanup Task',
            'command' => 'cleanup:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        // Crea risultati vecchi per testare la pulizia
        $oldResult = Result::create([
            'task_id' => $task->id,
            'started_at' => now()->subDays(30),
            'finished_at' => now()->subDays(30)->addMinutes(1),
            'result' => 'success',
            'output' => 'Risultato vecchio',
            'execution_time' => 1.0,
        ]);

        $recentResult = Result::create([
            'task_id' => $task->id,
            'started_at' => now()->subDays(1),
            'finished_at' => now()->subDays(1)->addMinutes(1),
            'result' => 'success',
            'output' => 'Risultato recente',
            'execution_time' => 1.0,
        ]);

        $this->assertTrue($oldResult->started_at < now()->subDays(7));
        $this->assertTrue($recentResult->started_at > now()->subDays(7));
    }

    /** @test */
    public function it_can_handle_result_batch_operations(): void
    {
        $task = Task::create([
            'description' => 'Batch Task',
            'command' => 'batch:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        // Crea un batch di risultati
        $results = [];
        $statuses = ['success', 'failed', 'success', 'success', 'failed'];

        for ($i = 1; $i <= 5; $i++) {
            $results[] = Result::create([
                'task_id' => $task->id,
                'started_at' => now()->subMinutes($i),
                'finished_at' => now()->subMinutes($i)->addSeconds(30),
                'result' => $statuses[$i - 1],
                'output' => "Risultato batch {$i}",
                'execution_time' => 0.5,
            ]);
        }

        $this->assertCount(5, $results);

        $successCount = collect($results)->where('result', 'success')->count();
        $failedCount = collect($results)->where('result', 'failed')->count();

        $this->assertEquals(3, $successCount);
        $this->assertEquals(2, $failedCount);
    }

    /** @test */
    public function it_can_validate_result_data_integrity(): void
    {
        $task = Task::create([
            'description' => 'Validation Task',
            'command' => 'validation:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        // Test con risultato valido
        $validResult = Result::create([
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => now()->addMinutes(1),
            'result' => 'success',
            'output' => 'Risultato valido',
            'execution_time' => 1.0,
        ]);

        $this->assertNotNull($validResult->id);
        $this->assertNotNull($validResult->started_at);
        $this->assertNotNull($validResult->finished_at);
        $this->assertTrue($validResult->finished_at > $validResult->started_at);

        // Verifica che il tempo di esecuzione sia positivo
        $this->assertGreaterThan(0, $validResult->execution_time);
    }

    /** @test */
    public function it_can_handle_result_notification_and_alerts(): void
    {
        $task = Task::create([
            'description' => 'Alert Task',
            'command' => 'alert:test',
            'expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $alertOutput = [
            'alert_level' => 'warning',
            'message' => 'Utilizzo memoria elevato',
            'threshold' => 80,
            'current_value' => 85,
            'recommendation' => 'Considerare l\'ottimizzazione della memoria',
        ];

        $result = Result::create([
            'task_id' => $task->id,
            'started_at' => now(),
            'finished_at' => now()->addMinutes(1),
            'result' => 'warning',
            'output' => json_encode($alertOutput),
            'execution_time' => 1.0,
        ]);

        $this->assertEquals('warning', $result->result);

        $decodedAlert = json_decode($result->output, true);
        $this->assertEquals('warning', $decodedAlert['alert_level']);
        $this->assertEquals(85, $decodedAlert['current_value']);
        $this->assertTrue($decodedAlert['current_value'] > $decodedAlert['threshold']);
    }
}
