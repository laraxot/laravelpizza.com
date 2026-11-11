<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Feature\App;

use Modules\Meetup\Tests\TestCase as MeetupTestCase;

uses(MeetupTestCase::class);

test('can render registration page', function (): void {
    $response = $this->get('/en/auth/register');
    expect($response->status())->toBe(200);
});
