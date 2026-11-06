<?php

declare(strict_types=1);

it('GET /it/pages acceptable', function (): void {
    $res = $this->get('/it/pages');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
