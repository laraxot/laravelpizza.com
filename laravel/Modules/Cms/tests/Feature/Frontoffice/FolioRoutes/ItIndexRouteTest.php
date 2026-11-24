<?php

declare(strict_types=1);
use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /{locale} returns 200 and has lang attribute', function (): void {
    $locale = app()->getLocale();
    $response = $this->get('/'.$locale);
    $response->assertStatus(200);
    $response->assertSee('<html', false);
    $response->assertSee(' lang="'.$locale.'"', false);
});
