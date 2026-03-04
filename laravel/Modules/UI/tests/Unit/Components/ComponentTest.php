<?php

declare(strict_types=1);

uses(Modules\UI\Tests\TestCase::class);

use Illuminate\View\Component;

test('ui components can be rendered', function () {
    $component = new class extends Component
    {
        public function render()
        {
            return view('ui::components.ui.button');
        }
    };

    expect($component)->toBeInstanceOf(Component::class);
});

test('ui button component has correct attributes', function () {
    $view = view('ui::components.ui.button', [
        'type' => 'primary',
        'size' => 'md',
        'disabled' => false,
        'slot' => 'Click me',
    ]);

    expect($view->render())->toContain('Click me')
        ->toContain('inline-flex')
        ->toContain('bg-gray-800');
});

test('ui card component renders content', function () {
    $view = view('ui::components.ui.card', [
        'title' => 'Test Card',
        'content' => 'Test Content',
    ]);

    expect($view->render())->toContain('Test Card')->toContain('Test Content');
});
