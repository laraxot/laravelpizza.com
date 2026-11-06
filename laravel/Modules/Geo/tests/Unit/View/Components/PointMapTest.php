<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\View\Components;

use Illuminate\Support\Facades\Blade;
use Modules\Geo\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;

use function Safe\preg_match_all;

uses(UnitTestCase::class);

/**
 * Contratto di `<x-geo::point-map>`: mappa di SOLA LETTURA di un punto (riepilogo del wizard segnalazioni).
 * Il comportamento JS (marker non trascinabile, nessun click) si verifica in browser: vedi docs/wiki/concepts/point-map-readonly.md.
 */
function pointMapHtml(string $attributes): string
{
    // deleteCachedView: il template stringa non deve restare in cache (cambia con la classe del componente).
    return Blade::render('<x-geo::point-map '.$attributes.' />', deleteCachedView: true);
}

test('rende il web component in sola lettura con le coordinate e l indirizzo', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19" address="Via Roma 1, Milano"');

    Assert::assertStringContainsString('<coordinate-picker-lit', $html);
    Assert::assertMatchesRegularExpression('/<coordinate-picker-lit[^>]*\sreadonly[\s>=]/', $html);
    Assert::assertStringContainsString('&quot;latitude&quot;:45.4642', $html);
    Assert::assertStringContainsString('&quot;longitude&quot;:9.19', $html);
    Assert::assertStringContainsString('Via Roma 1, Milano', $html);
});

test('accetta coordinate come stringhe numeriche (stato del form)', function (): void {
    $html = pointMapHtml('latitude="45.4642" longitude="9.19"');

    Assert::assertStringContainsString('<coordinate-picker-lit', $html);
    Assert::assertStringContainsString('&quot;latitude&quot;:45.4642', $html);
});

test('espone una regione con aria-label che include etichetta e indirizzo', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19" address="Via Roma 1, Milano" label="Posizione del disservizio"');

    Assert::assertStringContainsString('role="region"', $html);
    Assert::assertMatchesRegularExpression('/aria-label="Posizione del disservizio: Via Roma 1, Milano"/', $html);
});

test('senza indirizzo l aria-label usa le coordinate', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19"');

    Assert::assertMatchesRegularExpression('/aria-label="[^"]*45\.464200, 9\.190000"/', $html);
});

test('offre l alternativa testuale visibile con coordinate e indirizzo e il link OpenStreetMap', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19" address="Via Roma 1, Milano"');

    Assert::assertStringContainsString('45.464200', $html);
    Assert::assertStringContainsString('9.190000', $html);
    Assert::assertStringContainsString(__('geo::coordinate-picker.address'), $html);
    Assert::assertStringContainsString('https://www.openstreetmap.org/?mlat=45.464200&amp;mlon=9.190000', $html);
    Assert::assertMatchesRegularExpression('/<a[^>]*target="_blank"[^>]*rel="noopener noreferrer"/', $html);
});

test('non offre ricerca ne geolocalizzazione ne fullscreen', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19"');

    Assert::assertStringNotContainsString('show-search', $html);
    Assert::assertStringNotContainsString('geolocate-when-empty="true"', $html);
    Assert::assertStringNotContainsString('<input', $html);
});

test('senza coordinate rende un segnaposto testuale e nessun web component', function (string $attributes): void {
    $html = pointMapHtml($attributes);

    Assert::assertStringNotContainsString('coordinate-picker-lit', $html);
    Assert::assertStringContainsString(__('geo::point-map.empty'), $html);
})->with([
    'nessuna prop' => [''],
    'null' => [':latitude="null" :longitude="null"'],
    'stringhe vuote' => ['latitude="" longitude=""'],
    'solo latitudine' => [':latitude="45.4"'],
    'non numeriche' => ['latitude="abc" longitude="def"'],
    'fuori intervallo' => [':latitude="91" :longitude="9"'],
    'longitudine fuori intervallo' => [':latitude="45" :longitude="181"'],
]);

test('zero e una coordinata valida', function (): void {
    $html = pointMapHtml(':latitude="0" :longitude="0"');

    Assert::assertStringContainsString('<coordinate-picker-lit', $html);
});

test('due istanze nella stessa pagina hanno id distinti', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19"').pointMapHtml(':latitude="45.4642" :longitude="9.19"');

    preg_match_all('/\sid="(geo-point-map-[^"]+)"/', $html, $matches);

    Assert::assertCount(2, $matches[1]);
    Assert::assertNotSame($matches[1][0], $matches[1][1]);
});

test('un id esplicito viene rispettato', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19" id="ticket-review-map"');

    Assert::assertSame(1, substr_count($html, 'id="ticket-review-map"'));
});

test('altezza di default 16rem e zoom di default 16', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19"');

    Assert::assertStringContainsString('height="16rem"', $html);
    Assert::assertStringContainsString('height:16rem', $html);
    Assert::assertStringContainsString('zoom="16"', $html);
});

test('altezza e zoom sono configurabili', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19" height="20rem" :zoom="12"');

    Assert::assertStringContainsString('height="20rem"', $html);
    Assert::assertStringContainsString('zoom="12"', $html);
});

test('un altezza non valida torna al default (niente CSS iniettato)', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19" height="1rem;background:red"');

    Assert::assertStringNotContainsString('background:red', $html);
    Assert::assertStringContainsString('height="16rem"', $html);
});

test('l indirizzo e l etichetta sono escapati', function (): void {
    $html = Blade::render(
        '<x-geo::point-map :latitude="45.4642" :longitude="9.19" :address="$address" :label="$label" />',
        ['address' => '<script>alert(1)</script>', 'label' => 'a"b'],
        deleteCachedView: true,
    );

    Assert::assertStringNotContainsString('<script>alert(1)</script>', $html);
    Assert::assertStringContainsString('&lt;script&gt;', $html);
    Assert::assertStringContainsString('aria-label="a&quot;b:', $html);
});

test('non usa stili legati a uno slug di pagina', function (): void {
    $html = pointMapHtml(':latitude="45.4642" :longitude="9.19"');

    Assert::assertStringNotContainsString('tests.', $html);
    Assert::assertStringNotContainsString('ticket-wizard-root', $html);
});
