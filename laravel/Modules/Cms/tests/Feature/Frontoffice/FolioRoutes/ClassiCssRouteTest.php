<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/classi-css acceptable', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = $this->get('/it/classi-css');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
