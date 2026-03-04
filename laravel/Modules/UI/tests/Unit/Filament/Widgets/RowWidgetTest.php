<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;
use Modules\UI\Filament\Widgets\RowWidget;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->widget = new class extends RowWidget
    {
    };
});

test('row widget extends filament widget', function () {
    expect($this->widget)->toBeInstanceOf(Widget::class);
});

test('row widget can be instantiated', function () {
    expect($this->widget)->toBeInstanceOf(RowWidget::class);
});

test('row widget has correct view', function () {
    $view = $this->widget->render();

    expect($view)->toBeInstanceOf(View::class)
        ->and($view->name())->toBe('ui::filament.widgets.row');
});

test('row widget has proper properties', function () {
    expect($this->widget)->toHaveProperty('grid');
    expect($this->widget)->toHaveProperty('widgets');
});

test('row widget can render', function () {
    $view = $this->widget->render();

    expect($view)->toBeInstanceOf(View::class);
});
