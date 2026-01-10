<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/auth/logout_fixed acceptable', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/auth/logout_fixed');
    /** @var Illuminate\Testing\TestResponse $res */
    $status = (int) $res->getStatusCode();
    $this->assertTrue(
        in_array($status, [200, 204, 301, 302, 303, 307, 308, 401, 403, 404], true),
        'Unexpected status for /it/auth/logout_fixed: '.$status,
    );
});
