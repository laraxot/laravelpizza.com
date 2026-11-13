<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

/**
 * ptvx: Themes One/Zero — niente directory semantiche sotto pages/.
 * Contratto studiato da <nome progetto> Sixteen (forward-only); qui non si richiede [container0].
 *
 * PHPUnit Assert (non Pest expect) → PHPStan L10 senza method.internalClass.
 *
 * @see laravel/Themes/One/docs/folio-pages-structure.md
 * @see bashscripts/tools/verify-no-semantic-folio-pages.sh
 */
test('ptvx theme pages non contiene directory semantiche vietate', function (): void {
    $themesRoot = dirname(__DIR__, 5).'/Themes';
    $forbidden = [
        'administration', 'ambiente', 'article', 'articles', 'categories', 'cultura',
        'dashboard', 'eventi', 'famiglia', 'genesis', 'lavoro', 'learn', 'mobilita',
        'news', 'pages', 'profile', 'salute', 'segnalazioni', 'services', 'sport',
        'tickets', 'turismo',
    ];

    foreach (['One', 'Zero'] as $theme) {
        $pagesRoot = $themesRoot.'/'.$theme.'/resources/views/pages';
        Assert::assertDirectoryExists($pagesRoot, "Missing pages root for theme {$theme}");

        foreach ($forbidden as $dir) {
            Assert::assertDirectoryDoesNotExist(
                $pagesRoot.'/'.$dir,
                "Forbidden Folio dir: Themes/{$theme}/pages/{$dir}"
            );
        }

        Assert::assertDirectoryExists(
            $pagesRoot.'/auth',
            "Expected auth/ under Themes/{$theme}/pages"
        );
    }
});
