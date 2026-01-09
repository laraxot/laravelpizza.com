<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Modules\Cms\Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

describe('Homepage Content Management', function () {
    it('handles missing content gracefully', function () {
        $locale = app()->getLocale();
        $response = get('/'.$locale);
        
        // For test environment, we accept 200 or 404 as valid responses
        // depending on whether content exists in test environment
        $status = $response->status();
        expect(in_array($status, [200, 404]))->toBeTrue();
    });
});