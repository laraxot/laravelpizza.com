<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/auth/register is reachable', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/auth/register');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
