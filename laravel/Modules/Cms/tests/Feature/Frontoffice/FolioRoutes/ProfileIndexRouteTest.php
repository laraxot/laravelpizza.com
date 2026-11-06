<?php

declare(strict_types=1);

it('GET /it/profile acceptable (likely auth required)', function (): void {
    $res = $this->get('/it/profile');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
