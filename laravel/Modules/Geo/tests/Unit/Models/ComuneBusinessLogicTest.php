<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Comune;
use Modules\Tenant\Models\Traits\SushiToJson;

describe('Comune Business Logic', function () {
    test('comune extends base model', function () {
        expect(Comune::class)->toBeSubclassOf(BaseModel::class);
    });

    test('comune has factory trait for testing', function () {
        $traits = class_uses(Comune::class);

        expect($traits)->toHaveKey(HasFactory::class);
    });

    test('comune has sushi to json trait', function () {
        $traits = class_uses(Comune::class);

        expect($traits)->toHaveKey(SushiToJson::class);
    });

    test('comune has expected fillable fields for italian municipalities', function () {
        $comune = new Comune;
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
        $comune = new Comune;

        expect($comune)->toHaveProperty('schema');
        expect($comune->schema['zona'])->toBe('json');
        expect($comune->schema['provincia'])->toBe('json');
        expect($comune->schema['regione'])->toBe('json');
        expect($comune->schema['cap'])->toBe('json');
    });

    test('comune has json directory property for data source', function () {
        $comune = new Comune;

        expect($comune)->toHaveProperty('jsonDirectory');
        expect($comune->jsonDirectory)->toBeString();
    });

    test('comune has translatable array configured', function () {
        $comune = new Comune;

        expect($comune->translatable)->toBeArray();
    });

    test('comune model can be instantiated without errors', function () {
        $comune = new Comune;

        expect($comune)->toBeInstanceOf(Comune::class);
        expect($comune)->toBeInstanceOf(BaseModel::class);
    });
});
