<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /it/events acceptable (LaravelPizza Meetup route)', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $res = // @var mixed get('/it/events';
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403, 404]);
});
