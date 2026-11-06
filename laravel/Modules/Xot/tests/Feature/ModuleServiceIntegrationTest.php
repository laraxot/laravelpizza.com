<?php

declare(strict_types=1);
use Illuminate\Support\Str;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\QueueableAction\QueueableAction;

use function Safe\class_uses;

uses(TestCase::class);

describe('GetAllModelsByModuleNameAction Integration', function () {
    it('integrates with Nwidart Modules system', function () {
        Assert::assertTrue(class_exists('Nwidart\Modules\Facades\Module'));
        Assert::assertTrue(class_exists('Nwidart\Modules\Module'));
    });

    it('can find existing modules', function () {
        $action = app(GetAllModelsByModuleNameAction::class);

        Assert::assertInstanceOf(GetAllModelsByModuleNameAction::class, $action);
    });

    it('returns models from existing modules', function () {
        // Il modulo Chart non esiste in questo repo: si usa un modulo presente con app/Models.
        $models = app(GetAllModelsByModuleNameAction::class)->execute('User');

        $hasUserModel = false;
        foreach ($models as $modelClass) {
            if (str_contains($modelClass, 'User\\Models\\User')) {
                $hasUserModel = true;
                break;
            }
        }

        Assert::assertTrue($hasUserModel);
    });

    it('handles User module models correctly', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('User');

        $hasUserModels = false;
        foreach (array_values($models) as $modelClass) {
            if (str_contains($modelClass, 'User\\Models\\')) {
                $hasUserModels = true;
                break;
            }
        }

        Assert::assertTrue($hasUserModels);
    });

    it('filters abstract models correctly', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('Xot');

        // BaseModel should not be included (it's abstract)
        $modelNames = array_keys($models);
        Assert::assertStringNotContainsString('base_model', implode(',', $modelNames));
    });

    it('returns class strings as keys and values', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('Xot');

        foreach ($models as $key => $modelClass) {
            Assert::assertIsString($key);
            Assert::assertIsString($modelClass);
            Assert::assertTrue(str_contains($modelClass, 'Modules\\'));
        }
    });

    it('handles reflection operations safely', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('Xot');

        foreach ($models as $modelClass) {
            Assert::assertTrue(class_exists($modelClass) || interface_exists($modelClass));
        }
    });

    it('handles snake_case conversion correctly', function () {
        $snakeCase = Str::snake('TestModelName');

        Assert::assertSame('test_model_name', $snakeCase);
    });

    it('integrates with Laravel filesystem', function () {
        Assert::assertTrue(class_exists('Illuminate\Support\Facades\File'));
    });

    it('can handle multiple module names', function () {
        $action = app(GetAllModelsByModuleNameAction::class);

        foreach (['Chart', 'User', 'Xot', 'Job'] as $moduleName) {
            $models = $action->execute($moduleName);
            Assert::assertIsArray($models);
        }
    });

    it('returns an empty array for a non-existent module', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('NonExistentModule');

        Assert::assertEmpty($models);
    });

    it('handles namespace construction correctly', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('User');

        Assert::assertNotEmpty($models);
        foreach ($models as $modelClass) {
            Assert::assertStringContainsString('Modules\\User\\', $modelClass);
        }
    });

    it('handles edge case module names gracefully', function () {
        $action = app(GetAllModelsByModuleNameAction::class);

        foreach (['', 'InvalidModule', 'Test123'] as $moduleName) {
            Assert::assertIsArray($action->execute($moduleName));
        }
    });

    it('validates return type consistency', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('Xot');

        foreach ($models as $key => $value) {
            Assert::assertIsString($key);
            Assert::assertIsString($value);
            Assert::assertGreaterThan(0, strlen($key));
            Assert::assertGreaterThan(0, strlen($value));
        }
    });

    it('can be resolved from the Laravel service container', function () {
        $action = app(GetAllModelsByModuleNameAction::class);

        Assert::assertInstanceOf(GetAllModelsByModuleNameAction::class, $action);
    });

    it('returns consistent results across repeated calls', function () {
        $action = app(GetAllModelsByModuleNameAction::class);
        $results = [
            $action->execute('Xot'),
            $action->execute('Xot'),
            $action->execute('Xot'),
        ];

        Assert::assertSame($results[0], $results[1]);
        Assert::assertSame($results[0], $results[2]);
    });

    it('validates module path resolution', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('Xot');

        foreach ($models as $modelClass) {
            Assert::assertMatchesRegularExpression('/^Modules\\\\[A-Za-z]+\\\\Models\\\\[A-Za-z]+$/', $modelClass);
        }
    });

    it('integrates with Laravel string helpers', function () {
        Assert::assertTrue(class_exists('Illuminate\Support\Str'));
        Assert::assertSame('TestString', Str::studly('test_string'));
    });

    it('uses the QueueableAction trait for sync/async execution', function () {
        Assert::assertContains(
            QueueableAction::class,
            class_uses(GetAllModelsByModuleNameAction::class),
        );
    });

    it('can discover models within a time budget', function () {
        $startTime = microtime(true);

        app(GetAllModelsByModuleNameAction::class)->execute('Xot');

        $executionTime = microtime(true) - $startTime;

        Assert::assertLessThan(5.0, $executionTime);
    });
});
