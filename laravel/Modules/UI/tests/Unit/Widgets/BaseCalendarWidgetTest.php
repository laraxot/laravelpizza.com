<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Widgets;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Mockery\ExpectationInterface;
use Mockery\MockInterface;
use Modules\Lang\Actions\SaveTransAction;
use Modules\UI\Filament\Widgets\UserCalendarWidget;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function createTestCalendarWidget(): UserCalendarWidget
{
    $widget = new class extends UserCalendarWidget {
        public function getActionName(string $function): string
        {
            unset($function);

            return 'Modules\\UI\\Tests\\Unit\\Widgets\\NonExistingAction';
        }
    };
    $widget->type = 'test';

    return $widget;
}

beforeEach(function (): void {
    /* @var \Modules\UI\Tests\TestCase $this */
    $this->mockService(SaveTransAction::class, static function (MockInterface $mock): void {
        /** @var ExpectationInterface $expectation */
        $expectation = $mock->shouldReceive('execute');
        $expectation->andReturn(null);
    });
});

describe('Base Calendar Widget', function (): void {
    test('is auser calendar widget', function (): void {
        /* @var \Modules\UI\Tests\TestCase $this */
        Assert::assertInstanceOf(UserCalendarWidget::class, createTestCalendarWidget());
    });

    test('returns empty events if action class does not exist', function (): void {
        $widget = createTestCalendarWidget();
        $fetchInfo = [
            'start' => '2025-01-01T00:00:00',
            'end' => '2025-01-31T23:59:59',
        ];

        $events = $widget->fetchEvents($fetchInfo);

        Assert::assertCount(0, $events);
    });

    test('falls back to aminimal schema if action does not exist', function (): void {
        $widget = createTestCalendarWidget();
        $formSchema = $widget->getFormSchema();

        Assert::assertCount(2, $formSchema);
        Assert::assertInstanceOf(TextInput::class, $formSchema[0]);
        Assert::assertInstanceOf(Grid::class, $formSchema[1]);
        Assert::assertSame('title', $formSchema[0]->getName());
    });

    test('fallback schema contains agrid for datetime pickers', function (): void {
        $widget = createTestCalendarWidget();
        $formSchema = $widget->getFormSchema();

        $grid = $formSchema[1];
        Assert::assertInstanceOf(Grid::class, $grid);
    });
});
