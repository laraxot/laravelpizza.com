<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Traits;

use Modules\UI\Enums\TableLayoutEnum;
use Modules\UI\Filament\Traits\HasTableLayoutPage;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('exposes table layout page trait for cross-module consumers', function (): void {
    $page = new class {
        use HasTableLayoutPage;

        public TableLayoutEnum $layoutView = TableLayoutEnum::GRID;
    };

    Assert::assertTrue(HasTableLayoutPage::isLayoutCapable($page));
    Assert::assertSame(TableLayoutEnum::GRID, HasTableLayoutPage::readLayoutFrom($page));

    HasTableLayoutPage::applyLayoutTo($page, TableLayoutEnum::LIST);
    Assert::assertSame(TableLayoutEnum::LIST, HasTableLayoutPage::readLayoutFrom($page));
});
