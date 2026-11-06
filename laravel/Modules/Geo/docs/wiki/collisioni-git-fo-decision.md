---
title: "Collisioni git frontoffice: test Geo di modello senza TestCase"
type: decision
created: 2026-10-26
updated: 2026-10-26
qmd: "collisioni-git-fo-decision"
issues: []
discussions: []
status: verified
tags: [git-merge, geo, test, pest, testcase, bmad]
related:
  - ./log.md
  - ../../../../Themes/Sixteen/docs/merge-conflict-resolution-log.md
---

# Test Geo di modello: nessun marker, mancava il TestCase

Questa pagina sostituisce una prima bozza (stessa data) che descriveva marker di merge nei test Geo e un file
`GeocodingBusinessLogicTest.php`. Entrambe le cose non erano vere nel working tree: la bozza non era stata verificata.

## Che cosa si e' misurato

- **Marker:** `grep` su `tests/Unit/Models/*.php` trova 0 righe `<<<<<<<`, `=======`, `>>>>>>>`. Nessuna collisione attiva nei test Geo.
- **File inesistente:** `tests/Unit/Models/` non contiene nessun `Geocoding*`. Esistono `Address`, `Comune`, `Location`, `Province`, `Region` `BusinessLogicTest.php`.
- **Difetto reale:** i cinque test usano `describe()`/`test()` senza `uses(...)`. Senza un `TestCase` Pest non ha l'applicazione Laravel:
  i test che toccano la facade `Storage` o il container falliscono con l'errore sul container, non con un'asserzione. I marker non c'entrano.

## Quale lato e quale terza via

Non c'era un conflitto fra due lati: c'era una assenza (nessun `uses`). La scelta e' quale `TestCase` usare:

| Opzione | Esito | Scelta |
|---|---|---|
| `uses(Tests\TestCase::class)` (radice `laravel/tests`) | funziona, ma e' l'unica eccezione: 5 file contro 42 | scartata |
| `uses(TestCase::class)` con `use Modules\Geo\Tests\TestCase;` | convenzione del modulo (42 test) | **scelta** |

Misura: con l'una o l'altra opzione gli esiti sono identici (Address 4 rossi su 14, Comune 6 su 8, Location 1 su 10, Province 1 su 8,
Region 1 su 9). La scelta e' quindi di coerenza, non di comportamento.

## Che cosa resta rosso (non causato da `uses`)

13 test falliscono perche' il contratto scritto nel test non coincide col modello: per esempio `region has factory trait for testing`
si aspetta `HasFactory` su `Region`, che e' un modello Sushi in memoria. Sono da decidere uno per uno (correggere il test o il modello);
non sono stati toccati perche' decidere quale dei due ha ragione richiede di conoscere l'intento del modello.

## Come riprodurre

```bash
export DB_DATABASE_LIMESURVEY= APP_CONFIG_CACHE=/nonexistent/config.php
bash bashscripts/tools/heavy-slot.sh bash bashscripts/tools/pest-scratch-db.sh Modules/Geo/tests/Unit/Models/RegionBusinessLogicTest.php
```

Mai `pest` nudo: con la config cache scrive sul DB di sviluppo.