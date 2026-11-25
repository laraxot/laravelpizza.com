<?php

declare(strict_types=1);

use Filament\Schemas\Components\Utilities\Set;
use Modules\Xot\Filament\Actions\Form\FieldRefreshAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

/*
 * Il bottone di ricalcolo deve davvero ricalcolare: dal 2026-09-02 al 2026-11-05 mostrava
 * "Valore ricalcolato" senza chiamare nulla, e il vecchio test (che ingoia ogni eccezione) non se
 * ne accorgeva.
 */
test('the getter name is the pure twin of the field', function (): void {
    expect(FieldRefreshAction::getterName('gg_in_sede'))->toBe('getGgInSede')
        ->and(FieldRefreshAction::getterName('last_catecoposfun_at'))->toBe('getLastCatecoposfunAt');
});

test('the action calls the twin and puts its value in the form', function (): void {
    $record = new class
    {
        public function getGgInSede(): int
        {
            return 42;
        }
    };
    $written = [];
    $set = Mockery::mock(Set::class);
    $set->shouldReceive('__invoke')->once()->andReturnUsing(function (string $name, mixed $value) use (&$written): void {
        $written[$name] = $value;
    });

    $action = FieldRefreshAction::make('gg_in_sede');
    $action->call([
        'record' => $record,
        'set' => $set,
    ]);

    expect($written)->toBe([
        'gg_in_sede' => 42,
    ]);
});

test('a missing or protected twin is not called, even on a model with __call', function (): void {
    $record = new class
    {
        /**
         * @param  array<int, mixed>  $arguments
         */
        public function __call(string $name, array $arguments): mixed
        {
            throw new BadMethodCallException($name);
        }

        protected function getSecret(): int
        {
            return 1;
        }
    };

    expect(FieldRefreshAction::hasPublicGetter($record, 'getMissing'))->toBeFalse()
        ->and(FieldRefreshAction::hasPublicGetter($record, 'getSecret'))->toBeFalse();
});

test('a date from the twin becomes the date picker state string', function (): void {
    expect(FieldRefreshAction::make('last_integ_param_at')->toFieldState(Carbon\Carbon::parse('2024-01-01 10:00')))
        ->toBe('2024-01-01')
        ->and(FieldRefreshAction::make('posiz')->toFieldState(217))->toBe(217);
});
