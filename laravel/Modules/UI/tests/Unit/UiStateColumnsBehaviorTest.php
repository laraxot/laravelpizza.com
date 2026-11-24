<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use BladeUI\Icons\Factory as IconFactory;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Modules\UI\Actions\Icon\GetAllIconsAction;
use Modules\UI\Filament\Forms\Components\AddressField;
use Modules\UI\Filament\Forms\Components\InlineDatePicker;
use Modules\UI\Filament\Tables\Columns\IconStateColumn;
use Modules\UI\Filament\Tables\Columns\IconStateGroupColumn;
use Modules\UI\Filament\Tables\Columns\IconStateSplitColumn;
use Modules\UI\Filament\Tables\Columns\SelectStateColumn;
use Modules\UI\Tests\TestCase;
use Modules\UI\Tests\Unit\Stubs\UiCoverageDoneState;
use Modules\UI\Tests\Unit\Stubs\UiCoverageRecord;
use Modules\UI\Tests\Unit\Stubs\UiCoverageRecordWithThrowingState;
use Modules\UI\Tests\Unit\Stubs\UiCoverageStateContract;
use Modules\UI\Tests\Unit\Stubs\UiCoverageThrowingTransitionState;
use PHPUnit\Framework\Assert;

use function Safe\mkdir;

uses(TestCase::class);

afterEach(function (): void {
    UiCoverageRecord::$findMap = [];
    \Mockery::close();
});

describe('UI state columns — comportamento IconStateColumn', function (): void {
    test('icon color tooltip rispondono allo StateContract', function (): void {
        $column = IconStateColumn::make('state');
        $state = new UiCoverageStateContract();

        Assert::assertSame('heroicon-o-clock', $column->getIcon($state));
        Assert::assertSame('warning', $column->getColor($state));
        Assert::assertSame('Pending', $column->getTooltip($state));
    });

    test('action schema: options con stato null usa getDefaultStateFor', function (): void {
        $column = IconStateColumn::make('state');
        $action = $column->getAction();
        Assert::assertInstanceOf(Action::class, $action);

        $record = new UiCoverageRecord(['id' => 1]);
        $select = uiFirstActionSchemaComponent($action);
        $options = uiEvaluateSelectOptions($select, $record, null);

        Assert::assertArrayHasKey('pending', $options);
        Assert::assertArrayHasKey('done', $options);
    });

    test('action schema: options con StateContract legge transitionableStates', function (): void {
        $column = IconStateColumn::make('state');
        $action = $column->getAction();
        Assert::assertInstanceOf(Action::class, $action);

        $record = new UiCoverageRecord(['id' => 1]);
        $state = new UiCoverageStateContract($record);
        $record->setAttribute('state', $state);

        $select = uiFirstActionSchemaComponent($action);
        $options = uiEvaluateSelectOptions($select, $record, '');

        Assert::assertNotEmpty($options);
    });

    test('action transition aggiorna record', function (): void {
        $column = IconStateColumn::make('state');
        $action = $column->getAction();
        Assert::assertInstanceOf(Action::class, $action);

        $record = new UiCoverageRecord(['id' => 1]);
        $state = new UiCoverageStateContract($record);
        $record->setAttribute('state', $state);

        $action->call(['record' => $record, 'data' => ['state' => 'done', 'message' => 'ok']]);
        Assert::assertSame('done', $record->getAttribute('state'));
    });

    test('action options ramo eccezione usa getStatesFor', function (): void {
        $column = IconStateColumn::make('state');
        $action = $column->getAction();
        Assert::assertInstanceOf(Action::class, $action);

        $record = new UiCoverageRecordWithThrowingState(['id' => 2]);
        $state = new UiCoverageThrowingTransitionState($record);
        $record->setAttribute('state', $state);

        $select = uiFirstActionSchemaComponent($action);
        $options = uiEvaluateSelectOptions($select, $record, '');
        Assert::assertNotEmpty($options);
    });

    test('action rifiuta state non stringa', function (): void {
        $column = IconStateColumn::make('state');
        $action = $column->getAction();
        Assert::assertInstanceOf(Action::class, $action);

        $record = new UiCoverageRecord(['id' => 1]);
        $record->setAttribute('state', new UiCoverageStateContract($record));

        expect(static fn () => $action->call(['record' => $record, 'data' => ['state' => 123]]))
            ->toThrow(\Exception::class);
    });
});

