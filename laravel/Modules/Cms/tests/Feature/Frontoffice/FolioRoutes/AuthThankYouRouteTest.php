<?php

declare(strict_types=1);

uses(\Modules\Cms\Tests\TestCase::class);

it('GET /it/auth/thank-you remains absent after legacy page removal', function (): void {
    $res = $this->get('/it/auth/thank-you');
    expect($res->getStatusCode())->toBe(404);
});
