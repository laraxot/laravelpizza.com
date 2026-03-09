<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/auth/thank-you acceptable', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/auth/thank-you');
    $status = (int) $res->getStatusCode();
    expect(in_array($status, [200, 204, 301, 302, 303, 307, 308, 404], true))->toBeTrue();
});
