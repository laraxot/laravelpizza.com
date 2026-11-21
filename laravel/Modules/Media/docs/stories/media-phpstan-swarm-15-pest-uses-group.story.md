---
type: note
created: 2026-09-26
updated: 2026-09-26
qmd: "media phpstan swarm 2026 09 15 pest uses group.story"
issues: []
discussions: []
id: story-media-phpstan-swarm-2026-09-15-pest-uses-group
slug: media-phpstan-swarm-2026-09-15-pest-uses-group
title: "Fix swarm PHPStan 2026-09-15: falsi positivi uses()/describe()->group() nei test Pest"
document_type: story
category: bmad
scope: module:Media
status: done
priority: medium
created_at: '2026-09-15'
updated_at: '2026-09-15'
tags: [bmad, story, phpstan, pest, media, phpstan-swarm]
related:
  - ./media-quality-gate-2026-09-04.story.md
---

# Fix swarm PHPStan 2026-09-15: falsi positivi uses()/describe()->group() nei test Pest

## Fase BMAD: Build

## Contesto

Sono uno tra 10 subagent lanciati in parallelo per sistemare i 775 errori
trovati dalla run `php -d memory_limit=-1 ./vendor/bin/phpstan analyse
Modules --no-progress` del 2026-09-15 ~17:57. Scope esclusivo assegnato dal
coordinatore: `Modules/Media`, 68 errori in 34 file, tutti in
`tests/Unit/**`. Report sorgente:
`phpstan-swarm/Media.txt` (scratchpad della sessione).

## Diagnosi

Tutti i 68 errori sono UNA SOLA causa ripetuta 34 volte (33 file con lo
stesso pattern + 1 variante in `MediaTest.php`):

```
[method.nonObject] Cannot call method group() on null.
[function.void] Result of function uses (void) is used.
```

sulla riga `uses(TestCase::class)->group('no-media-db');` (o
`describe(...)->group(...)` in `MediaTest.php`).

Root cause verificata leggendo `vendor/pestphp/pest/src/Functions.php`:
`uses()` e `describe()` sono dichiarate dentro `if (! function_exists(...))`
con return type reale (`UsesCall`, `DescribeCall`), quindi la catena
`->group()` e' legittima a runtime. PHPStan pero' non vede questa
dichiarazione condizionale senza l'estensione dedicata — e in
`laravel/phpstan.neon` (SACRO, non toccato) le righe:

```
# - ./vendor/pestphp/pest-plugin-phpstan/extension.neon
# - ./vendor/pestphp/pest/extension.neon
```

sono commentate. Senza quell'extension PHPStan tratta `uses()`/`describe()`
come funzione sconosciuta → `void`, da cui i due errori. **Falso positivo
noto delle API interne Pest**, esattamente il caso previsto dalla standing
order (punto 4) per l'uso di `@phpstan-ignore` inline.

Non e' un problema specifico di Media: lo stesso pattern esiste
verosimilmente in tutti i moduli con test Pest (altri subagent del fleet
avranno lo stesso identico fix da fare nel loro scope).

## Fix applicato

