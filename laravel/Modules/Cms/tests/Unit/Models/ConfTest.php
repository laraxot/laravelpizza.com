<?php

declare(strict_types=1);

use Modules\Cms\Models\Conf;
use PHPUnit\Framework\Assert;

test('Conf model can be instantiated', function () {
    Assert::assertSame(Conf::class, (new Conf)::class);

});

test('Conf model has expected fillable fields', function () {
    $conf = new Conf;

    $fillable = $conf->getFillable();

    Assert::assertContains('id', $fillable);

    Assert::assertContains('name', $fillable);
});

test('Conf model has name as route key', function () {
    $conf = new Conf;

    Assert::assertSame('name', $conf->getRouteKeyName());
});

test('Conf model uses Sushi trait', function () {
    $reflection = new ReflectionClass(Conf::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(Sushi\Sushi::class, $traits));
});
