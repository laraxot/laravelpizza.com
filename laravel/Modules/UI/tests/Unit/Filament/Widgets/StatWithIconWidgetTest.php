<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Filament\Widgets;

use Modules\UI\Filament\Widgets\StatWithIconWidget;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('stat with icon widget returns empty form schema', function (): void {
    $widget = new StatWithIconWidget;
    Assert::assertSame([], $widget->getFormSchema());
});
