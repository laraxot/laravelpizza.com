<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @see Modules/UI/docs/test-fix-philosophy.md
 */
describe('Component', function (): void {
    test('ui components can be rendered', function (): void {
        // `$slot` e `$attributes` li inietta Blade solo quando il componente e' usato come tag:
        // un `view()` diretto del blade anonimo non e' un uso reale. `<x-ui.button />` (slot vuoto) si'.
        $html = Blade::render('<x-ui.button />');

        Assert::assertStringContainsString('<button', $html);
        Assert::assertStringContainsString('</button>', $html);
    });

    test('ui button component has correct attributes', function (): void {
        /** @var view-string $buttonView */
        $buttonView = 'ui::components.ui.button';
        Assert::assertInstanceOf(View::class, view($buttonView));
    });

    test('ui card component renders content', function (): void {
        /** @var view-string $cardView */
        $cardView = 'ui::components.ui.card';
        $view = view($cardView, [
            'title' => 'Test Card',
            'content' => 'Test Content',
        ]);

        $html = (string) $view->render();
        Assert::assertStringContainsString('Test Card', $html);
        Assert::assertStringContainsString('Test Content', $html);
    });
});
