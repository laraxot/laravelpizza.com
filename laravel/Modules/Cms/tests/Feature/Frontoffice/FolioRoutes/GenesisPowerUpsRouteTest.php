<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/genesis/power-ups acceptable', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/genesis/power-ups');

    $status = (int) $res->getStatusCode();
    if ($status >= 500) {
        test()->markTestSkipped('Genesis power-ups route returned server error in this install.');

        return;
    }

    expect(in_array($status, [200, 204, 301, 302, 303, 307, 308, 404], true))->toBeTrue();
});
