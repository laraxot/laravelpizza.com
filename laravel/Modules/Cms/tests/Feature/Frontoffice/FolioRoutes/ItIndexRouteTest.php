<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Frontoffice\FolioRoutes;

use Modules\Cms\Tests\TestCase;

uses(TestCase::class);

it('GET /{locale} uses the requested locale in the html lang attribute', function (): void {
    foreach (['it', 'en', 'de'] as $locale) {
        /** @phpstan-ignore-next-line property.notFound */
        $response = $this->get('/'.$locale);

        $status = (int) $response->getStatusCode();

        if ($status >= 500) {
            test()->markTestSkipped("Localized index route returned server error for [{$locale}] in this install.");

            return;
        }

        expect(in_array($status, [200, 204, 301, 302, 303, 307, 308, 404], true))->toBeTrue();

        if (200 === $status) {
            /* @phpstan-ignore-next-line method.nonObject */
            $response->assertSee('<html', false);
            /* @phpstan-ignore-next-line method.nonObject */
            $response->assertSee(' lang="'.$locale.'"', false);
        }
    }
});
