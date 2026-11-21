---
title: "coverage"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-10-01
qmd: "coverage"
issues: []
discussions: []
---

# Code Coverage: Gdpr

Misura del 2026-10-01 (story 5.258, gruppo G03), da `laravel/` con `XDEBUG_MODE=coverage`
via `heavy-slot.sh`:

```bash
HEAVY_SLOTS=1 HEAVY_SLOT_DIR=/tmp/heavy-slots-pest XDEBUG_MODE=coverage \
  ../bashscripts/tools/heavy-slot.sh ./vendor/bin/pest \
  --test-directory=Modules/Gdpr/tests Modules/Gdpr/tests --coverage
```

**Lines Coverage:** N/A (Pest non stampa la tabella coverage quando ci sono test falliti).

| Misura | Prima (2026-09-26) | Dopo (2026-10-01) |
|---|---|---|
| Test eseguiti | 0 (fatale `TestCaseAlreadyInUse`) | 254 |
| Passati | 0 | 132 |
| Falliti | n/d | 106 |
| Skipped / risky | n/d | 13 / 3 |
| Coverage | N/A | N/A (run con fallimenti) |

## Perche' la coverage e' ancora N/A

Il binding doppio e' stato rimosso (i file test non dichiarano piu' `uses(TestCase::class)`:
il binding sta solo in `tests/Pest.php`), quindi la suite ora parte. I 106 fallimenti restanti
sono ambientali, non regressioni:

- ~40 `no such table: users|treatments|consents`: `laravel/database/database.sqlite` e'
  praticamente vuoto (2 tabelle, nessuna migrazione applicata) e i test non possono usare
  `RefreshDatabase` ne' `migrate:fresh`.
- ~43 risposte HTTP 405/500/404 su rotte `gdpr/auth/register`: il tema stub non ha le pagine
  richieste (vedi nota ambiente della story 5.258).
- 6 `Laravel default locale is not in the supportedLocales array`.

Per ottenere una coverage numerica servono tabelle sqlite popolate o fixture senza DB.
