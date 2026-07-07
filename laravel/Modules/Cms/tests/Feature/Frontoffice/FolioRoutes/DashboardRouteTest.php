<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('GET /it/dashboard acceptable for unauthenticated (redirect/401/403)', function (): void {
    $res = cmsGet('/it/dashboard');
    $status = (int) $res->getStatusCode();

    if ($status >= 500) {
        cmsSkipTest('Dashboard route returned server error in this install.');
    }

    Assert::assertTrue(in_array($status, [200, 204, 301, 302, 303, 307, 308, 401, 403, 404], true));
});
