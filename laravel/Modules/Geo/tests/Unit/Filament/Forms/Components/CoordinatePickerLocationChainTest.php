<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\GeopointPicker;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

/*
 * DCP-127: contratto della catena di centratura del picker, per i punti che non dipendono da un browser reale.
 * Catena (decisione del coordinatore DCP-129, 2026-10-13 21:35): punto salvato > centro del campo > GPS (contesto sicuro) >
 * fuso orario > vista di default configurata > mondo. Nessun servizio esterno per la posizione (IP: abbandonato, GDPR),
 * nessuna coordinata fissa nel codice, nessun testo su HTTPS, sotto zoom 10 un clic senza punto avvicina soltanto.
 * La prova di comportamento nel browser e' `bashscripts/tools/visual/geo-picker-centering-probe.mjs`.
 */
uses(UnitTestCase::class);

const GEO_PICKER_ROOT = __DIR__.'/../../../../..';

function geoPickerSource(string $relative): string
{
    return file_get_contents(GEO_PICKER_ROOT.'/'.$relative);
}

test('senza center() il picker non ha un centro fisso: la mappa si centra sull utente o sulla vista di partenza', function (): void {
    foreach ([CoordinatePicker::make('l'), MapPicker::make('l'), GeopointPicker::make('l')] as $field) {
        Assert::assertNull($field->getCenterLatitude());
        Assert::assertNull($field->getCenterLongitude());
    }

    $explicit = CoordinatePicker::make('l')->center(45.0, 9.0);
    Assert::assertSame(45.0, $explicit->getCenterLatitude());
    Assert::assertSame(9.0, $explicit->getCenterLongitude());
});

test('i tre blade rendono geolocate-when-empty come attributo booleano (presenza, mai "false")', function (): void {
    foreach (['coordinate-picker', 'map-picker', 'geopoint-picker'] as $view) {
        $blade = geoPickerSource("resources/views/filament/forms/components/{$view}.blade.php");

        Assert::assertMatchesRegularExpression('/@if\(\$field->getGeolocateWhenEmpty\(\)\) geolocate-when-empty @endif/', $blade, $view);
        // Su un attributo booleano Lit anche geolocate-when-empty="false" vale true: il picker di back office localizzava sempre.
        Assert::assertStringNotContainsString("? 'true' : 'false'", $blade, $view);
    }
});

test('il codice del picker non contiene coordinate fisse, servizi IP esterni, console.log ne il testo su HTTPS', function (): void {
    $sources = [
        'resources/js/components/coordinate-picker-lit.js',
        'resources/js/components/map/events.js',
        'resources/js/components/map/controls/geolocation.js',
        'resources/js/components/map/labels.js',
        'app/Filament/Forms/Components/Traits/HasCoordinatePicker.php',
        'config/config.php',
        'resources/views/filament/forms/components/coordinate-picker.blade.php',
        '../Fixcity/resources/views/filament/forms/components/dc-place-autocomplete.blade.php',
    ];

    foreach ($sources as $source) {
        $code = geoPickerSource($source);

        // Firenze (43.7696, 11.2558) e Roma (41.9028, 12.4964): i vecchi centri fissi.
        foreach (['43.7696', '11.2558', '41.9028', '12.4964'] as $fixed) {
            Assert::assertStringNotContainsString($fixed, $code, "{$source} contiene la coordinata fissa {$fixed}");
        }
        Assert::assertDoesNotMatchRegularExpression('/geo_insecure|geolocation_insecure|Apri questa pagina in HTTPS|Open this page over HTTPS/i', $code, $source);
        // L'IP del visitatore non va a servizi di terzi (decisione DCP-129: GDPR art. 6 e 44, DCP-137).
        Assert::assertDoesNotMatchRegularExpression('/get\.geojs\.io|ipwho\.is|ipapi\.co|approximate_location/i', $code, $source);
        Assert::assertStringNotContainsString('console.log(', $code, $source);
    }
});

test('contratto JS: senza API di posizione non si chiama il GPS e si ricade sulla zona, senza rete e senza messaggi su HTTPS', function (): void {
    $geolocation = geoPickerSource('resources/js/components/map/controls/geolocation.js');

    // Contesto non sicuro o API assente: prima uscita, PRIMA di getCurrentPosition.
    Assert::assertMatchesRegularExpression(
        '/if \(!window\.isSecureContext \|\| !navigator\.geolocation\) \{\s*fallBackToApproximate\(ctx, !auto\);\s*return Promise\.resolve\(\);\s*\}/',
        $geolocation,
    );
    Assert::assertLessThan(
        (int) strpos($geolocation, 'getCurrentPosition('),
        (int) strpos($geolocation, 'window.isSecureContext'),
        'Il controllo del contesto deve precedere getCurrentPosition.',
    );

    // Il callback d'errore (permesso negato, timeout) ricade sulla zona, non cerca altrove.
    $errorCallback = substr($geolocation, (int) strpos($geolocation, '(error) =>'));
    Assert::assertStringContainsString('fallBackToApproximate(ctx, !auto)', $errorCallback);
    Assert::assertStringNotContainsString('fetch(', $geolocation);
});

test('contratto JS: sotto zoom 10, senza punto, il clic avvicina soltanto; la sola lettura non registra il clic', function (): void {
    $events = geoPickerSource('resources/js/components/map/events.js');

    Assert::assertStringContainsString('export const PICK_MIN_ZOOM = 10;', $events);
    Assert::assertMatchesRegularExpression(
        '/if \(ctx\._lat == null && ctx\._map\.getZoom\(\) < PICK_MIN_ZOOM\) \{[^}]*setView\(e\.latlng[^}]*return;\s*\}\s*handleMapInteraction\(ctx, e\.latlng\.lat/s',
        $events,
    );
    Assert::assertMatchesRegularExpression('/if \(!ctx\.readonly\) \{\s*ctx\._map\.on\(\'click\'/', $events);
    // Scegliere un punto rende obsoleto l'invito a toccare la mappa.
    Assert::assertMatchesRegularExpression('/ctx\._shouldRecenterAfterResize = true;\s*ctx\._locationError = \'\';/', $events);
});
