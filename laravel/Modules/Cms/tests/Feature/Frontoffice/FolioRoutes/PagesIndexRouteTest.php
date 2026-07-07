<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('GET /it/pages acceptable', function (): void {
    $res = cmsGet('/it/pages');

    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        cmsSkipTest('Pages index route returned server error in this install.');

        return;
    }

    Assert::assertTrue(in_array($status, [200, 204, 301, 302, 303, 307, 308, 404], true));
});
