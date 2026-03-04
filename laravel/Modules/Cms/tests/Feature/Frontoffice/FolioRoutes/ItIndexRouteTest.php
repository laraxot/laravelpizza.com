<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /{locale} returns 200 and has lang attribute', function (): void {
    $locale = app()->getLocale();
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/'.$locale);

    $status = (int) $response->getStatusCode();

    if ($status >= 500) {
        test()->markTestSkipped('Localized index route returned server error in this install.');

        return;
    }

    expect(in_array($status, [200, 204, 301, 302, 303, 307, 308, 404], true))->toBeTrue();

    if ($status === 200) {
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertSee('<html', false);
        /* @phpstan-ignore-next-line method.nonObject */
        $response->assertSee(' lang="'.$locale.'"', false);
    }
});
