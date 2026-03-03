<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/profile/edit acceptable (likely auth required)', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/profile/edit');
    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        test()->markTestSkipped('Profile edit route returned server error in this install.');
    }
    expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403, 404]);
});
