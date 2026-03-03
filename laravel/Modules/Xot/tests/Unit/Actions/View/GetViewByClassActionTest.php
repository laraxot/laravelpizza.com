<?php

declare(strict_types=1);

use Illuminate\Contracts\View\View;
use Modules\Xot\Actions\GetViewByClassAction;
use Tests\TestCase;

uses(TestCase::class);

it('returns a view when explicit view name is provided', function (): void {
    $view = app(GetViewByClassAction::class)->execute(
        'Modules\\Xot\\Http\\Controllers\\DashboardController',
        ['title' => 'Hello'],
        'welcome',
    );

    expect($view)->toBeInstanceOf(View::class)
        ->and($view->getName())->toBe('welcome')
        ->and($view->getData()['title'])->toBe('Hello');
});

it('builds default view name from class when view name is omitted', function (): void {
    expect(fn () => app(GetViewByClassAction::class)->execute('Modules\\Xot\\Pages\\MyCustomPage'))
        ->toThrow(InvalidArgumentException::class, 'View [my-custom-page] not found');
});

it('resolves old style module view path', function (): void {
    $name = app(GetViewByClassAction::class)->executeOld('Modules\\Xot\\Filament\\Pages\\MainDashboard');

    expect($name)->toBe('xot::pages.main-dashboard');
});

it('throws in executeOld when class is not in modules namespace', function (): void {
    app(GetViewByClassAction::class)->executeOld('App\\Http\\Controllers\\HomeController');
})->throws(InvalidArgumentException::class, 'Class must be in Modules namespace');
