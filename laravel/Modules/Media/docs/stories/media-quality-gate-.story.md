---
type: note
created: 2026-09-26
updated: 2026-09-26
qmd: "media quality gate 2026 09 04.story"
issues: []
discussions: []
id: story-media-quality-gate-2026-09-04
slug: media-quality-gate-2026-09-04
title: "Chiusura quality-gate modulo Media (phpmd + pest + coverage baseline)"
description: "Verifica baseline PHPStan (0 errori confermato), fix mirati PHPMD (5 finding reali risolti su 163), tentativo Pest sotto ambiente concorrente pesante con root-cause di un bootstrap crash intermittente in Modules/Xot non correlato al modulo."
document_type: story
category: bmad
scope: module:Media
status: done
priority: medium
created_at: '2026-09-04'
updated_at: '2026-09-04'
tags: [bmad, story, quality-gate, phpmd, phpstan, pest, media]
related:
  - ./media-services-to-actions.story.md
  - ./media-mixed-type-reduction.story.md
  - ../coverage.md
  - ../../../../docs/chat/xot-blade-component-bootstrap-crash-wip.md
---

# Chiusura quality-gate modulo Media (phpmd + pest + coverage baseline)

## Fase BMAD: Build + Measure

## Contesto

Task di chiusura del pillar 5 (quality gate) per `Modules/Media`, dopo che
PHPStan era gia' stato verificato a 0 errori in una sessione precedente
(2026-09-04, refresh `ide-helper:generate/meta/models`). Compito: verificare
la baseline PHPStan, poi phpmd, phpinsights, pest, coverage, git.

Coordinamento: nessuna nota attiva su Media in `docs/chat/` al momento
dell'avvio (solo storico su marker di conflitto gia' risolti il 2026-08-25).
Lock preso: `bashscripts/lock/lock.sh laravel/Modules/Media
quality-gate-2026-09-04 agent-Media` → acquisito senza conflitti.

## Cosa ho trovato

- `php -l` su tutti i 246 file `.php` del modulo: nessun errore di sintassi.
- PHPStan baseline (`clear-result-cache` + `analyse Modules/Media
  --no-progress --error-format=table`): **0 errori**, confermato prima e
  dopo i fix.
- PHPMD (`./tools/phpmd.sh Modules/Media/app text
  ../docs/phpmd.ruleset.xml`): **163 finding** reali (nessun crash
  `visitAnonymousClass` su questo giro, a differenza di una nota precedente).
  La maggioranza sono falsi positivi rispetto alle convenzioni del repo
  (parametri Policy `$_ability`/`$_media` con prefisso `_` per segnalare
  volutamente-inutilizzato, usato in 20+ Policy di altri moduli; variabili
  snake_case che rispecchiano chiavi config/DB come `$disk_mp4`;
  `$s3` come nome idiomatico per un client AWS SDK).
- PHPInsights: `vendor/bin/phpinsights` non installato nel progetto (rimosso,
  incompatibile con Pest 5 — memoria second brain
  `pest5-incompatibile-con-phpinsights`). Step saltato, nessun punteggio
  misurabile prima/dopo.
