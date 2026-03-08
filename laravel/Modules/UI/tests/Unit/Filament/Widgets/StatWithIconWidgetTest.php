<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Modules\UI\Filament\Widgets\StatWithIconWidget;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    // @var mixed widget = new StatWithIconWidget(;
});

test('stat with icon widget extends filament widget', function () {
    expect(// @var mixed widget;
});

test('stat with icon widget can be instantiated', function () {
    expect(// @var mixed widget;
});

test('stat with icon widget has correct view', function () {
    $view = // @var mixed widget->render(;

    expect($view)->toBeInstanceOf(View::class)
        ->and($view->name())->toBe('ui::filament.widgets.statwithicon');
});

test('stat with icon widget has proper properties', function () {
    expect(// @var mixed widget;
    expect(// @var mixed widget;
    expect(// @var mixed widget;
});

test('stat with icon widget can render', function () {
    $view = // @var mixed widget->render(;

    expect($view)->toBeInstanceOf(View::class);
});

test('stat with icon widget has default values', function () {
    expect(// @var mixed widget;
});
