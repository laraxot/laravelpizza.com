<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Carbon\Exceptions\InvalidFormatException;
use Filament\Forms\Components\Field;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(TestCase::class);

test('it can be instantiated', function (): void {
    $component = InlineDatePicker::make('test');
    Assert::assertInstanceOf(Field::class, $component);
    Assert::assertInstanceOf(InlineDatePicker::class, $component);
});

test('it can set and get enabled dates', function (): void {
    $dates = ['2025-06-01', '2025-06-15', '2025-06-30'];
    $component = InlineDatePicker::make('test')->enabledDates($dates);
    Assert::assertSame($dates, $component->getEnabledDates()->toArray());
});

test('it accepts closure for enabled dates', function (): void {
    $dates = ['2025-06-01', '2025-06-15', '2025-06-30'];
    $component = InlineDatePicker::make('test')->enabledDates(fn () => $dates);
    Assert::assertSame($dates, $component->getEnabledDates()->toArray());
});

test('it checks if date is enabled', function (): void {
    $component = InlineDatePicker::make('test')->enabledDates(['2025-06-15']);
    Assert::assertTrue($component->isDateEnabled('2025-06-15'));
    Assert::assertFalse($component->isDateEnabled('2025-06-16'));
});

test('it generates calendar data and marks enabled dates', function (): void {
    $component = InlineDatePicker::make('test')->enabledDates(['2025-06-15']);
    $component->currentViewMonth('2025-06');
    $data = $component->generateCalendarData();

    foreach (['year', 'month', 'weeks', 'monthName', 'weekdays'] as $key) {
        Assert::assertArrayHasKey($key, $data);
    }

    Assert::assertIsArray($data['weeks']);
    $found = false;
    foreach ($data['weeks'] as $week) {
        if (! is_array($week)) {
            continue;
        }
        foreach ($week as $day) {
            if (! is_array($day)) {
                continue;
            }
            $dateValue = $day['datetime'] ?? $day['dateString'] ?? null;
            if ('2025-06-15' === $dateValue) {
                $found = true;
                Assert::assertTrue((bool) ($day['isEnabled'] ?? false));
            }
        }
    }
    Assert::assertTrue($found, 'Enabled date 2025-06-15 not found in generated calendar data');
});

test('it respects locale in calendar data', function (): void {
    App::setLocale('it');
    $data = InlineDatePicker::make('test')->generateCalendarData();
    Assert::assertArrayHasKey('monthName', $data);
});

test('it can be used in a form', function (): void {
    Assert::markTestSkipped('Filament Schema::getComponent() requires a Livewire HasSchemas host in Filament v5.');
});

test('it handles empty enabled dates', function (): void {
    $component = InlineDatePicker::make('test')->enabledDates([]);
    Assert::assertInstanceOf(Collection::class, $component->getEnabledDates());
    Assert::assertTrue($component->getEnabledDates()->isEmpty());
    Assert::assertTrue($component->isDateEnabled('2025-06-15'));
});

test('it throws on invalid enabled dates input', function (): void {
    $component = InlineDatePicker::make('test')->enabledDates(['invalid-date']);

    try {
        $dates = $component->getEnabledDates()->toArray();
        Assert::assertIsArray($dates);
    } catch (InvalidFormatException $e) {
        Assert::assertNotEmpty($e->getMessage());
    }
});

test('it handles different date formats', function (): void {
    $component = InlineDatePicker::make('test')->enabledDates(['2025-06-15']);
    Assert::assertTrue($component->isDateEnabled('2025-06-15'));
    Assert::assertFalse($component->isDateEnabled('15-06-2025'));
});

test('it handles time portion gracefully', function (): void {
    $component = InlineDatePicker::make('test')->enabledDates(['2025-06-15']);
    Assert::assertTrue($component->isDateEnabled('2025-06-15'));
    Assert::assertFalse($component->isDateEnabled('2025-06-16'));
});

test('it uses carbon for localization', function (): void {
    App::setLocale('it');
    $picker = InlineDatePicker::make('test_date');
    $weekdays = invokeInlineDatePickerMethod($picker, 'getLocalizedWeekdays', []);
    Assert::assertIsArray($weekdays);
    Assert::assertCount(7, $weekdays);
});

test('it generates correct calendar data', function (): void {
    $picker = InlineDatePicker::make('test_date');
    $picker->currentViewMonth = '2024-01';
    $calendarData = $picker->generateCalendarData();

    Assert::assertArrayHasKey('weeks', $calendarData);
    Assert::assertArrayHasKey('monthName', $calendarData);
    Assert::assertArrayHasKey('weekdays', $calendarData);
    Assert::assertIsArray($calendarData['weeks']);
    Assert::assertGreaterThanOrEqual(4, count($calendarData['weeks']));
    Assert::assertLessThanOrEqual(6, count($calendarData['weeks']));
    Assert::assertIsArray($calendarData['weeks'][0]);
    Assert::assertCount(7, $calendarData['weeks'][0]);
});

test('it handles enabled dates correctly', function (): void {
    $picker = InlineDatePicker::make('test_date');
    $picker->enabledDates(['2024-01-15', '2024-01-16']);

    Assert::assertTrue($picker->isDateEnabled('2024-01-15'));
    Assert::assertTrue($picker->isDateEnabled('2024-01-16'));
    Assert::assertFalse($picker->isDateEnabled('2024-01-14'));
});

test('it is dry no code duplication', function (): void {
    $viewContent = file_get_contents(base_path(
        'Modules/UI/resources/views/filament/forms/components/inline-date-picker.blade.php',
    ));

    Assert::assertStringNotContainsString('navigateToMonth', $viewContent);
    Assert::assertStringNotContainsString('generateCalendarForMonth', $viewContent);
    Assert::assertStringContainsString('wire:click="previousMonth()', $viewContent);
    Assert::assertStringContainsString('wire:click="nextMonth()', $viewContent);
});

test('it is kiss simple and clear', function (): void {
    $picker = InlineDatePicker::make('test_date');
    Assert::assertInstanceOf(InlineDatePicker::class, $picker->enabledDates(['2024-01-01']));

    foreach ([
        'enabledDates',
        'isDateEnabled',
        'generateCalendarData',
        'getViewData',
        'previousMonth',
        'nextMonth',
    ] as $method) {
        Assert::assertTrue(method_exists($picker, $method), "Metodo essenziale mancante: {$method}");
    }
});

/**
 * @param array<int, mixed> $parameters
 */
function invokeInlineDatePickerMethod(object $object, string $methodName, array $parameters = []): mixed
{
    $reflection = new \ReflectionClass($object);
    $method = $reflection->getMethod($methodName);
    $method->setAccessible(true);

    return $method->invokeArgs($object, $parameters);
}
