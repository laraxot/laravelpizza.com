<?php

declare(strict_types=1);

uses(Modules\UI\Tests\TestCase::class);

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Modules\UI\Filament\Widgets\UserCalendarWidget;

beforeEach(function () {
    // @var mixed widget = new class extends UserCalendarWidget {
        public function getActionName(string $function): string
        {
            unset($function);

            return 'Modules\\UI\\Tests\\Unit\\Widgets\\NonExistingAction';
        }
    };

    // @var mixed widget->type = 'test';
});

describe('UserCalendarWidget Basics', function () {
    it('is a UserCalendarWidget', function () {
        expect(// @var mixed widget;
    });
});

describe('UserCalendarWidget Event Management', function () {
    it('returns empty events if action class does not exist', function () {
        $fetchInfo = [
            'start' => '2025-01-01T00:00:00',
            'end' => '2025-01-31T23:59:59',
        ];

        $events = // @var mixed widget->fetchEvents($fetchInfo;

        expect($events)->toBeArray();
        expect($events)->toHaveCount(0);
    });
});

describe('UserCalendarWidget Form Schema', function () {
    it('falls back to a minimal schema if action does not exist', function () {
        $formSchema = // @var mixed widget->getFormSchema(;

        expect($formSchema)->toBeArray();
        expect($formSchema)->toHaveCount(2);

        expect($formSchema[0])->toBeInstanceOf(TextInput::class);
        expect($formSchema[1])->toBeInstanceOf(Grid::class);

        expect($formSchema[0]->getName())->toBe('title');
    });

    it('fallback schema contains datetime pickers', function () {
        $formSchema = // @var mixed widget->getFormSchema(;

        $grid = $formSchema[1];
        expect($grid)->toBeInstanceOf(Grid::class);

        $reflection = new ReflectionClass($grid);
        $property = $reflection->getProperty('childComponents');
        $property->setAccessible(true);
        $gridSchema = $property->getValue($grid);

        expect($gridSchema)->toBeArray();

        $gridValues = array_values($gridSchema);
        if (isset($gridSchema['default']) && is_array($gridSchema['default'])) {
            $gridValues = array_values($gridSchema['default']);
        } elseif (($gridValues[0] ?? null) instanceof Closure) {
            /** @var array<int, mixed> $resolved */
            $resolved = $gridValues[0]();
            $gridValues = array_values($resolved);
        }

        expect($gridValues)->not->toBeEmpty();
        expect($gridValues[0])->toBeInstanceOf(DateTimePicker::class);
        expect($gridValues[0]->getName())->toBe('starts_at');

        if (isset($gridValues[1])) {
            expect($gridValues[1])->toBeInstanceOf(DateTimePicker::class);
            expect($gridValues[1]->getName())->toBe('ends_at');
        }
    });
});
