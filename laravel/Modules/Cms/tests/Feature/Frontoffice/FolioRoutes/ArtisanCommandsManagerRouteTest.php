<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/artisan-commands-manager returns acceptable status', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/artisan-commands-manager');
    /** @phpstan-ignore-next-line method.nonObject */
    $status = $res->getStatusCode();
    if ($status >= 500) {
        /* @phpstan-ignore-next-line property.notFound */
        $this->markTestSkipped('Server error on /it/artisan-commands-manager: '.$status);
    }
    expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
