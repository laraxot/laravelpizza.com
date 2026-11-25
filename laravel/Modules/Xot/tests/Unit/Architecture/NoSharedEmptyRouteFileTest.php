<?php

declare(strict_types=1);

/*
 * ADR docs/adr/0029-no-shared-empty-route-file.md.
 * Pure filesystem check: no Laravel bootstrap (avoids unrelated module.json conflicts).
 */

use function Safe\file_get_contents;
use function Safe\glob;

it('forbids require of Modules/Xot/routes/empty.php in module route files', function (): void {
    $modulesRoot = dirname(__DIR__, 4); // Architecture→Unit→tests→Xot→Modules
    $hits = [];
    foreach (glob($modulesRoot.'/*/routes/*.php') as $path) {
        if (! is_string($path)) {
            continue;
        }
        if (str_contains(file_get_contents($path), 'Xot/routes/empty')) {
            $hits[] = $path;
        }
    }

    expect($hits)->toBeEmpty(
        'Shared empty route require found (see Xot docs/adr/0029-no-shared-empty-route-file.md): '
        .implode(', ', $hits)
    );
});