describe('UI state columns — IconStateSplitColumn transizioni', function (): void {
    test('getRecordStates e getStateActions con mapping', function (): void {
        $record = new UiCoverageRecord(['id' => 7]);
        $state = new UiCoverageStateContract($record);
        $record->setAttribute('state', $state);

        $column = IconStateSplitColumn::make('state')
            ->stateClass(UiCoverageStateContract::class, UiCoverageRecord::class)
            ->record($record);

        $states = $column->getRecordStates();
        Assert::assertArrayHasKey('pending', $states);
        Assert::assertSame('heroicon-o-clock', $states['pending']['icon']);

        $actions = $column->getStateActions();
        Assert::assertArrayHasKey('prova', $actions);
    });

    test('canTransitionTo e transitionState con find mockato', function (): void {
        $record = new UiCoverageRecord(['id' => 9]);
        $state = new UiCoverageStateContract($record);
        $record->setAttribute('state', $state);
        UiCoverageRecord::$findMap[9] = $record;

        $column = IconStateSplitColumn::make('state')
            ->stateClass(UiCoverageStateContract::class, UiCoverageRecord::class)
            ->record($record);

        Assert::assertTrue($column->canTransitionTo(9, UiCoverageDoneState::class));
        Assert::assertFalse($column->canTransitionTo(9, \stdClass::class));

        $column->transitionState(9, UiCoverageDoneState::class);
        Assert::assertSame(UiCoverageDoneState::class, $record->getAttribute('state'));
    });

    test('handleTableAction esegue prova senza eccezioni', function (): void {
        $column = IconStateSplitColumn::make('state')
            ->stateClass(UiCoverageStateContract::class, UiCoverageRecord::class);

        $column->handleTableAction('prova', 1);
        Notification::assertNotified(__('ui::actions.test_action.title'));
    });

    test('transitionState con record invalido notifica errore', function (): void {
        $column = IconStateSplitColumn::make('state')
            ->stateClass(UiCoverageStateContract::class, UiCoverageRecord::class);

        UiCoverageRecord::$findMap[99] = new UiCoverageRecord(['id' => 99]);

        $column->transitionState(99, UiCoverageDoneState::class);
        Notification::assertNotified(__('ui::icon_state.messages.transition_error.title'));
    });
});

describe('UI state columns — IconStateGroupColumn e SelectStateColumn', function (): void {
    test('IconStateGroupColumn costruisce colonne da mapping', function (): void {
        $group = IconStateGroupColumn::make('states')
            ->stateClass(UiCoverageStateContract::class, UiCoverageRecord::class);

        Assert::assertSame(UiCoverageStateContract::class, $group->stateClass);
        Assert::assertNotEmpty($group->getColumns());
    });

    test('SelectStateColumn options e beforeStateUpdated', function (): void {
        $column = SelectStateColumn::make('state');
        $record = new UiCoverageRecord(['id' => 3]);
        $state = new UiCoverageStateContract($record);
        $record->setAttribute('state', $state);

        $options = uiEvaluateColumnOptions($column, $record, $state);
        Assert::assertNotEmpty($options);

        $nullOptions = uiEvaluateColumnOptions($column, $record, null);
        Assert::assertNotEmpty($nullOptions);

        uiInvokeBeforeStateUpdated($column, $record, 'done');
        Assert::assertSame('done', $record->getAttribute('state'));
    });
});

