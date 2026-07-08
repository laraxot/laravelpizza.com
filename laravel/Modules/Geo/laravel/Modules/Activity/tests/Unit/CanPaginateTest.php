<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Filament\Tables\Enums\PaginationMode;
use Modules\Activity\Filament\Pages\Concerns\CanPaginate;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Can Paginate', function (): void {
    test('trait exists', function (): void {
        /** @var TestCase $this */
        Assert::assertTrue(trait_exists(CanPaginate::class));
    });

    test('trait has pagination methods', function (): void {
        // Check that trait has required methods
        $methods = [
            'updatedRecordsPerPage',
            'getRecordsPerPage',
            'getTablePage',
            'getDefaultRecordsPerPageSelectOption',
            'getPaginationPageName',
            'getPerPageSessionKey',
            'paginateQuery',
            'getRecordsPerPageSelectOptions',
        ];

        foreach ($methods as $method) {
            Assert::assertTrue(
                method_exists(CanPaginate::class, $method),
                "Method {$method} should exist in CanPaginate trait"
            );
        }
    });

    test('default pagination options return array', function (): void {
        // Test the default pagination options via reflection
        /** @var TestCase $this */
        $trait = new class()
        {
            use CanPaginate;

            public function resetLivewirePage(): void {}

            public function getPage(string $pageName): int
            {
                return 1;
            }

            public function getPaginationMode(): PaginationMode
            {
                return PaginationMode::Default;
            }

            /**
             * @return array<int|string>
             */
            public function test_get_records_per_page_select_options(): array
            {
                return $this->getRecordsPerPageSelectOptions();
            }
        };

        $options = $trait->test_get_records_per_page_select_options();
        Assert::assertEquals([10, 25, 50], $options);
    });
});
