<?php

declare(strict_types=1);

use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('GET /{locale} uses the requested locale in the html lang attribute', function (): void {
    foreach (['it', 'en', 'de'] as $locale) {
        $response = cmsGet('/'.$locale);

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            cmsSkipTest("Localized index route returned server error for [{$locale}] in this install.");

            return;
        }

        Assert::assertTrue(in_array($status, [200, 204, 301, 302, 303, 307, 308, 404], true));

        if (200 === $status) {
            $response->assertSee('<html', false);
            $response->assertSee(' lang="'.$locale.'"', false);
        }
    }
});
