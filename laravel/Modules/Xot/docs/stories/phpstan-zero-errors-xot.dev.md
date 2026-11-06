---
title: "[DEV] Xot: PHPStan a zero errori"
type: dev-story
status: review
created: 2026-10-28
updated: 2026-10-28
tags: [phpstan, merge, lessons-learned]
---
# Dev Story: Xot 110 -> 0 (dei 110 della baseline)

## Technical Plan
1. Raggruppare per causa radice, non per riga (11 gruppi, vedi story).
2. Per ogni "classe non trovata": `git log -S` / `git show` per stabilire se e' stata spostata, rimossa di proposito o rimossa per errore. Qui sempre "rimossa di proposito" (`5acb43ea2` ModuleService, `139ff7294` FileAction, `84a826ab8` handler Artisan) e riesumata dal merge.
3. Per ogni variabile "non definita": cercare il commit che ha tolto il parametro e quello che ha aggiunto il silenziatore (`git log -p -S`).

## Implementation Steps
1. [x] Silenziatori orfani, `$rows`, `$data`, `$type`
2. [x] Contratti: `Builder $query`, `factory(callable|array|int|null, callable|array)` + caricamento dei 203 model
3. [x] Test: ModuleServiceTest, FileAction, SupportColumnBuilder, fixture/import persi
4. [x] `HasYearsConfigTest` (il trait era senza utilizzatori in questa installazione)
5. [x] Handler Artisan resi compilabili
6. [x] Rinomina di 4 storie con data nel nome

## Verification
```bash
cd laravel && ./vendor/bin/phpstan analyse Modules/Xot Modules/Media/app/Datas/MediaConfigData.php --memory-limit=-1 --no-progress --error-format=raw
# typeCoverage: solo con i path interi
./vendor/bin/phpstan analyse --memory-limit=-1
```

## Lessons Learned
- Dopo un merge cercare i **silenziatori di parametro** (`Assert::x($_p)`, `$_p`) il cui parametro non esiste piu': e' il segno che un ramo ha tolto il parametro e l'altro lo aveva zittito.
- Un test che nomina una classe che non esiste piu' non e' un test da ripristinare: leggere la story di rimozione (`module-service-test-decision.story.md`) prima di toccarlo.
- `trait.unused` su un trait condiviso di Xot non significa trait morto: i consumatori possono stare in moduli che questa installazione non ha. Un test con implementazione minima lo rende analizzato e verifica la logica.
- Un `callable` nell'unione di tipi nativi e' valido; il parametro tipato di un metodo statico nel trait non confligge con `HasFactory` (parametri senza tipo = `mixed`, piu' larghi).
- `phpstan analyse Modules/Xot` salta `typeCoverage` e vede i trait usati solo da altri moduli come inutilizzati: per i numeri finali serve il run con i path di `phpstan.neon`.
