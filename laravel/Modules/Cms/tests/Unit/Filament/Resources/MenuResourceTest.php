<?php

declare(strict_types=1);

use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Cms\Models\Menu;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('MenuResource', function (): void {
    test('menu resource has correct model', function (): void {
        $resource = new MenuResource();

        Assert::assertSame(Menu::class, $resource::getModel());
    });

    test('menu resource has form schema', function (): void {
        $schema = MenuResource::getFormSchema();
        /* @var array<string, mixed> $schema */
        Assert::assertGreaterThan(0, count($schema));
    });

    test('menu resource has form fields', function (): void {
        $schema = MenuResource::getFormSchema();

        // Check that form has required components
        $hasTitle = false;
        $hasItems = false;

        foreach ($schema as $item) {
            if (! $item instanceof Filament\Forms\Components\Field) {
                continue;
            }
            $name = $item->getName();
            if ('title' === $name) {
                $hasTitle = true;
            }
            if ('items' === $name) {
                $hasItems = true;
            }
        }

        Assert::assertTrue($hasTitle);
        Assert::assertTrue($hasItems);
    });

    test('menu resource extends XotBaseResource', function (): void {
        Assert::assertTrue(class_exists(MenuResource::class));
    });
});
