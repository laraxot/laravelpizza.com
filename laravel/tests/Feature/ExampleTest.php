<?php

declare(strict_types=1);
use Tests\TestCase;

uses(TestCase::class);

it('returns a successful response', function () {
    $response = $this->get('/');

    $response->assertRedirect();
});
