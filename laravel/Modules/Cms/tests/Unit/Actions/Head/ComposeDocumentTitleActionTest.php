<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Modules\Cms\Actions\Head\ComposeDocumentTitleAction;
use PHPUnit\Framework\Assert;

test('document title keeps a single separator and the brand once whatever the CMS title already carries', function (string $cmsTitle, string $expected): void {
    $action = new ComposeDocumentTitleAction;

    Assert::assertSame($expected, $action->execute($cmsTitle, 'Sottana Service'));
})->with([
    'brand after a hyphen' => ['FAQ - Domande Frequenti - Sottana Service', 'FAQ - Domande Frequenti — Sottana Service'],
    'brand after a slash' => ['Consulenza Sicurezza Studi Professionali / Sottana Service', 'Consulenza Sicurezza Studi Professionali — Sottana Service'],
    'brand after a pipe' => ['Servizi | Sottana Service', 'Servizi — Sottana Service'],
    'brand before the title' => ['Sottana Service: Home', 'Home — Sottana Service'],
    'already in the final form' => ['Privacy Policy — Sottana Service', 'Privacy Policy — Sottana Service'],
    'no brand yet' => ['Chi Siamo', 'Chi Siamo — Sottana Service'],
    'brand in another case' => ['Contatti - SOTTANA SERVICE', 'Contatti — Sottana Service'],
    'brand only' => ['Sottana Service', 'Sottana Service'],
    'empty title' => ['', 'Sottana Service'],
]);

test('a brand in the middle of the title is left alone', function (): void {
    $action = new ComposeDocumentTitleAction;
    $title = 'Perché scegliere Sottana Service per la radioprotezione';

    Assert::assertSame($title, $action->execute($title, 'Sottana Service'));
});

test('without a brand the title is returned as written', function (): void {
    $action = new ComposeDocumentTitleAction;

    Assert::assertSame('Chi Siamo', $action->execute('  Chi Siamo ', ''));
    Assert::assertSame('Chi Siamo - X', $action->withoutBrand('Chi Siamo - X', ''));
});

test('the short name for breadcrumbs drops the brand and is empty when the title is only the brand', function (): void {
    $action = new ComposeDocumentTitleAction;

    Assert::assertSame('FAQ - Domande Frequenti', $action->withoutBrand('FAQ - Domande Frequenti - Sottana Service', 'Sottana Service'));
    Assert::assertSame('', $action->withoutBrand('Sottana Service', 'Sottana Service'));
});
