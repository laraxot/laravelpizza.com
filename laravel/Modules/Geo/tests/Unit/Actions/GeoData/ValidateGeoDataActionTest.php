<?php

declare(strict_types=1);

use Illuminate\Foundation\Testing\WithFaker;
use Modules\Geo\Actions\GeoData\ValidateGeoDataAction;
<<<<<<< .merge_file_pq0qjY
use Modules\Geo\Tests\TestCase;

uses(TestCase::class, WithFaker::class);

=======
<<<<<<< .merge_file_oLmurf
use Modules\Geo\Infrastructure\Validation\GeoDataValidationRules;
use Tests\TestCase;

uses(TestCase::class, WithFaker::class);

beforeEach(function () {
    $this->action = app(ValidateGeoDataAction::class);
    $this->rules = new GeoDataValidationRules;
});

=======
use Modules\Geo\Tests\TestCase;

uses(TestCase::class, WithFaker::class);

>>>>>>> .merge_file_s8kieq
>>>>>>> .merge_file_nljes1
describe('ValidateGeoDataAction', function () {
    it('validates correct geo data structure', function () {
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
                                ['name' => 'Sesto San Giovanni', 'code' => '015207', 'cap' => '20099'],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($validData);

        expect($result)->toBeTrue();
    });

    it('rejects data without regions key', function () {
        $invalidData = ['provinces' => []];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects data with non-array regions', function () {
        $invalidData = ['regions' => 'not-an-array'];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects region without name', function () {
        $invalidData = [
            'regions' => [
                ['code' => '03', 'provinces' => []],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects region without code', function () {
        $invalidData = [
            'regions' => [
                ['name' => 'Lombardia', 'provinces' => []],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects region with invalid code length', function () {
        $invalidData = [
            'regions' => [
                ['name' => 'Lombardia', 'code' => '030', 'provinces' => []], // 3 chars instead of 2
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects region without provinces', function () {
        $invalidData = [
            'regions' => [
                ['name' => 'Lombardia', 'code' => '03'],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects province without name', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [['code' => 'MI', 'cities' => []]],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects province without code', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [['name' => 'Milano', 'cities' => []]],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects province without cities', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [['name' => 'Milano', 'code' => 'MI']],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects city without name', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [
                        [
                            'name' => 'Milano',
                            'code' => 'MI',
                            'cities' => [['code' => '015146', 'cap' => '20100']],
                        ],
                    ],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects city without code', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [
                        [
                            'name' => 'Milano',
                            'code' => 'MI',
                            'cities' => [['name' => 'Milano', 'cap' => '20100']],
                        ],
                    ],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects city without cap', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [
                        [
                            'name' => 'Milano',
                            'code' => 'MI',
                            'cities' => [['name' => 'Milano', 'code' => '015146']],
                        ],
                    ],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('rejects city with invalid cap length', function () {
        $invalidData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [
                        [
                            'name' => 'Milano',
                            'code' => 'MI',
                            'cities' => [['name' => 'Milano', 'code' => '015146', 'cap' => '2010']], // 4 digits
                        ],
                    ],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($invalidData);

        expect($result)->toBeFalse();
    });

    it('accepts city with valid cap (5 digits)', function () {
        $validData = [
            'regions' => [
                [
                    'name' => 'Lombardia',
                    'code' => '03',
                    'provinces' => [
                        [
                            'name' => 'Milano',
                            'code' => 'MI',
                            'cities' => [['name' => 'Milano', 'code' => '015146', 'cap' => '20100']],
                        ],
                    ],
                ],
            ],
        ];

        $result = app(ValidateGeoDataAction::class)->execute($validData);

        expect($result)->toBeTrue();
    });
});
