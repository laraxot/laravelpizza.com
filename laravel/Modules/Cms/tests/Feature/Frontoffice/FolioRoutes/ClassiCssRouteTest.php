<?php

declare(strict_types=1);

it('GET /it/classi-css acceptable', function (): void {
    $res = $this->get('/it/classi-css');
    expect($res->getStatusCode())->toBeIn([200, 204, 301, 302, 303, 307, 308]);
});
