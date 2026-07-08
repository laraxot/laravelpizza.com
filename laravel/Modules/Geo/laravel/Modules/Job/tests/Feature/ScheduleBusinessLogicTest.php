<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Feature;

use Modules\Job\Enums\Status;
use Modules\Job\Models\Schedule;
use Modules\Job\Models\ScheduleHistory;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Schedule Business Logic', function (): void {
    test('_can_create_schedule_with_basic_information', function (): void {
        $schedule = Schedule::create([
            'command' => 'inspire',
            'expression' => '0 2 * * *',
            'status' => Status::Active,
            'log_filename' => 'backup.log',
        ]);

        Assert::assertSame('inspire', $schedule->command);
        Assert::assertSame('0 2 * * *', $schedule->expression);
        Assert::assertSame(Status::Active, $schedule->status);
    });

    test('_can_manage_schedule_activation_and_deactivation', function (): void {
        $schedule = Schedule::create([
            'command' => 'cache:clear',
            'expression' => '0 * * * *',
            'status' => Status::Active,
        ]);

        Assert::assertSame(Status::Active, $schedule->status);

        $schedule->update(['status' => Status::Inactive]);

        Assert::assertSame(Status::Inactive, $schedule->status);
    });

    test('_can_handle_schedule_cron_expressions', function (): void {
        $dailySchedule = Schedule::create([
            'command' => 'daily:task',
            'expression' => '0 9 * * *',
            'status' => Status::Active,
        ]);

        $weeklySchedule = Schedule::create([
            'command' => 'weekly:task',
            'expression' => '0 10 * * 1',
            'status' => Status::Active,
        ]);

        $monthlySchedule = Schedule::create([
            'command' => 'monthly:task',
            'expression' => '0 8 1 * *',
            'status' => Status::Active,
        ]);

        Assert::assertSame('0 9 * * *', $dailySchedule->expression);
        Assert::assertSame('0 10 * * 1', $weeklySchedule->expression);
        Assert::assertSame('0 8 1 * *', $monthlySchedule->expression);
    });

    test('_can_scope_active_and_inactive_schedules', function (): void {
        Schedule::create([
            'command' => 'active:task',
            'expression' => '*/15 * * * *',
            'status' => Status::Active,
        ]);

        Schedule::create([
            'command' => 'inactive:task',
            'expression' => '0 0 * * *',
            'status' => Status::Inactive,
        ]);

        Assert::assertGreaterThanOrEqual(1, Schedule::active()->count());
        Assert::assertGreaterThanOrEqual(1, Schedule::inactive()->count());
    });

    test('_can_build_arguments_from_params', function (): void {
        $schedule = Schedule::create([
            'command' => 'email:send',
            'expression' => '0 * * * *',
            'status' => Status::Active,
            'params' => [
                'recipient' => [
                    'name' => 'to',
                    'value' => 'admin@example.com',
                    'type' => 'string',
                ],
            ],
        ]);

        $arguments = $schedule->getArguments();

        Assert::assertSame(['to' => 'admin@example.com'], $arguments);
    });

    test('_can_build_options_from_configuration', function (): void {
        $schedule = Schedule::create([
            'command' => 'queue:work',
            'expression' => '0 9 * * 1',
            'status' => Status::Active,
            'options' => ['verbose'],
            'options_with_value' => [
                ['name' => 'queue', 'value' => 'default'],
            ],
        ]);

        $options = $schedule->getOptions();

        Assert::assertArrayHasKey('verbose', $options);
        Assert::assertStringContainsString('--queue=default', $options[1]);
    });

    test('_can_manage_schedule_history_and_logging', function (): void {
        $schedule = Schedule::create([
            'command' => 'history:task',
            'expression' => '0 * * * *',
            'status' => Status::Active,
        ]);

        $history1 = ScheduleHistory::create([
            'command' => 'history:task',
            'output' => 'Esecuzione completata con successo',
            'schedule_id' => (int) $schedule->id,
        ]);

        $history2 = ScheduleHistory::create([
            'command' => 'history:task',
            'output' => 'Esecuzione in corso',
            'schedule_id' => (int) $schedule->id,
        ]);

        $schedule->refresh();

        Assert::assertCount(2, $schedule->histories);
        Assert::assertTrue($schedule->histories->contains($history1));
        Assert::assertTrue($schedule->histories->contains($history2));
    });

    test('_can_handle_schedule_status_transitions', function (): void {
        $schedule = Schedule::create([
            'command' => 'status:task',
            'expression' => '0 * * * *',
            'status' => Status::Active,
        ]);

        Assert::assertSame(Status::Active, $schedule->status);

        $schedule->update(['status' => Status::Inactive]);
        Assert::assertSame(Status::Inactive, $schedule->status);

        $schedule->update(['status' => Status::Trashed]);
        Assert::assertSame(Status::Trashed, $schedule->status);

        $schedule->update(['status' => Status::Active]);
        Assert::assertSame(Status::Active, $schedule->status);
    });

    test('_can_handle_schedule_batch_operations', function (): void {
        $batchSchedules = [];

        for ($i = 1; $i <= 3; $i++) {
            $batchSchedules[] = Schedule::create([
                'command' => "batch:task-{$i}",
                'expression' => "0 {$i} * * *",
                'status' => Status::Active,
            ]);
        }

        Assert::assertCount(3, $batchSchedules);

        foreach ($batchSchedules as $index => $schedule) {
            Assert::assertSame('batch:task-'.($index + 1), $schedule->command);
            Assert::assertSame('0 '.($index + 1).' * * *', $schedule->expression);
            Assert::assertSame(Status::Active, $schedule->status);
        }
    });
});
