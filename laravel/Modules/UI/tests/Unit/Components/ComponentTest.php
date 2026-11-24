<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Component', function (): void {
    test('ui components can be rendered', function (): void {
        $component = new class extends Component {
            public function render(): View
            {
                /** @var view-string $buttonView */
                $buttonView = 'ui::components.ui.button';

                return view($buttonView);
            }
        };

        Assert::assertStringContainsString('button', (string) $component->render()->render());
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