Convenzione seguita (gia' in uso in `Modules/UI/tests/Unit/Models/
ThemeModelTest.php`): commento `/** @phpstan-ignore-next-line
<identifier...> (motivo) */` sulla riga precedente a quella con l'errore,
con gli identifier esatti riportati da PHPStan e una motivazione inline.

- 33 file: una riga di commento sopra `uses(TestCase::class)->group(...)`
  con `method.nonObject, function.void`.
- `tests/Unit/Models/MediaTest.php`: la catena e' `describe(...)->group(...)`
  spezzata su 322 righe (apertura riga 24, chiusura riga 345), quindi due
  commenti separati — uno sopra `describe(` (`function.void`) e uno sopra
  `})->group('media-db');` (`method.nonObject`) — perche' l'ignore-next-line
  copre solo la riga immediatamente seguente.

Nessun file aveva marker di conflitto (`<<<<<<<`/`=======`/`>>>>>>>`), tutti
liberi da lock, tutti passano `php -l`. Verificato prima di ogni edit che la
riga corrispondesse esattamente al testo del report (nessun file gia'
risolto da altri agenti nel frattempo).

Totale: **68/68 errori fixati**, 34 file toccati, +35 righe (solo
inserimenti di commenti, zero righe di codice logico toccate).

## Blocker per la verifica gate (non causato da me, non nel mio scope)

**Impossibile eseguire una verifica end-to-end con
`vendor/bin/phpstan analyse` o `vendor/bin/pest` in questo momento**, per
QUALSIASI path (anche uno scratch file fuori da `Modules/`): il processo PHP
va in fatal error prima ancora di iniziare l'analisi:

```
PHP Fatal error:  Cannot override final method
Modules\Xot\Filament\Resources\Pages\XotBaseListRecords::getTableColumns()
in Modules/Ptv/app/Filament/Resources/CategoriaProproResource/Pages/
BaseListCategoriaPropros.php on line 28
```

Causa: `Modules/Xot/app/Filament/Resources/Pages/XotBaseListRecords.php`
ha reso `getTableColumns()` `final` (commit `14e52081f`, 2026-09-15 18:01,
tracciato come story `18.23b-xotbaselistrecords-gettablecolumns-final-
phpstan: in-progress` in `docs/sprint-status.yaml` root), ma
`Modules/Ptv/.../BaseListCategoriaPropros.php` (commit `c93cedd64`,
16:48, precedente) continua a fare override non-final. E' un conflitto
cross-modulo Xot/Ptv attivamente tracciato dal coordinatore centrale, fuori
dal mio scope (Media) e dalla mia autorita' (non tocco altri moduli). Ho
verificato con un repro isolato in uno scratch neon fuori progetto che il
crash si verifica comunque (l'autoloader del progetto viene comunque
caricato), quindi non e' aggirabile restringendo i path.

Verifica sostitutiva fatta senza il gate PHPStan/Pest live:
- Sintassi: `php -l` su tutti i 34 file — 0 errori.
- Grammatica dell'ignore comment: verificata con repro isolato (stub locale
  di `uses()`/`->group()` con firme reali) in un neon minimo separato dal
  progetto — `/** @phpstan-ignore-next-line method.nonObject, function.void
  (...) */` sopprime esattamente i due identifier attesi.
- PHPMD (`./tools/phpmd.sh Modules/Media text
  Modules/Media/phpmd.ruleset.xml --exclude
  'vendor,node_modules,bootstrap,caches,tests,docs'`): gira (esclude
  `tests/`, quindi non tocca i file di questa story), tutti i finding sono
  preesistenti in `app/` (CamelCase, BooleanArgumentFlag, complessita',
  ecc.), nessuno introdotto da me — non ne ho risolto nessuno, fuori dal
  report assegnato.
- PHPInsights (`./tools/phpinsights.sh analyse Modules/Media
  --no-interaction --composer=composer.lock`): score 92.9/100/92.9/87.7,
  tutti i finding preesistenti in `app/`, nessuno introdotto da me.
- Pest: bloccato dallo stesso fatal error Xot/Ptv (Pest boota l'intera app
  Laravel/Filament). Non eseguibile finche' il blocker non e' risolto da chi
  possiede quello scope.

Da ripetere (chi coordina il fleet o chiude 18.23b) appena il blocker
Xot/Ptv e' risolto: `php -d memory_limit=-1 ./vendor/bin/phpstan analyse
Modules/Media --no-progress` per confermare 0 errori residui su questo
scope.

## Second brain — pattern da ricordare

Pattern ricorrente non ovvio: **qualunque file `tests/Unit/**Test.php` che
apre con `uses(TestCase::class)->group(...)` o `describe(...)->group(...)`
a livello di file produce sempre la coppia `method.nonObject` +
`function.void` sotto questo `phpstan.neon`**, perche' l'estensione
`pestphp/pest-plugin-phpstan` e' disabilitata li' (riga commentata,
intenzionale/sacra, non toccare). Non e' un bug del modulo: e' strutturale
a ogni modulo con test Pest in questo repo. Altri subagent del fleet
troveranno lo stesso identico pattern nel loro scope e possono riusare
questa stessa convenzione di `@phpstan-ignore-next-line`.

## Igiene root modulo (richiesta dal coordinatore)

Verificato `Modules/Media/` root: 3 file `.md` (`CHANGELOG.md`, `README.md`,
`test11.md`), 0 file `.txt`. Sotto la soglia di 6 `.md` indicata dal
coordinatore — nessuno spostamento necessario.

## File toccati

34 file in `Modules/Media/tests/Unit/**` (vedi commit). Nessun file in
`app/`, `docs/stories/` root o `docs/sprint-status.yaml` root toccato.
