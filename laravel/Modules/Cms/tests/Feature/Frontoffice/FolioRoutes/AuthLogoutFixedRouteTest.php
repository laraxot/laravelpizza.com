<?php

declare(strict_types=1);

use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('GET /it/auth/logout_fixed acceptable', function (): void {
    /** @var TestResponse<Response> $res */
    $res = cmsGet('/it/auth/logout_fixed');
    $status = (int) $res->getStatusCode();
    Assert::assertTrue(
        in_array($status, [200, 204, 301, 302, 303, 307, 308, 401, 403, 404], true),
        'Unexpected status for /it/auth/logout_fixed: '.$status,
    );
});
