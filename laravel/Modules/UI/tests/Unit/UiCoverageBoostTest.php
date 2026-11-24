<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Modules\UI\Enums\FieldTypeEnum;
use Modules\UI\Enums\TableLayout;
use Modules\UI\Filament\Widgets\StatsOverviewWidget;
use Modules\UI\Models\Category;
use Modules\UI\Providers\UIServiceProvider;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('UI coverage boost — Enums', function (): void {
    test('FieldTypeEnum form schema exposes all cases', function (): void {
        $schema = FieldTypeEnum::getFormSchema();

        Assert::assertCount(count(FieldTypeEnum::cases()), $schema);
        Assert::assertArrayHasKey(FieldTypeEnum::TEXT->value, $schema);
    });

    test('TableLayout toArray maps values to labels', function (): void {
        $array = TableLayout::toArray();

        Assert::assertArrayHasKey('list', $array);
        Assert::assertArrayHasKey('grid', $array);
        Assert::assertNotEmpty($array['list']);
    });
});

describe('UI coverage boost — Models', function (): void {
    test('Category fillable matches domain fields', function (): void {
        $fillable = (new Category())->getFillable();

        Assert::assertContains('name', $fillable);
        Assert::assertContains('is_active', $fillable);
    });
});

describe('UI coverage boost — Filament widgets', function (): void {
    test('StatsOverviewWidget declares heading', function (): void {
        $widget = new StatsOverviewWidget();
        $ref = new \ReflectionClass($widget);
        $prop = $ref->getProperty('heading');
        $prop->setAccessible(true);

        Assert::assertSame('Stats Overview', $prop->getValue($widget));
    });
});

describe('UI coverage boost — Providers', function (): void {
    test('UIServiceProvider declares module name', function (): void {
        $provider = new UIServiceProvider(app());

        Assert::assertSame('UI', $provider->name);
    });
});
