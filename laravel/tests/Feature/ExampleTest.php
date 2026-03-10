<?php

declare(strict_types=1);

uses(Tests\TestCase::class);

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertRedirect();
});
