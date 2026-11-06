---
id: story-datas-test-geodata-always-true-assertion
slug: datas-test-geodata-always-true-assertion
title: "[STORY] DatasTest: l'asserzione su GeoData e' sempre vera (PHPStan alreadyNarrowedType)"
description: "Il commit 443c2b72 (2026-10-20) ha sostituito in DatasTest un assertInstanceOf sempre vero con un assertIsArray($geoData->toArray()) sempre vero. PHPStan lo segnala come staticMethod.alreadyNarrowedType. Correzione: il test crea GeoData con valori reali e controlla i campi, come gli altri test del file."
type: story
document_type: story
category: bmad
status: done
priority: medium
module: Geo
scope: module:Geo
created: '2026-10-22'
updated: '2026-10-22'
tags: [geo, test, phpstan, datas, alreadyNarrowedType]
related:
  - ../../tests/Unit/Datas/DatasTest.php
---

# [STORY] DatasTest: l'asserzione su GeoData e' sempre vera

## Sintomo

`./vendor/bin/phpstan analyse Modules`, dopo il pull dei moduli del 2026-10-22:

```text
Geo/tests/Unit/Datas/DatasTest.php:72
Call to static method PHPUnit\Framework\Assert::assertIsArray() with array will always evaluate to true.
staticMethod.alreadyNarrowedType
```

L'errore era nascosto finche' il fatal di `Contact::sendEmailCallback()` interrompeva l'analisi (story Quaeris `contact-send-email-callback-void-return`).

## Causa

- Il commit `443c2b72` (2026-10-20, messaggio `.`) ha cambiato il test "GeoData can be instantiated": da `assertInstanceOf(GeoData::class, $geoData)` a `assertIsArray($geoData->toArray())`.
- `Data::toArray()` dichiara `array` come tipo di ritorno: l'asserzione non puo' fallire e non verifica niente. Anche la versione precedente era sempre vera, perche' `GeoData::from()` restituisce sempre un `GeoData`.

## Correzione

Il test crea `GeoData` con un valore per ogni campo e controlla con `assertSame` che i campi letti, anche tramite `toArray()`, siano quelli passati. Stesso stile degli altri test del file (`CoordinatesData`, `PlaceData`).

## Fuori scope, trovato durante la verifica

Nello stesso file 4 test falliscono gia' prima della correzione, per problemi nelle classi Data e non nei test:

- `AddressData can be instantiated`: `CannotCreateData`.
- `LocationData can be instantiated`: `ErrorException`.
- `GeocodingData can be instantiated`: errore in creazione.
- `TimeZoneData can be instantiated`: `Undefined array key "countryCode"` in `TimeZoneData.php:47`.

Non toccati: da trattare in una story dedicata.

## Come lanciare i test in locale

`bootstrap/cache/config.php` (2026-10-08) contiene `APP_ENV=local` e batte `phpunit.xml`: `TestDatabaseGuard` interrompe i test. Senza cancellare la cache:

```bash
APP_CONFIG_CACHE=/percorso/inesistente/config.php APP_EVENTS_CACHE=/percorso/inesistente/events.php \
    ./vendor/bin/pest Modules/Geo/tests/Unit/Datas/DatasTest.php --no-coverage
```

## Criteri di accettazione

- [x] PHPStan su `DatasTest.php`: nessun errore.
- [x] PHPStan su `Modules`: 0 errori, nessun fatal.
- [x] Il test "GeoData can be instantiated" passa. Confronta valori esatti con `assertSame`: un campo non valorizzato lo fa fallire.
- [x] PHPMD (`docs/phpmd.ruleset.xml`): nessun avviso, prima e dopo. PHPInsights su `tests/Unit/Datas`: nessun avviso sulle righe nuove. Quelli presenti (closure senza `: void`, `new Collection` senza parentesi) riguardano tutto il file e c'erano gia'.

Verificato il 2026-10-22. Pest: 12 test passati, 4 falliti (gli stessi 4 di prima, fuori scope). Nota di coordinamento: `docs/chat/geo-datas-test-geodata-always-true.md`.
