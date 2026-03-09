<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/profile/edit acceptable (likely auth required)', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/profile/edit');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
