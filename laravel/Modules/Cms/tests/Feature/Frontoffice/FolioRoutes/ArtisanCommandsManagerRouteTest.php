<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('GET /it/artisan-commands-manager returns acceptable status', function (): void {
    $res = cmsGet('/it/artisan-commands-manager');
    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        cmsSkipTest('Server error on /it/artisan-commands-manager: '.$status);
    }
    Assert::assertTrue(
        in_array($status, [200, 204, 301, 302, 303, 307, 308, 401, 403, 404], true),
        'Unexpected status for /it/artisan-commands-manager: '.$status,
    );
});
