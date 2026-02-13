<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Modules\Job\Models\Schedule;
use Modules\Job\Models\ScheduleHistory;
use Modules\Job\Tests\TestCase;

class ScheduleBusinessLogicTest extends TestCase
{
    /** @test */
    public function it_can_create_schedule_with_basic_information(): void
    {
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

        $this->assertEquals('Backup giornaliero', $schedule->name);
        $this->assertEquals('0 2 * * *', $schedule->cron_expression);
        $this->assertEquals('Europe/Rome', $schedule->timezone);
        $this->assertTrue($schedule->is_active);
    }

    /** @test */
    public function it_can_manage_schedule_activation_and_deactivation(): void
    {
        $schedule = Schedule::create([
            'name' => 'Test Schedule',
            'description' => 'Test Description',
            'cron_expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $this->assertTrue($schedule->is_active);
        $this->assertEquals('active', $schedule->status);

        // Disattiva lo schedule
        $schedule->update([
            'is_active' => 0,
            'status' => 'inactive',
        ]);

        $this->assertFalse($schedule->is_active);
        $this->assertEquals('inactive', $schedule->status);
    }

    /** @test */
    public function it_can_handle_schedule_cron_expressions(): void
    {
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

        $this->assertEquals('0 9 * * *', $dailySchedule->cron_expression);
        $this->assertEquals('0 10 * * 1', $weeklySchedule->cron_expression);
        $this->assertEquals('0 8 1 * *', $monthlySchedule->cron_expression);
    }

    /** @test */
    public function it_can_manage_schedule_execution_limits(): void
    {
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

        $this->assertEquals(100, $schedule->max_executions);
        $this->assertEquals(5, $schedule->retry_attempts);
        $this->assertEquals(600, $schedule->retry_delay);
    }

    /** @test */
    public function it_can_handle_schedule_priority_management(): void
    {
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

        $this->assertEquals('high', $highPrioritySchedule->priority);
        $this->assertEquals('medium', $mediumPrioritySchedule->priority);
        $this->assertEquals('low', $lowPrioritySchedule->priority);
    }

    /** @test */
    public function it_can_manage_schedule_timezone_handling(): void
    {
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

        $this->assertEquals('Europe/Rome', $romeSchedule->timezone);
        $this->assertEquals('UTC', $utcSchedule->timezone);
        $this->assertEquals('Asia/Tokyo', $tokyoSchedule->timezone);
    }

    /** @test */
    public function it_can_handle_schedule_status_transitions(): void
    {
        $schedule = Schedule::create([
            'name' => 'Status Test Schedule',
            'description' => 'Test transizioni stato',
            'cron_expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $this->assertEquals('active', $schedule->status);

        // Cambia stato a pausa
        $schedule->update(['status' => 'paused']);
        $this->assertEquals('paused', $schedule->status);

        // Cambia stato a errore
        $schedule->update(['status' => 'error']);
        $this->assertEquals('error', $schedule->status);

        // Cambia stato a manutenzione
        $schedule->update(['status' => 'maintenance']);
        $this->assertEquals('maintenance', $schedule->status);

        // Ripristina stato attivo
        $schedule->update(['status' => 'active']);
        $this->assertEquals('active', $schedule->status);
    }

    /** @test */
    public function it_can_manage_schedule_history_and_logging(): void
    {
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

        $this->assertCount(2, $schedule->scheduleHistories);
        $this->assertTrue($schedule->scheduleHistories->contains($history1));
        $this->assertTrue($schedule->scheduleHistories->contains($history2));
    }

    /** @test */
    public function it_can_handle_schedule_retry_logic(): void
    {
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

        $this->assertEquals(3, $schedule->retry_attempts);
        $this->assertEquals(300, $schedule->retry_delay);

        // Simula fallimento e retry
        $schedule->update(['status' => 'failed']);
        $this->assertEquals('failed', $schedule->status);

        // Simula retry
        $schedule->update(['status' => 'retrying']);
        $this->assertEquals('retrying', $schedule->status);
    }

    /** @test */
    public function it_can_handle_schedule_execution_tracking(): void
    {
        $schedule = Schedule::create([
            'name' => 'Execution Test Schedule',
            'description' => 'Test tracking esecuzioni',
            'cron_expression' => '0 * * * *',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
            'max_executions' => 1000,
        ]);

        $this->assertEquals(1000, $schedule->max_executions);

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

        $this->assertCount(5, $schedule->scheduleHistories);
    }

    /** @test */
    public function it_can_handle_schedule_validation_and_constraints(): void
    {
        // Schedule con espressione cron valida
        $validSchedule = Schedule::create([
            'name' => 'Valid Schedule',
            'description' => 'Schedule valido',
            'cron_expression' => '0 9 * * 1-5',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $this->assertNotNull($validSchedule->id);

        // Schedule con espressione cron complessa
        $complexSchedule = Schedule::create([
            'name' => 'Complex Schedule',
            'description' => 'Schedule con espressione complessa',
            'cron_expression' => '0 9-17 * * 1-5',
            'timezone' => 'UTC',
            'is_active' => 1,
            'status' => 'active',
        ]);

        $this->assertNotNull($complexSchedule->id);
    }

    /** @test */
    public function it_can_handle_schedule_batch_operations(): void
    {
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

        $this->assertCount(3, $batchSchedules);

        foreach ($batchSchedules as $index => $schedule) {
            $this->assertEquals('Batch Schedule '.($index + 1), $schedule->name);
            $this->assertEquals('0 '.($index + 1).' * * *', $schedule->cron_expression);
            $this->assertEquals($priorities[$index], $schedule->priority);
        }
    }
}
