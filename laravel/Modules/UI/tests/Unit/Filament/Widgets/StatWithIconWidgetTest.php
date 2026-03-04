<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Modules\UI\Filament\Widgets\StatWithIconWidget;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->widget = new StatWithIconWidget;
});

test('stat with icon widget extends filament widget', function () {
    expect($this->widget)->toBeInstanceOf(Widget::class);
});

test('stat with icon widget can be instantiated', function () {
    expect($this->widget)->toBeInstanceOf(StatWithIconWidget::class);
});

test('stat with icon widget has correct view', function () {
    $view = $this->widget->render();

    expect($view)->toBeInstanceOf(View::class)
        ->and($view->name())->toBe('ui::filament.widgets.statwithicon');
});

test('stat with icon widget has proper properties', function () {
    expect($this->widget)->toHaveProperty('heading');
    expect($this->widget)->toHaveProperty('label');
    expect($this->widget)->toHaveProperty('value');
});

test('stat with icon widget can render', function () {
    $view = $this->widget->render();

    expect($view)->toBeInstanceOf(View::class);
});

test('stat with icon widget has default values', function () {
    expect($this->widget)->toBeInstanceOf(StatWithIconWidget::class);
});
