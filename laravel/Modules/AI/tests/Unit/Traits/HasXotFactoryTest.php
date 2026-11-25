<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Xot\Models\Module;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * Regression guard: HasXotFactory::factory() has been accidentally deleted and
 * restored 3 times in one session (2026-09-06/07) by different concurrent agents,
 * each time breaking Model::factory() across nearly every module in the monorepo
 * (XotBaseModel uses this trait). This test exists so that regression fails loudly
 * here instead of being silently rediscovered module by module — if factory() is
 * missing again, this throws BadMethodCallException instead of silently passing.
 *
 * See docs/chat/2026-09-06-hasxotfactory-factory-method-deleted-root-cause.md and
 * second-brain memory project_hasxotfactory_missing_static_factory_method.md.
 */
test('a concrete model using only HasXotFactory can call factory() at runtime without a newFactory override', function (): void {
    $factory = Module::factory();

    Assert::assertInstanceOf(Factory::class, $factory);
});
