---
title: "[STORY] Sync dei moduli da copia vecchia: marker, regressioni silenziose e PHPStan a zero"
type: story
module: Xot
bmad: true
status: review
priority: high
created: 2026-11-17
updated: 2026-11-17
tags: [phpstan, sync, merge, marker-conflitto, regressioni, qualita]
qmd: "sync moduli copia vecchia snapshot stale marker conflitto merge_file regressioni silenziose phpstan zero 2026-11-17"
related:
  - ../../../../../docs/wiki/memories/phpstan-quality-docs-bmad-standing-order.md
  - ./phpstan-merge-bootstrap.story.md
  - ./fix-merge-conflicts.md
---

# Sync dei moduli da copia vecchia: marker, regressioni e PHPStan a zero

## Scopo

Riportare `./vendor/bin/phpstan analyse Modules` a zero errori dopo il pull dei moduli del
2026-11-17, e capire perché il pull aveva rotto il bootstrap di PHPStan.

## Causa radice

Il 2026-11-17 lo script di sync ha creato commit automatici (autore `marco76tv`, messaggio `.`)
nelle repo dei moduli, in due giri. Ogni commit conteneva l'intero working tree di una macchina
ferma al 10-11 novembre:

- 08:51–08:56, con parent del 2026-11-11;
- 09:50–10:02, con parent del 2026-11-10 (in AI del 2026-11-09).

Alle 10:24–10:26 lo script ha fuso questi commit con il lavoro recente (`origin/dev`, `laraxot/dev`).
Ha committato anche quando il merge falliva. Gli effetti sono tre:

1. **Marker di conflitto committati**: 17 file PHP (AI, Lang, User, UI, Activity, Job) e 206 file
   non PHP. Larastan avvia l'app, quindi il marker in `User/app/Models/BaseUser.php` bloccava il
   bootstrap e PHPStan usciva senza analizzare niente.
2. **Regressioni silenziose**: quando un file era cambiato solo nella copia vecchia, il merge lo ha
   preso senza conflitto. Le regressioni sono di due tipi: un file riportato a una versione già
   superata nella sua storia, oppure un file cancellato.
3. **File cancellati necessari**: per esempio `User/tests/Helpers.php`, richiesto da
   `laravel/tests/Pest.php`. Senza questo file nessun test Pest parte.

## Cosa è cambiato

### Marker risolti (lato recente)

In ogni blocco il lato `>>>>>>>` era la versione recente; il lato `<<<<<<<` era la copia vecchia.
Il confronto è stato fatto con la storia del modulo:

- **AI** (7 file): i file risolti coincidono con il commit `930f0c4` (visitatori anonimi, filtro
  del report nel database, `appendMessage`).
- **Job** (3 file): resta l'hardening (`getAllowedCommands()`, `e(Artisan::output())`) e il test
  che verifica che il Kernel non venga chiamato.
- **Activity** (2 test): import duplicati rimossi.
- **UI**: il layout `main.blade.php` segue il contratto Filament 5 (`@filamentScripts` a fine
  `<body>`, notifiche sempre presenti).
- **Lang**: `en/txt.php` ripreso dal lato completo. `en/translation_files.php` e
  `en/translation_file_form.php` erano vuoti da un lato e in italiano dall'altro: ora sono in
  inglese, con `declare(strict_types=1)`.
- **User**: in `BaseUser.php` il conflitto era solo una riga vuota. L'hardening P0 del panel
  `access` era già presente su entrambi i lati.

### Errori PHPStan (93, ora 0)

- **Fixcity**
  - Chiavi duplicate in `lang/{it,de,es}/ticket.php` e `lang/en/ticket_track.php`: rimosso il
    primo blocco. PHP usava già il secondo, quindi i testi mostrati non cambiano.
  - **Bug**: `TimelineStep::getClosureLabel()` cercava la chiave `delegato`, ma
    `getClosureType()` restituisce `delegated`, quindi l'etichetta «Delegato» non usciva mai.
    Ora è un `match`.
  - **Bug**: la migrazione `2026_11_12_000001_fix_ticket_subscribers_table` usava `$this` in una
    closure `static`, quindi andava in errore fatale all'esecuzione.
