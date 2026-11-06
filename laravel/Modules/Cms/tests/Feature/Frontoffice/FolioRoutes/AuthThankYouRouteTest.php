<?php

declare(strict_types=1);

it('GET /it/auth/thank-you acceptable', function (): void {
    $res = $this->get('/it/auth/thank-you');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
