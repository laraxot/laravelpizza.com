<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Province;
use Sushi\Sushi;

describe('Province Business Logic', function () {
    test('province extends base model', function () {
        expect(Province::class)->toBeSubclassOf(BaseModel::class);
    });

    test('province has factory trait for testing', function () {
        $traits = class_uses(Province::class);

        expect($traits)->toHaveKey(HasFactory::class);
    });

    test('province uses sushi trait for in-memory data', function () {
        $traits = class_uses(Province::class);

        expect($traits)->toHaveKey(Sushi::class);
    });

    test('province has schema definition for geographic hierarchy', function () {
        $province = new Province;

        expect($province)->toHaveProperty('schema');
        expect($province->schema['region_id'])->toBe('integer');
        expect($province->schema['id'])->toBe('integer');
        expect($province->schema['name'])->toBe('string');
    });

    test('province can get rows from comune data', function () {
        $province = new Province;

        expect(method_exists($province, 'getRows'))->toBeTrue();
        expect($province->getRows())->toBeArray();
    });

    test('province model can be instantiated without errors', function () {
        $province = new Province;

        expect($province)->toBeInstanceOf(Province::class);
        expect($province)->toBeInstanceOf(BaseModel::class);
    });

    test('province can be queried by name', function () {
        $query = Province::whereName('Milano');

        expect($query)->toBeInstanceOf(Builder::class);
    });

    test('province can be queried by region id', function () {
        $query = Province::whereRegionId(1);

        expect($query)->toBeInstanceOf(Builder::class);
    });
});