- Pest: ambiente sotto carico pesante da piu' sessioni concorrenti (Activity,
  AI, altri moduli in esecuzione parallela + una sessione con
  `Modules/Xot/app/Actions/Blade/RegisterBladeComponentsAction.php`
  modificato e non committato). Un primo giro ha fatto fallire **ogni** test
  al bootstrap, incluso un test mai toccato da nessuno (`FileExtensionRuleTest.php`,
  isolato per verifica) con `Typed property
  Modules\Xot\Datas\ComponentFileData::$name must not be accessed before
  initialization`. Root cause verificata leggendo tutti i `_components.json`
  del monorepo: `Modules/Xot/app/View/Components/_components.json` (file
  **committato**, non di un'altra sessione WIP) usa ancora lo schema legacy
  di `ComponentFileData` (`class_name`/`comp_name`/`comp_ns` invece di
  `name`/`class`/`ns`) — stessa classe di bug gia' documentata in
  `docs/chat/xot-blade-component-bootstrap-crash-wip.md` per un file
  analogo di Cms (li' gia' corretto), ma questa istanza dentro Xot stesso
  non era stata trovata. Fuori dal lock/scope di questo task (modulo Xot,
  non Media, nessun lock preso su Xot): non toccato.
- `Modules/Media/README.md` ha 3 blocchi di marker di merge reali
  (`<<<<<<< .merge_file_...` / `=======` / `>>>>>>> .merge_file_...`) nel
  working tree, non committati da me (`HEAD` e' pulito, `git status` segna
  `M`) — presumibilmente lavoro di un'altra sessione in corso. Non toccato,
  segnalato come bloccante.
- `git status --short` su `Modules/Media` mostrava **122 file gia' modificati
  o non committati** prima di qualunque mio edit (docs, lang, test, Actions),
  confermando drift esteso di sessioni concorrenti gia' documentato in note
  precedenti dello stesso `coverage.md`. Non toccati, non aggiunti al commit.

## Cosa ho fatto

Fix minimi, root-cause, verificati (nessuna @phpstan-ignore, nessuna
soppressione phpmd):

1. `app/Filament/Actions/Table/ConvertAction.php` — `MissingImport`
   (PHPMD): la `\RuntimeException` lanciata usava il leading-backslash
   invece di un `use` statement. Aggiunto `use RuntimeException;`, tolto il
   backslash dall'uso.
2. `app/Filament/Clusters/Test/Pages/AwsTest.php` — 3x
   `UnusedLocalVariable` (PHPMD): `$result = $s3->headBucket(...)` /
   `listObjectsV2(...)` / `getObject(...)` in `test_s3_connection()`,
   `test_s3_permissions()`, `test_s3_file_operations()`. Il valore di
   ritorno non veniva mai letto (la chiamata serve solo a innescare
   `AwsException` in caso di errore, gestita nel `catch`). Rimossa
   l'assegnazione, mantenuta la chiamata per l'effetto collaterale.
3. `app/Models/Policies/MediaBasePolicy.php` — `UnusedLocalVariable`
   (PHPMD): `$xotData = XotData::make()` in `before()` non era mai
   referenziato. `XotData::make()` e' un singleton cacheato (`self::$instance`)
   senza side-effect osservabile qui. Rimossa riga e `use
   Modules\Xot\Datas\XotData` inutilizzato.

PHPMD: **163 → 158 finding** (5 fix reali). PHPStan: 0 → 0 (nessuna
regressione, verificato con `clear-result-cache` prima e dopo).

## Cosa NON ho fatto (documentato, non fixato)

- ~40 finding `CamelCase*Name` su nomi snake_case che rispecchiano
  config/DB o la convenzione repo-wide del prefisso `_` per parametri Policy
  volutamente inutilizzati — non sono difetti, sono conformi alla
  convenzione osservata in `Modules/User`, `Modules/Notify` e altri.
- 15 `ShortVariable $s3` — nome idiomatico per un client SDK AWS, non un
  problema di leggibilita' reale.
- `ExcessiveClassComplexity`/`CouplingBetweenObjects`/`TooManyFields` su
  `S3Test.php` (825 righe) e `VideoEntry.php` (446 righe, gia' annotato in
  testa al file con un commento che riconosce esplicitamente questi
  finding come accettati) — refactor strutturale reale, fuori dal
  minimal-impact di una chiusura gate.
- Duplicazione confermata tra `app/Filament/Actions/AddAttachmentAction.php`
  e `app/Filament/Resources/HasMediaResource/Actions/AddAttachmentAction.php`
  (quasi identiche, usate da due `RelationManager` diversi) — consolidamento
  e' una decisione di ownership, non un fix minimale.
- `README.md` con marker di merge reali — non mio, non toccato, segnalato.
- Bug bootstrap in `Modules/Xot/app/View/Components/_components.json` — fuori
  modulo/lock, non toccato.
- PHPInsights — non installato nel repo, step non eseguibile.
- Coverage `--coverage-clover` non ri-misurato in questa sessione: due run
  Pest completi (senza coverage) hanno gia' richiesto rispettivamente
  ~40s (bootstrap-crash, non valido) e 260.88s (valido) sotto il carico
  attuale; un terzo run con `--coverage` (piu' lento) non e' stato
  giustificato dal ROI, dato che nessun branch/metodo intero e' stato
  rimosso dai 3 fix (solo variabili locali morte).

## Come l'ho verificato

- PHPStan: `php -d memory_limit=2048M ./vendor/bin/phpstan analyse
  Modules/Media --no-progress --error-format=table` → `[OK] No errors`,
  prima e dopo, con `clear-result-cache` immediatamente precedente ogni
  misura.
- PHPMD: `./tools/phpmd.sh Modules/Media/app text
  ../docs/phpmd.ruleset.xml` → 163 righe di finding prima, 158 dopo (diff
  verificato riga per riga, corrisponde esattamente ai 5 fix).
- Pest: `./vendor/bin/pest -c Modules/Media/phpunit.xml --no-coverage` →
  run valido: **269 passed, 29 failed, 1 risky, 1162 assertions**
  (260.88s). Verificato che nessuno dei 29 fallimenti coinvolge i 3 file
  toccati in questa sessione (`ConvertAction`, `AwsTest`, `MediaBasePolicy`
  non compaiono tra i nomi dei test falliti in nessuno dei run). Isolamento
  di un singolo test mai toccato (`FileExtensionRuleTest.php`) per
  confermare che il bootstrap-crash e' pre-esistente e non legato al mio
  diff.
- Dettagli completi: `Modules/Media/docs/coverage.md`, sezione "2026-09-04
  — quality-gate closure".

## Bloccanti

1. `Modules/Xot/app/View/Components/_components.json` — schema legacy di
   `ComponentFileData`, rompe il bootstrap dell'intera app in modo
   intermittente sotto carico concorrente. Fuori scope/lock (modulo Xot).
2. `Modules/Media/README.md` — 3 blocchi di marker di merge reali, non
   committati, non miei.
3. Ambiente sotto carico pesante da sessioni concorrenti (Activity, AI,
   altri moduli + WIP su Xot) durante l'intera sessione — ha reso ogni
   misura Pest instabile e ha richiesto piu' tentativi per ottenere un
   numero affidabile.

## Git

Repo del modulo (`.git` separato, remote `laraxot`,
`git@github.com:laraxot/module_media_fila5.git`, branch `dev`). Prima dei
miei edit: `dev` in sync con `laraxot/dev` (0 ahead, 0 behind). Aggiunti
solo i 3 file intenzionalmente modificati piu' `docs/coverage.md` e questa
story; **non** aggiunto nient'altro dei 122 file di drift pre-esistente.
Commit e push: vedi output strutturato finale per SHA e conferma remote.
