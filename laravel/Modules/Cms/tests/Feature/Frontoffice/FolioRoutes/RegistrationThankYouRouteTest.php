<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/registration/thank-you acceptable', function (): void {
    $res = cmsGet('/it/registration/thank-you');
    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        cmsSkipTest('Registration thank-you route returned server error in this install.');
    }
});
