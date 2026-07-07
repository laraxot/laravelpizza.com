<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);
it('GET / redirects to /{locale}', function (): void {
    $locale = app()->getLocale();
    cmsGet('/')->assertRedirect('/'.$locale);
});