- **Blog**: rimossi da `Models\User` i `@property ticketComments` copiati da Fixcity. Quella
  relazione in Blog non esiste.
- **Mobile**
  - `Safe\preg_match` in `ScanQrAction`. Il tipo del QR ora si ricava con un `match`, senza
    `@var` inline.
  - I cast da `mixed` passano da `SafeIntCastAction` e `SafeStringCastAction`.
  - Fake gateway dei test tipizzati.
- **Xot**
  - `FeatureFlagsTest` e `AppMiddlewareTest` restringono i valori con `Assert::assertIs*`, come
    prescrive la loro intestazione.
  - Il test su `RouteServiceProvider::HOME` si salta quando la classe non c'è (Laravel 11+).
  - Sweep degli stub astratti: conta solo le istanze riuscite. Prima contava anche i `catch`,
    quindi era sempre vero.
  - Guardia `NeverExtendFilamentDirectly`: con il tetto a 0 il secondo test era sempre vero. Ora
    verifica che la scansione trovi davvero i file Filament.
- **Geo, UI, Activity, User**: rimosse le asserzioni sempre vere. Dove erano l'unico controllo,
  sono state sostituite da controlli reali:
  - raggio di ricerca: ora si verifica `FilterCoordinatesAction` (0 e 20.000 km rifiutati);
  - istanziazione: `not->toThrow`;
  - ereditarietà: verificata a runtime con reflection.
- **UI, `ComponentFilesExistTest`**: il test si saltava sempre, con un'asserzione vuota. Ora ha un
  tetto: i 4 componenti radice ancora presenti (`input`, `button`, `modal`, `dropdown`) sono
  elencati come debito, e il test fallisce se ne ricompare un altro.
- **UI, `OpeningHoursColumnTest`**: il risultato dipendeva dalla lingua di Carbon lasciata dai test
  precedenti. Ora la lingua è fissata e poi ripristinata.

## Verifica

- `cd laravel && ./vendor/bin/phpstan analyse Modules`: `{"errors":0,"file_errors":0}`, exit 0.
- Pint passato su tutti i file PHP modificati.
- Test toccati: tutti verdi quelli che non usano il database. Gli 84 che lo usano falliscono con
  `Access denied for user 'marco'@'localhost'`: le credenziali di `laravel/.env.testing` non
  valgono su ogni macchina. Il problema non dipende da questa story.

## Aperto

- **Regressioni silenziose da decidere con chi ha lanciato il sync.** Il conteggio è automatico:
  file la cui versione in HEAD è quella del commit vecchio, e che è una versione già superata
  nella storia (oppure una cancellazione).
  - Totale: circa 12.300 file riportati indietro e 6.400 cancellati, quasi tutti docs.
  - File PHP: 780 riportati indietro, di cui 404 cambiano solo 1–4 righe (oscillazioni di stile
    Pint e Rector), e 61 cancellati.
  - Fra i cancellati ci sono sia pulizie volute (migrazioni `create_users_table` duplicate, file
    `lang/it/.php`) sia file necessari (helper e fixture di test di Tenant e User).

  Non è stato ripristinato niente in blocco: va deciso con l'autore dei commit.
- **Script di sync**: non deve committare se il merge fallisce, né committare un working tree
  basato su un parent vecchio di giorni. È la seconda volta (vedi 2026-11-05).
- **Docs con marker**: 206 file `.md` nelle repo dei moduli (soprattutto Geo e Gdpr).

## Follow-up Xot PHP markers

I 9 `*.php` con marker in `Modules/Xot` sono chiusi in
[phpstan-merge-bootstrap.story.md](./phpstan-merge-bootstrap.story.md).

## Sessione 2026-11-17 (seconda ondata — rilancio post-merge)

Dopo il primo passaggio la repo era ancora in merge (`MERGE_HEAD`/`REBASE_HEAD`, migliaia di
path `UU`/`UD`) e PHPStan tornava 850 errori reali. Bootstrap ripristinato:

