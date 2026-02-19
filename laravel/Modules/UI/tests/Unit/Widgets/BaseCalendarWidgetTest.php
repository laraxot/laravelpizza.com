<?php

declare(strict_types=1);

uses(Modules\UI\Tests\TestCase::class);

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Modules\UI\Filament\Widgets\UserCalendarWidget;

beforeEach(function () {
    $this->widget = new class extends UserCalendarWidget {
        public function getActionName(string $function): string
        {
            unset($function);

            return 'Modules\\UI\\Tests\\Unit\\Widgets\\NonExistingAction';
        }
    };

    $this->widget->type = 'test';
});

describe('UserCalendarWidget Basics', function () {
    it('is a UserCalendarWidget', function () {
        expect($this->widget)->toBeInstanceOf(UserCalendarWidget::class);
    });
});

describe('UserCalendarWidget Event Management', function () {
    it('returns empty events if action class does not exist', function () {
        $fetchInfo = [
            'start' => '2025-01-01T00:00:00',
            'end' => '2025-01-31T23:59:59',
        ];

        $events = $this->widget->fetchEvents($fetchInfo);

        expect($events)->toBeArray();
        expect($events)->toHaveCount(0);
    });
});

describe('UserCalendarWidget Form Schema', function () {
    it('falls back to a minimal schema if action does not exist', function () {
        $formSchema = $this->widget->getFormSchema();

        expect($formSchema)->toBeArray();
        expect($formSchema)->toHaveCount(2);

        expect($formSchema[0])->toBeInstanceOf(TextInput::class);
        expect($formSchema[1])->toBeInstanceOf(Grid::class);

        expect($formSchema[0]->getName())->toBe('title');
    });

    it('fallback schema contains datetime pickers', function () {
        $formSchema = $this->widget->getFormSchema();

        $grid = $formSchema[1];
        expect($grid)->toBeInstanceOf(Grid::class);

        $gridSchema = $grid->getChildComponents();
        expect($gridSchema)->toBeArray();
        expect($gridSchema)->toHaveCount(2);

        expect($gridSchema[0])->toBeInstanceOf(DateTimePicker::class);
        expect($gridSchema[1])->toBeInstanceOf(DateTimePicker::class);

        expect($gridSchema[0]->getName())->toBe('starts_at');
        expect($gridSchema[1]->getName())->toBe('ends_at');
    });
});
