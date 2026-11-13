<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Geo\Actions\GeoData\CheckGeoDataIntegrityAction;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class, WithFaker::class);

describe('CheckGeoDataIntegrityAction', function () {
    it('returns true for valid geo data', function () {
        $validData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [
                        [
                            'name' => 'Milano',
                            'code' => 'MI',
                            'cities' => [
                                ['name' => 'Milano', 'code' => '015146', 'cap' => '20100'],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = app(CheckGeoDataIntegrityAction::class)->execute($validData);

        expect($result)->toBeTrue();
    });

    it('returns false for missing regions', function () {
        $result = app(CheckGeoDataIntegrityAction::class)->execute([]);

        expect($result)->toBeFalse();
    });

    it('returns false for non-array regions', function () {
        $result = app(CheckGeoDataIntegrityAction::class)->execute(['regions' => 'invalid']);

        expect($result)->toBeFalse();
    });

    it('returns false for empty regions array', function () {
        $result = app(CheckGeoDataIntegrityAction::class)->execute(['regions' => []]);

        expect($result)->toBeFalse();
    });

    it('validates each region has required fields', function () {
        $invalidData = [
            'regions' => [
                ['name' => 'Test'], // missing code, provinces
            ],
        ];

        $result = app(CheckGeoDataIntegrityAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('validates each province has required fields', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Test',
                    'code' => 'TS',
                    'provinces' => [['name' => 'Prov']], // missing code, cities
                ],
            ],
        ];

        $result = app(CheckGeoDataIntegrityAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('validates each city has required fields', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Test',
                    'code' => 'TS',
                    'provinces' => [
                        [
                            'name' => 'Prov',
                            'code' => 'PV',
                            'cities' => [['cap' => '12345']], // missing name
                        ],
                    ],
                ],
            ],
        ];

        $result = app(CheckGeoDataIntegrityAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });
});