describe('UI forms — InlineDatePicker e AddressField', function (): void {
    test('InlineDatePicker naviga mesi e genera calendario', function (): void {
        $picker = InlineDatePicker::make('date')
            ->enabledDates(['2024-06-15'])
            ->currentViewMonth('2024-06');

        Assert::assertTrue($picker->isDateEnabled('2024-06-15'));
        Assert::assertFalse($picker->isDateEnabled('2024-06-01'));

        $picker->previousMonth();
        Assert::assertSame('2024-05', $picker->currentViewMonth);
        $picker->nextMonth();
        Assert::assertSame('2024-06', $picker->currentViewMonth);

        $data = $picker->generateCalendarData();
        Assert::assertArrayHasKey('weeks', $data);
        Assert::assertNotEmpty($data['weekdays']);
    });

    test('AddressField espone relationship e child components', function (): void {
        $field = AddressField::make('address')->relationship('address');
        Assert::assertSame('address', $field->getRelationship());
        Assert::assertNotEmpty($field->getDefaultChildComponents());
    });

    test('InlineDatePicker normalizza mese invalido e date malformate', function (): void {
        $picker = InlineDatePicker::make('date')->currentViewMonth('not-a-month');
        Assert::assertMatchesRegularExpression('/^\d{4}-\d{2}$/', $picker->currentViewMonth);

        $picker->enabledDates(['bad-date', '2024-01-02']);
        Assert::assertSame(['2024-01-02'], $picker->getEnabledDates()->all());
    });
});

describe('UI actions — GetAllIconsAction con factory mock', function (): void {
    test('mappa svg da paths temporanei', function (): void {
        $tmp = sys_get_temp_dir().'/ui-icons-'.uniqid('', true);
        mkdir($tmp, 0777, true);
        File::put($tmp.'/sample.svg', '<svg></svg>');

        $factory = App::make(IconFactory::class);
        $ref = new \ReflectionClass($factory);
        $prop = $ref->getProperty('sets');
        $prop->setAccessible(true);
        $prop->setValue($factory, [
            'test' => [
                'paths' => [$tmp],
                'prefix' => 't',
            ],
        ]);

        $result = app(GetAllIconsAction::class)->execute('form');
        Assert::assertArrayHasKey('test', $result);
        $icons = $result['test']['icons'];
        Assert::assertIsArray($icons);
        Assert::assertContains('t-sample', $icons);

        File::deleteDirectory($tmp);
    });

    test('ritorna array vuoto se reflection fallisce', function (): void {
        $factory = \Mockery::mock(App::make(IconFactory::class))->makePartial();
        App::instance(IconFactory::class, $factory);

        Assert::assertSame([], app(GetAllIconsAction::class)->execute());
    });
});

/** @return array<int|string, string> */
function uiEvaluateSelectOptions(Select $select, Model $record, ?string $state): array
{
    $ref = new \ReflectionClass($select);
    $prop = $ref->getProperty('options');
    $prop->setAccessible(true);
    $options = $prop->getValue($select);
    Assert::assertInstanceOf(\Closure::class, $options);

    /** @var array<int|string, string> $result */
    $result = $options->call($select, $record, $state ?? '');

    return $result;
}

/** @return array<int|string, string> */
function uiEvaluateColumnOptions(SelectStateColumn $column, Model $record, ?object $state): array
{
    $ref = new \ReflectionClass($column);
    $prop = $ref->getProperty('options');
    $prop->setAccessible(true);
    $options = $prop->getValue($column);
    Assert::assertInstanceOf(\Closure::class, $options);

    /** @var array<int|string, string> $result */
    $result = $options->call($column, $record, $state);

    return $result;
}

function uiInvokeBeforeStateUpdated(SelectStateColumn $column, Model $record, string $state): void
{
    $ref = new \ReflectionClass($column);
    $prop = $ref->getProperty('beforeStateUpdated');
    $prop->setAccessible(true);
    $closure = $prop->getValue($column);
    Assert::assertInstanceOf(\Closure::class, $closure);
    $closure($record, $state);
}

function uiFirstActionSchemaComponent(Action $action): Select
{
    $ref = new \ReflectionClass($action);
    $prop = $ref->getProperty('schema');
    $prop->setAccessible(true);
    /** @var callable|array<int, mixed>|null $schema */
    $schema = $prop->getValue($action);
    $components = $action->evaluate($schema);
    Assert::assertIsArray($components);

    foreach ($components as $component) {
        if ($component instanceof Select) {
            return $component;
        }
    }

    throw new \RuntimeException('Select component not found in action schema');
}