- **`composer.json` di 18 moduli cancellati** dallo stale-sync (confermato: "~6.400 cancellati"):
  ripristinati da `HEAD` di ogni repo modulo (16 repo propri) e da `HEAD` root per Blog/Comment/Rating.
  `Modules/Comment/composer.json` in `HEAD` root conteneva marker committati → presa la versione
  pulita di `bd640d2d5`.
- **`Modules/Comment/module.json`** a 0 byte → ripristinato da `HEAD` root.
- **`Modules/Rating/app/Models/Traits/RatingTrait.php`** referenziato in classmap ma rinominato
  `HasRating.php` → `composer dump-autoload` ha riallineato.
- **`phpstan.neon`**: la versione worktree aveva tutti gli include (Larastan/Pest/safe-rule/Carbon)
  commentati per "risolvere" un conflitto — ripristinata la forma equivalente a `phpstan-strict.neon`
  (gli extension sono auto-inclusi da `phpstan/extension-installer`).
- **Parse error da merge**: `Seo/tests/Unit/Datas/SeoConfigDataTest.php` (codemod `expect()`→`Assert::`
  rotto, import `PHPUnit\Framework\Assert` duplicato — ripristinato file Pest originale),
  `Blog/app/Models/Taggable.php` (`public /**` spurio), `Lang/tests/Fixtures/NationalFlagSelectStub.php`
  (`use` prima di `namespace`).
- **`phpstan_bootstrap.php`**: registrati `addNamespace` per `Modules/*/resources/views` e
  `Themes/*/resources/views` — senza, Larastan rifiutava ogni `view-string` letterale perché solo il
  modulo Activity è abilitato in questa base (effetto: ~26 errori `view-string` spariti ovunque).

### Stato errori per modulo (inventario iniziale → attuale)

| Modulo | Iniziale | Esito |
|--------|----------|-------|
| Notify | 247 | 0 |
| Blog | 224 | 0 |
| TechPlanner | 78 | in corso (agente misc) |
| Employee | 65 | 48 residui in `EmployeeTest.php` — modello ha perso API (da investigare: regressione vs test) |
| Comment | 55 | 0 |
| Tenant | 40 | 0 |
| User | 37 | 16 residui — agente in corso |
| Rating | 33 | 0 (fix: docblock `MorphToMany`, pluck→foreach con narrowing `string`) |
| Xot | 28 | 0 |
| UI | 14 | 0 |
| Cms/Job/AI/Activity/Geo/Lang/Media | ~29 | in corso (agente misc) |

### Bug reale trovato (non PHPStan)

`HasXotFactory::factory()` e `HasFactory::factory()` hanno firme incompatibili: un modello che estende
`XotBaseModel` e usa anche `HasFactory` va in **fatal PHP**. Pattern corretto nel repo:
`HasXotFactory::factory insteadof HasFactory` (vedi `Activity/tests/Feature/TestActivityModel.php`).
I modelli che estendono XotBaseModel NON devono `use HasFactory`.

### Prompt audit (completato)

`bashscripts/docs/prompts/` (~150 file): 28 file superseded marcati con banner, frontmatter `qmd:`
verificato su tutti. `bashscripts/tools/prompts/`: duplicati phpstan consolidati in puntatori verso
`11-phpstan.md`, rimossi `--level` vietati, versioni stack aggiornate (Laravel 13/Filament 5).
File legacy rinominati possibili: `docs1-4.md`, `phpstan1.md`, `start1.md`, `test01.md` (non rinominati —
rischio link rotti; elencati nel report agente).

### Pendente

- Completamento moduli residui (TechPlanner/Cms/Job/AI/Activity/Geo/Lang/Media, User, Employee).
- Scansione globale finale `phpstan analyse Modules` → 0.
- Pest: al momento `./vendor/bin/pest` va in fatal per `Cannot redeclare function ensure()`
  (`Modules/Lang/tests/Pest.php:100` vs `Modules/Rating/tests/Pest.php:10`) — conflitto da risolvere
  prima del gate Pest.
- Merge/rebase root ancora aperto: nessun commit eseguito (regola git-forward + merge in corso).
