<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Actions\Head;

use Modules\Cms\Actions\Head\ResolvePageDescriptionAction;
use PHPUnit\Framework\Assert;

function descriptionBlocks(): string
{
    return json_encode([
        'it' => [['type' => 'hero', 'data' => ['title' => 'Domande Frequenti', 'subtitle' => 'Tutto quello che devi sapere sulla sicurezza radiologica']]],
        'en' => [['type' => 'hero', 'data' => ['title' => 'FAQ', 'subtitle' => 'Everything you need to know about radiation safety']]],
    ], JSON_THROW_ON_ERROR);
}

test('the description is the first subtitle of the page in the requested language', function (): void {
    $action = new ResolvePageDescriptionAction();

    Assert::assertSame('Tutto quello che devi sapere sulla sicurezza radiologica', $action->fromRaw(descriptionBlocks(), 'it'));
    Assert::assertSame('Everything you need to know about radiation safety', $action->fromRaw(descriptionBlocks(), 'en'));
});

test('a language without blocks gets no description instead of another language', function (): void {
    $action = new ResolvePageDescriptionAction();

    Assert::assertNull($action->fromRaw(descriptionBlocks(), 'de'));
    Assert::assertNull($action->fromRaw(null, 'it'));
    Assert::assertNull($action->fromRaw('not json', 'it'));
    Assert::assertNull($action->fromRaw([['type' => 'hero']], 'it'));
});

test('labels, raw translation keys and non-text values are skipped in favour of the next usable text', function (): void {
    $action = new ResolvePageDescriptionAction();
    $blocks = ['it' => [
        ['data' => ['subtitle' => 'Breve']],
        ['data' => ['subtitle' => 'pub_theme::hero.subtitle.label e altro testo lungo abbastanza']],
        ['data' => ['subtitle' => ['non', 'testo']]],
        'non un blocco',
        ['data' => ['description' => 'Una descrizione sufficientemente lunga per la pagina.']],
    ]];

    Assert::assertSame('Una descrizione sufficientemente lunga per la pagina.', $action->fromRaw($blocks, 'it'));
});

test('markup and entities are removed and whitespace is collapsed', function (): void {
    $action = new ResolvePageDescriptionAction();
    $blocks = ['it' => [['data' => ['subtitle' => "Guida <strong>pratica</strong> &amp;\n consigli   per studi dentistici"]]]];

    Assert::assertSame('Guida pratica & consigli per studi dentistici', $action->fromRaw($blocks, 'it'));
});

test('long text is cut on a word boundary within the search-snippet length', function (): void {
    $action = new ResolvePageDescriptionAction();
    $blocks = ['it' => [['data' => ['subtitle' => str_repeat('parola ', 40)]]]];

    $description = $action->fromRaw($blocks, 'it');

    Assert::assertNotNull($description);
    Assert::assertLessThanOrEqual(160, mb_strlen($description));
    Assert::assertStringEndsWith('parola…', $description);
});
