<?php

declare(strict_types=1);

use Illuminate\Support\Str;
use Modules\Xot\Actions\Model\GetAllModelsByModuleNameAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * `Modules\Xot\Services\ModuleService::setName($m)->getModels()` non esiste piu' (niente Services):
 * il suo compito, elencare i model concreti di un modulo, e' di GetAllModelsByModuleNameAction.
 * Il nome del file resta quello storico; i casi coperti sono il contratto del vecchio servizio.
 */
describe('GetAllModelsByModuleNameAction (ex ModuleService::getModels)', function () {
    it('returns an empty list for a module that is not registered', function () {
        Assert::assertSame([], app(GetAllModelsByModuleNameAction::class)->execute('NonExistentModule'));
    });

    it('keys every concrete model by the snake_case basename of its class', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('Xot');

        Assert::assertNotEmpty($models);
        foreach ($models as $key => $class) {
            Assert::assertStringStartsWith('Modules\\Xot\\Models\\', $class);
            Assert::assertSame(Str::snake(class_basename($class)), $key);
        }
    });

    it('filters abstract classes out', function () {
        $models = app(GetAllModelsByModuleNameAction::class)->execute('Xot');

        Assert::assertArrayNotHasKey('base_model', $models);
        foreach ($models as $class) {
            Assert::assertFalse((new ReflectionClass($class))->isAbstract());
        }
    });
});
