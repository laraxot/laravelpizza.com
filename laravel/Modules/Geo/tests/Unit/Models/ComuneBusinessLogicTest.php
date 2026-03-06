<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Comune;
use Modules\Geo\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJson;
use ReflectionClass;

uses(TestCase::class);

describe('Comune Business Logic', function () {
    test('comune extends base model', function () {
        expect(is_subclass_of(Comune::class, BaseModel::class))->toBeTrue();
    });

    test('comune has factory trait for testing', function () {
        $traits = class_uses_recursive(Comune::class);

        expect($traits)->toContain(HasFactory::class);
    });

    test('comune has sushi to json trait', function () {
        $traits = class_uses(Comune::class);

        expect($traits)->toHaveKey(SushiToJson::class);
    });

    test('comune has expected fillable fields for italian municipalities', function () {
        $comune = new Comune();
        $expectedFillable = [
            'id',
            'codice',
            'nome',
            'regione',
            'provincia',
            'sigla_provincia',
            'cap',
            'codice_catastale',
            'popolazione',
            'zona_altimetrica',
            'altitudine',
            'superficie',
            'lat',
            'lng',
        ];

        expect($comune->getFillable())->toEqual($expectedFillable);
    });

    test('comune has schema definition for structured geographic data', function () {
        $comune = new Comune();
        $reflection = new ReflectionClass($comune);
        $schemaProperty = $reflection->getProperty('schema');
        $schemaProperty->setAccessible(true);
        /** @var array<string, string> $schema */
        $schema = $schemaProperty->getValue($comune);

        expect($schema['zona'])->toBe('json');
        expect($schema['provincia'])->toBe('json');
        expect($schema['regione'])->toBe('json');
        expect($schema['cap'])->toBe('json');
    });

    test('comune has json directory property for data source', function () {
        $comune = new Comune();

        expect($comune)->toHaveProperty('jsonDirectory');
        expect($comune->jsonDirectory)->toBeString();
    });

    test('comune has translatable array configured', function () {
        $comune = new Comune();

        expect($comune->translatable)->toBeArray();
    });

    test('comune model can be instantiated without errors', function () {
        $comune = new Comune();

        expect($comune)->toBeInstanceOf(Comune::class);
        expect($comune)->toBeInstanceOf(BaseModel::class);
    });
});
