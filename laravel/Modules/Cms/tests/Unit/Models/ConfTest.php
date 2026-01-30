<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Conf;

test('Conf model can be instantiated', function () {
    $conf = new Conf();

    expect($conf)->toBeInstanceOf(Conf::class);
});

test('Conf model has expected fillable fields', function () {
    $conf = new Conf();

    $fillable = $conf->getFillable();

    expect($fillable)->toContain('id')
        ->and($fillable)->toContain('name');
});

test('Conf model has name as route key', function () {
    $conf = new Conf();

    expect($conf->getRouteKeyName())->toBe('name');
});

test('Conf model uses Sushi trait', function () {
    $reflection = new ReflectionClass(Conf::class);
    $traits = $reflection->getTraitNames();

    expect(in_array(Sushi\Sushi::class, $traits))->toBeTrue();
});
