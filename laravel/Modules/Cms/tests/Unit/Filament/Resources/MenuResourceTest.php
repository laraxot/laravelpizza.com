<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Filament\Resources\MenuResource;
use Modules\Cms\Models\Menu;

describe('MenuResource', function (): void {
    test('menu resource has correct model', function (): void {
        $resource = new MenuResource();

        expect($resource::getModel())->toBe(Menu::class);
    });

    test('menu resource has form schema', function (): void {
        $schema = MenuResource::getFormSchema();

        expect($schema)->toBeArray();
        expect(count($schema))->toBeGreaterThan(0);
    });

    test('menu resource has form fields', function (): void {
        $schema = MenuResource::getFormSchema();

        // Check that form has required components
        $hasTitle = false;
        $hasItems = false;

        foreach ($schema as $item) {
            $name = $item->getName();
            if ('title' === $name) {
                $hasTitle = true;
            }
            if ('items' === $name) {
                $hasItems = true;
            }
        }

        expect($hasTitle)->toBeTrue();
        expect($hasItems)->toBeTrue();
    });

    test('menu resource extends XotBaseResource', function (): void {
        expect(is_subclass_of(MenuResource::class, Modules\Xot\Filament\Resources\XotBaseResource::class))->toBeTrue();
    });
});
