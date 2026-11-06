<?php

declare(strict_types=1);

it('GET /it/auth/logout_fixed acceptable', function (): void {
    $res = $this->get('/it/auth/logout_fixed');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
