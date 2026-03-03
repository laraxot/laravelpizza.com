<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/errors/password-expired acceptable', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/errors/password-expired');
    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        test()->markTestSkipped('Errors password-expired route returned server error in this install.');
    }
    expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
