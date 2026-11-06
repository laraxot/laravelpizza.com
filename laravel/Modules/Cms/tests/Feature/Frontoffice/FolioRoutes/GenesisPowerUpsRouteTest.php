<?php

declare(strict_types=1);

it('GET /it/genesis/power-ups acceptable', function (): void {
    $res = $this->get('/it/genesis/power-ups');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
