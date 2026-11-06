<?php

declare(strict_types=1);

it('GET /it/errors/password-expired acceptable', function (): void {
    $res = $this->get('/it/errors/password-expired');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);
});
