<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Page;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(TestCase::class);

describe('Page Business Logic', function (): void {
    test('page has expected fillable fields', function (): void {
        $page = new Page();
        $expectedFillable = [
            'content',
            'description',
            'slug',
            'title',
            'middleware',
            'content_blocks',
            'sidebar_blocks',
            'footer_blocks',
        ];

        Assert::assertEquals($expectedFillable, $page->getFillable());
    });

    test('page has sushi to json trait', function (): void {
        $traits = class_uses(Page::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    });

    test('page has correct casts for blocks and arrays', function (): void {
        $page = new Page();
        $casts = $page->getCasts();

        Assert::assertSame('array', $casts['content_blocks']);
        Assert::assertSame('array', $casts['sidebar_blocks']);
        Assert::assertSame('array', $casts['footer_blocks']);
        Assert::assertSame('array', $casts['middleware']);
    });

    test('page has schema definition for structured data', function (): void {
        $page = new Page();

        $reflection = new \ReflectionClass($page);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($page);
        Assert::assertSame('json', $schema['content_blocks']);
        Assert::assertSame('json', $schema['sidebar_blocks']);
        Assert::assertSame('json', $schema['footer_blocks']);
    });
});
