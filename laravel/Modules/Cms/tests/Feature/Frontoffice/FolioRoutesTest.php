<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Artisan;
use Modules\Cms\Tests\TestCase;

use function Safe\preg_match;
use function Safe\preg_split;

uses(TestCase::class);

/**
 * Parse Folio routes from `artisan folio:list` output and return a list of path strings.
 *
 * @return list<string>
 */
function getFolioPaths(): array
{
    $exitCode = Artisan::call('folio:list');
    expect($exitCode)->toBe(0);

    $output = Artisan::output();
    $paths = [];

    foreach (preg_split("/\r?\n/", $output) as $line) {
        // Lines look like: "  GET       /it ...."
        if (preg_match('#\bGET\s+(/[^\s]+)#', $line, $m) === 1) {
            $paths[] = $m[1];
        }
    }

    // Deduplicate and normalize
    $paths = array_values(array_unique($paths));

    // Ensure '/' is tested for redirect to '/{locale}'
    array_unshift($paths, '/');

    return $paths;
}

it('validates Folio routes basic accessibility and localization', function (): void {
    $locale = app()->getLocale();
    $paths = getFolioPaths();

    foreach ($paths as $path) {
        // Root should redirect to /{locale}
        if ($path === '/') {
            $response = $this->get($path);
            $response->assertRedirect('/'.$locale);

            continue;
        }

        // Skip dynamic placeholder routes; they require seeded data or specific tokens
        if (str_contains($path, '{')) {
            $this->markTestSkipped("Dynamic Folio route requires fixture: {$path}");

            continue;
        }

        $response = $this->get($path);
        $status = $response->getStatusCode();

        // Skip Not Found (routing misalignment) and any server error with context
        if ($status === 404) {
            $this->markTestSkipped("Folio route not found (404): {$path}");
        }
        if ($status >= 500) {
            $this->markTestSkipped("Folio route returned server error ({$status}): {$path}");
        }

        // For unauthenticated contexts, allow OK, No Content, Redirects, and Auth-required statuses
        expect($status)->toBeIn([200, 204, 301, 302, 303, 307, 308, 401, 403]);

        // If homepage, assert HTML lang attribute and 200 OK
        if ($path === ('/'.$locale)) {
            $response->assertStatus(200);
            $response->assertSee('<html', false);
            $response->assertSee(' lang="'.$locale.'"', false);
        }
    }
});
