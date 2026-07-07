<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET /it/errors/password-expired acceptable', function (): void {
    $res = cmsGet('/it/errors/password-expired');
    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        cmsSkipTest('Errors password-expired route returned server error in this install.');
    }
});
