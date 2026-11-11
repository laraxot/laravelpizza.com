<?php

declare(strict_types=1);

use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;
use function Safe\preg_match_all;

/*
 * DCP-146: il centro approssimativo della mappa viene da una tabella fuso orario -> coordinate GENERATA dal database tz di PHP
 * (bashscripts/tools/geo/generate-timezone-centers.php). Il test legge il file generato: se il database tz del server si
 * aggiorna e compaiono fusi nuovi, il test avvisa di rigenerarlo. Solo filesystem, nessun database.
 */
/**
 * @return array<string, array{float, float}>
 */
function timezoneCentersTable(): array
{
    $source = file_get_contents(dirname(__DIR__, 2).'/resources/js/components/map/timezone-centers.js');
    preg_match_all('/"([A-Za-z_\/+\-0-9]+)": \[(-?[0-9.]+), (-?[0-9.]+)\]/', $source, $m, PREG_SET_ORDER);
    /** @var array<string, array{float, float}> $table */
    $table = [];
    foreach ($m as [, $zone, $lat, $lng]) {
        $table[$zone] = [(float) $lat, (float) $lng];
    }

    return $table;
}

it('places well known timezones near the right city', function (string $zone, float $lat, float $lng): void {
    $table = timezoneCentersTable();

    Assert::assertArrayHasKey($zone, $table);
    Assert::assertEqualsWithDelta($lat, $table[$zone][0], 1.0, "{$zone}: latitudine");
    Assert::assertEqualsWithDelta($lng, $table[$zone][1], 1.0, "{$zone}: longitudine");
})->with([
    'Roma' => ['Europe/Rome', 41.9, 12.48],
    'Berlino' => ['Europe/Berlin', 52.5, 13.37],
    'Madrid' => ['Europe/Madrid', 40.4, -3.68],
    'New York' => ['America/New_York', 40.71, -74.01],
    'Tokyo' => ['Asia/Tokyo', 35.65, 139.74],
    'Calcutta (nome storico che alcuni browser restituiscono)' => ['Asia/Calcutta', 22.53, 88.37],
    'Kiev (nome storico)' => ['Europe/Kiev', 50.43, 30.52],
]);

it('has valid coordinates for every timezone and covers the whole tz database of this server', function (): void {
    $table = timezoneCentersTable();

    Assert::assertGreaterThan(400, count($table));
    foreach ($table as $zone => [$lat, $lng]) {
        Assert::assertTrue(abs($lat) <= 90 && abs($lng) <= 180, "{$zone}: coordinate fuori intervallo");
    }
    $missing = [];
    foreach (DateTimeZone::listIdentifiers() as $zone) {
        $location = (new DateTimeZone($zone))->getLocation();
        $hasPlace = is_array($location) && ($location['latitude'] != 0 || $location['longitude'] != 0);
        if ($hasPlace && ! isset($table[$zone])) {
            $missing[] = $zone;
        }
    }

    Assert::assertSame([], $missing, 'Fusi orari nuovi nel database tz: rigenerare con php bashscripts/tools/geo/generate-timezone-centers.php');
});
