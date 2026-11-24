<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Modules\Cms\Actions\Head\ResolveCmsPageAction;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
test('the request path maps to the CMS slugs the sitemap derives paths from', function (string $path, array $expected): void {
    $action = new ResolveCmsPageAction;

    Assert::assertSame($expected, $action->candidateSlugs($path, ['it', 'en']), $path);
})->with([
    'root' => ['', ['home', 'home.index']],
    'locale home' => ['it', ['home', 'home.index']],
    'top-level page' => ['it/faq', ['faq', 'faq.index']],
    'nested page' => ['en/services/radioprotezione', ['services.radioprotezione', 'services.radioprotezione.index']],
    'detail page that has no container0/slug0 route parameters' => ['it/blog/novita-dlgs-101-2020', ['blog.novita-dlgs-101-2020', 'blog.novita-dlgs-101-2020.index']],
    'upper case and trailing slash' => ['/EN/Services/', ['services', 'services.index']],
]);

test('a named route is tried after the path slugs and ignored when it is a generic Folio route', function (): void {
    $action = new ResolveCmsPageAction;

    Assert::assertSame(['faqs', 'faqs.index', 'segnalazioni.index'], $action->candidateSlugs('it/faqs', ['it'], 'segnalazioni.index'));
    Assert::assertSame(['faq', 'faq.index'], $action->candidateSlugs('it/faq', ['it'], 'faq'));
    Assert::assertSame(['faq', 'faq.index'], $action->candidateSlugs('it/faq', ['it'], 'container0.view'));
    Assert::assertSame(['faq', 'faq.index'], $action->candidateSlugs('it/faq', ['it'], null));
});
