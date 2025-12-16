<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /{locale} returns 200 and has lang attribute', function (): void {
    $locale = app()->getLocale();
    /** @phpstan-ignore-next-line property.notFound */
    $response = $this->get('/'.$locale);
    /* @phpstan-ignore-next-line method.nonObject */
    $response->assertStatus(200);
    /* @phpstan-ignore-next-line method.nonObject */
    $response->assertSee('<html', false);
    /* @phpstan-ignore-next-line method.nonObject */
    $response->assertSee(' lang="'.$locale.'"', false);
});
