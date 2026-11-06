<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Filament\Forms\Components\Field;
use Filament\Schemas\Components\Section;
use Mockery;
use Mockery\MockInterface;
use Modules\Job\Actions\Command\GetCommandsAction;
use Modules\Job\Datas\CommandData;
use Modules\Job\Filament\Resources\ScheduleResource\Schemas\ScheduleForm;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\LaravelData\DataCollection;

uses(TestCase::class)->group('no-job-db');

afterEach(function (): void {
    Mockery::close();
    $ref = new \ReflectionClass(ScheduleForm::class);
    if ($ref->hasProperty('commands')) {
        $prop = $ref->getProperty('commands');
        $prop->setAccessible(true);
        $prop->setValue(null, null);
    }
});

describe('ScheduleForm coverage', function (): void {
    test('getFormSchema espone section e campi schedule', function (): void {
        $commands = new DataCollection(CommandData::class, [
            CommandData::from([
                'name' => 'inspire',
                'description' => 'Display an inspiring quote',
                'signature' => 'inspire',
                'full_name' => 'inspire',
                'arguments' => [],
                'options' => ['withValue' => []],
            ]),
        ]);

        /** @var MockInterface&GetCommandsAction $action */
        $action = Mockery::mock(GetCommandsAction::class);
        expectMethod($action, 'execute')->andReturn($commands);
        app()->instance(GetCommandsAction::class, $action);

        $schema = (new ScheduleForm)->getFormSchema();
        Assert::assertArrayHasKey('main_section', $schema);

        $section = $schema['main_section'];
        Assert::assertInstanceOf(Section::class, $section);
        $children = $section->getDefaultChildComponents();
        Assert::assertIsArray($children);
        $fieldNames = [];
        foreach ($children as $child) {
            if ($child instanceof Field) {
                $fieldNames[] = $child->getName();
            }
        }
        Assert::assertSame([
            'command',
            'params',
            'options_with_value',
            'expression',
            'environments',
            'log_filename',
            'webhook_before',
            'webhook_after',
            'email_output',
            'sendmail_success',
            'sendmail_error',
            'log_success',
            'log_error',
            'even_in_maintenance_mode',
            'without_overlapping',
            'on_one_server',
            'run_in_background',
        ], $fieldNames);
    });
});
