<?php

declare(strict_types=1);

it('GET /it/auth/register is reachable', function (): void {
    $res = $this->get('/it/auth/register');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
