<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);
use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Models\Conf;

use function Safe\class_uses;

use Sushi\Sushi;

describe('Conf Business Logic', function (): void {
    test('conf extends eloquent model', function (): void {
        expect(Conf::class)->toBeSubclassOf(Model::class);
    });

    test('conf uses sushi trait for in-memory data', function (): void {
        $traits = class_uses(Conf::class);

        expect($traits)->toHaveKey(Sushi::class);
    });

    test('conf has expected fillable fields', function (): void {
        $conf = new Conf();
        $expectedFillable = [
            'id',
            'name',
        ];

        expect($conf->getFillable())->toEqual($expectedFillable);
    });

    test('conf uses name as route key', function (): void {
        $conf = new Conf();

        expect($conf->getRouteKeyName())->toBe('name');
    });

    test('conf can get rows from tenant service', function (): void {
        $conf = new Conf();

        expect(method_exists($conf, 'getRows'))->toBeTrue();
        expect($conf->getRows())->toBeArray();
    });
});
