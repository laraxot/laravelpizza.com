<?php

declare(strict_types=1);
use Modules\Xot\Models\Module;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

// Module e' un registry Sushi di sola lettura: le righe vengono da nwidart (getRows()),
// non si creano con una factory. Lo schema Sushi non ha le colonne della ModuleFactory.
it('legge i moduli nwidart dal registry Sushi', function () {
    $module = Module::query()->where('name', 'Xot')->first();

    Assert::assertInstanceOf(Module::class, $module);
    Assert::assertSame('Xot', $module->name);
});

