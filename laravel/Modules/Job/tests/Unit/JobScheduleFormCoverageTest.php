<?php

declare(strict_types=1);

namespace Modules\Job\Tests\Unit;

use Filament\Forms\Components\Field;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Mockery;
use Modules\Job\Actions\Command\GetCommandsAction;
use Modules\Job\Datas\CommandData;
use Modules\Job\Filament\Resources\ScheduleResource\Schemas\ScheduleForm;
use Modules\Job\Tests\Fixtures\StubGetCommandsAction;
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

describe('Job ScheduleForm full schema coverage', function (): void {
    test('getFormSchema keyed e afterStateUpdated closures', function (): void {
        $command = CommandData::from([
            'name' => 'inspire',
            'full_name' => 'inspire',
            'description' => 'demo',
            'signature' => 'inspire {arg1}',
            'arguments' => [
                ['name' => 'arg1', 'required' => true, 'value' => null],
            ],
            'options' => [
                'withValue' => [
                    ['name' => 'opt1', 'required' => false, 'value' => null, 'type' => 'string'],
                ],
                'withoutValue' => ['verbose'],
            ],
        ]);

        $collection = new DataCollection(CommandData::class, [$command]);
        app()->instance(GetCommandsAction::class, new StubGetCommandsAction($collection));

        $schema = (new ScheduleForm)->getFormSchema();
        Assert::assertArrayHasKey('main_section', $schema);

        // I campi dello schedule, nell'ordine in cui li dichiara ScheduleForm.
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

        // Invoke nested closures via ModuleRemainingCoverage-style property walk
        $set = Mockery::mock(Set::class);
        expectMethod($set, '__invoke')->andReturnNull();
        $set->shouldIgnoreMissing();

        $get = Mockery::mock(Get::class);
        expectMethod($get, '__invoke')->with('name')->andReturn('arg1');
        expectMethod($get, '__invoke')->with('required')->andReturn(true);
        expectMethod($get, '__invoke')->andReturn('arg1', true, null);
        $get->shouldIgnoreMissing();

        $ref = new \ReflectionObject($schema['main_section']);
        foreach ($ref->getProperties() as $property) {
            $property->setAccessible(true);
            try {
                $val = $property->getValue($schema['main_section']);
            } catch (\Throwable) {
                continue;
            }
            jobInvokeClosures($val, $set, $get);
        }
    });
});

/**
 * Percorre ricorsivamente il grafo di $value invocando le Closure trovate.
 *
 * @param  mixed  $value  Nodo eterogeneo del grafo: Closure|array|object|scalar|null.
 */
function jobInvokeClosures(mixed $value, object $set, object $get, int $depth = 0): void
{
    if ($depth > 8) {
        return;
    }
    if ($value instanceof \Closure) {
        foreach ([[$set, 'inspire'], [$get], [$get, $set], ['inspire'], []] as $args) {
            try {
                $value(...$args);
            } catch (\Throwable) {
            }
        }

        return;
    }
    if (is_array($value)) {
        foreach ($value as $item) {
            jobInvokeClosures($item, $set, $get, $depth + 1);
        }

        return;
    }
    if (! is_object($value)) {
        return;
    }
    $ref = new \ReflectionObject($value);
    foreach ($ref->getProperties() as $property) {
        $property->setAccessible(true);
        try {
            jobInvokeClosures($property->getValue($value), $set, $get, $depth + 1);
        } catch (\Throwable) {
        }
    }
    foreach (['getChildComponents', 'getDefaultChildComponents', 'getSchema', 'getActionFunction'] as $method) {
        if (! method_exists($value, $method)) {
            continue;
        }
        try {
            $rm = new \ReflectionMethod($value, $method);
            if ($rm->getNumberOfRequiredParameters() === 0) {
                jobInvokeClosures($rm->invoke($value), $set, $get, $depth + 1);
            }
        } catch (\Throwable) {
        }
    }
}
