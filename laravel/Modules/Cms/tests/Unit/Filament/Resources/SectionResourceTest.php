<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\SectionResource;
use Modules\Cms\Models\Section;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('SectionResource', function (): void {
    test('section resource has correct model', function (): void {
        $resource = new SectionResource();

        Assert::assertSame(Section::class, $resource::getModel());
    });

    test('section resource has form schema', function (): void {
        $schema = SectionResource::getFormSchema();
        /* @var array<string, mixed> $schema */
        Assert::assertGreaterThan(0, count($schema));
    });

    test('section resource has form fields', function (): void {
        $schema = SectionResource::getFormSchema();

        // Check that form has required components (check array keys)
        Assert::assertContains('info', array_keys($schema));
        Assert::assertContains('blocks', array_keys($schema));
    });

    test('section resource extends LangBaseResource', function (): void {
        Assert::assertTrue(class_exists(SectionResource::class));
    });
});
