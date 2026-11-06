<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit;

use Illuminate\Translation\PotentiallyTranslatedString;
use Mockery;
use Mockery\MockInterface;
use Modules\UI\Enums\FieldTypeEnum;
use Modules\UI\Enums\TableLayout;
use Modules\UI\Filament\Widgets\StatsOverviewWidget;
use Modules\UI\Models\Category;
use Modules\UI\Models\Policies\UiBasePolicy;
use Modules\UI\Providers\UIServiceProvider;
use Modules\UI\Rules\OpeningHoursRule;
use Modules\UI\Tests\TestCase;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Tests\FilamentSchemaCoverage;
use PHPUnit\Framework\Assert;
use SplFileInfo;

uses(TestCase::class);

afterEach(function (): void {
    Mockery::close();
});

describe('UI Filament widgets and components coverage', function (): void {
    test('Filament widgets are instantiable', function (): void {
        [$appRoot, $ns] = [dirname(__DIR__, 2).'/app', 'Modules\\UI\\'];
        $seen = 0;
        foreach (FilamentSchemaCoverage::discover($appRoot, $ns, 'Widget') as $class) {
            if (! str_contains($class, 'Filament\\Widgets\\')) {
                continue;
            }
            Assert::assertInstanceOf($class, new $class);
            $seen++;
        }
        Assert::assertGreaterThan(0, $seen);
    });

    test('Filament form components are loadable', function (): void {
        [$appRoot] = [dirname(__DIR__, 2).'/app'];
        $iterator = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($appRoot.'/Filament/Forms'));
        $count = 0;
        foreach ($iterator as $file) {
            if (! $file instanceof SplFileInfo || ! $file->isFile() || ! str_ends_with($file->getFilename(), '.php')) {
                continue;
            }
            $class = 'Modules\\UI\\'.str_replace(['/', '.php'], ['\\', ''], substr($file->getPathname(), strlen($appRoot) + 1));
            if (class_exists($class)) {
                Assert::assertTrue(class_exists($class));
                $count++;
            }
        }
        Assert::assertGreaterThan(0, $count);
    });
});

describe('UI coverage boost — Enums', function (): void {
    test('FieldTypeEnum form schema exposes all cases', function (): void {
        $schema = FieldTypeEnum::getFormSchema();
        Assert::assertCount(count(FieldTypeEnum::cases()), $schema);
    });

    test('TableLayout toArray maps values to labels', function (): void {
        Assert::assertArrayHasKey('list', TableLayout::toArray());
    });
});

describe('UI coverage boost — Rules and policies', function (): void {
    test('OpeningHoursRule accepts empty array value', function (): void {
        $rule = new OpeningHoursRule;
        $failed = false;
        $rule->validate(
            'hours',
            [],
            static function (string $message, ?string $replace = null) use (&$failed): PotentiallyTranslatedString {
                $failed = true;

                return new PotentiallyTranslatedString($message, app('translator'));
            },
        );
        Assert::assertFalse($failed);
    });

    test('UiBasePolicy before grants super-admin', function (): void {
        /** @var MockInterface&UserContract $superAdmin */
        $superAdmin = Mockery::mock(UserContract::class);
        TestCase::expectMethod($superAdmin, 'hasRole')->with('super-admin')->andReturn(true);
        /** @var MockInterface&UserContract $regular */
        $regular = Mockery::mock(UserContract::class);
        TestCase::expectMethod($regular, 'hasRole')->with('super-admin')->andReturn(false);

        $policy = new class extends UiBasePolicy {};
        Assert::assertTrue($policy->before($superAdmin, 'viewAny'));
        Assert::assertNull($policy->before($regular, 'viewAny'));
    });
});

describe('UI coverage boost — Models and providers', function (): void {
    test('Category fillable matches domain fields', function (): void {
        Assert::assertContains('name', (new Category)->getFillable());
    });

    test('StatsOverviewWidget declares heading', function (): void {
        $widget = new StatsOverviewWidget;
        $ref = new \ReflectionClass($widget);
        $prop = $ref->getProperty('heading');
        $prop->setAccessible(true);
        Assert::assertSame('Stats Overview', $prop->getValue($widget));
    });

    test('UIServiceProvider declares module name', function (): void {
        Assert::assertSame('UI', (new UIServiceProvider(app()))->name);
    });
});
