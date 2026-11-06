<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Geo\Actions\GeoData\CheckGeoDataIntegrityAction;
use Tests\TestCase;

uses(TestCase::class, WithFaker::class);

beforeEach(function () {
    $this->action = app(CheckGeoDataIntegrityAction::class);
});

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
                                ['name' => 'Milano', 'cap' => '20100'],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = $this->action->execute($validData);

        expect($result)->toBeTrue();
    });

    it('returns false for missing regions', function () {
        $result = $this->action->execute([]);

        expect($result)->toBeFalse();
    });

    it('returns false for non-array regions', function () {
        $result = $this->action->execute(['regions' => 'invalid']);

        expect($result)->toBeFalse();
    });

    it('returns false for empty regions array', function () {
        $result = $this->action->execute(['regions' => []]);

        expect($result)->toBeFalse();
    });

    it('validates each region has required fields', function () {
        $invalidData = [
            'regions' => [
                ['name' => 'Test'], // missing code, provinces
            ],
        ];

        $result = $this->action->execute($invalidData);

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

        $result = $this->action->execute($invalidData);

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

        $result = $this->action->execute($invalidData);

        expect($result)->toBeFalse();
    });
});
