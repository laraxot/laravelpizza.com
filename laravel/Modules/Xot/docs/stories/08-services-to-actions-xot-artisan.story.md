---
title: "[STORY] Xot: ArtisanService e Services/Artisan verso Actions (cluster Xot-artisan)"
type: story
status: done
priority: high
created: 2026-10-08
updated: 2026-10-08
module: Xot
tags: [services-to-actions, queueable-action, artisan, enum, consolidamento, xot]
related:
  - ./18.1.xot-services-to-actions.story.md
  - ./2026-10-06-phpstan-cleanup-xot-app.story.md
  - ../refactoring/artisan-service-refactoring-report.md
  - ../../../../bmad-output/epic-code-standards-services-mixed-const.md
---

# [STORY] Xot: ArtisanService e Services/Artisan verso Actions

## Richiesta

Epic "niente Services, mixed ultima spiaggia, const in tipi adatti" (2026-10-08), cluster Xot-artisan: `app/Services/ArtisanService.php`, `app/Services/Artisan/**` e le copie in `app/Actions/**`. Stabilire quale copia e' viva, consolidare, convertire le mappe comando -> metodo in enum, tenere invariati i valori di `act` (sono l'API di chi li invoca).

## Analisi: tre copie dello stesso codice, nessun chiamante di produzione

La story [18.1](./18.1.xot-services-to-actions.story.md) (2026-09-04) aveva gia' convertito il cluster, ma nel working tree le copie vecchie erano "tornate" (merge, vedi rischio nell'epic). Risultato: tre implementazioni della stessa funzione `act()`.

| Copia | Cosa era | Chiamanti (`rg` su Modules, Themes, config, routes, provider, Blade, stringhe) |
|---|---|---|
| `Services/ArtisanService.php` + `Services/Artisan/**` (12 file) | Originale: `switch` di `act()`, helper statici; handler Strategy + `CommandRegistry` | Zero. I "16 chiamanti" del conteggio erano auto-riferimenti e i due test che gia' puntavano ad `ArtisanAction` |
| `Actions/ArtisanAction.php` | Copia piatta statica (sessione concorrente di settembre), con un finto `execute(): void {}` | Solo 4 file di test |
| `Actions/Artisan/**` | Copia 18.1: 7 Action (`Run`, `ShowErrorLog`, `ShowRouteList`, `Clear*` x3, `HandleArtisanActRequest`) + `CommandRegistry` + `CommandHandlerInterface` + 9 handler | Zero fuori dall'albero stesso |

Nessun route, provider, pagina Filament o Livewire invoca `act`. La pagina Filament `ArtisanCommandsManager` usa `ExecuteArtisanCommandAction`, un'altra cosa.

### Quale e' viva, quale residua

- Viva (canonica): `Actions/Artisan/{Run,ShowArtisanErrorLog,ShowArtisanRouteList,ClearArtisan*}Action` e `HandleArtisanActRequestAction` (copre tutti i 18 act).
- Residuo: i 9 handler + `CommandRegistry` + `CommandHandlerInterface` (in entrambi gli alberi). Il refactoring del 2025-10-01 ([report](../refactoring/artisan-service-refactoring-report.md)) li aveva pensati per far chiamare `act()` al registry, ma il collegamento e' andato perso: `ArtisanService::act()` e' rimasto lo `switch` e il registry non e' mai stato istanziato. In piu' ogni handler leggeva `request()->input('act')` ignorando il comando con cui era stato scelto (accoppiamento nascosto alla request globale) e dispatchava con `$this->$method()` da mappe stringa -> nome metodo.
- Residuo: `Actions/ArtisanAction.php` (copia piatta di `HandleArtisanActRequestAction`).

### SCOPO ritrovato: due pezzi di logica persi nella migrazione ad Action

1. Guard `STDIN`. `ArtisanService` e `ArtisanAction` aprivano il file con `if (! defined('STDIN')) define('STDIN', fopen('php://stdin','r'))`. Non era rumore: con SAPI web `STDIN` non esiste e `Symfony\Component\Console\Helper\QuestionHelper` fa `$inputStream ??= \STDIN` senza guardia, quindi un comando con conferma (`migrate`, `key:generate`) lanciato da una richiesta web va in fatal. `RunArtisanCommandAction`, dove avviene `Artisan::call`, non lo aveva. Ripristinato (`ensureStdin()`, con il motivo nel docblock).
2. Connessione del migrate. `ArtisanService` faceva `DB::purge('mysql')`/`reconnect('mysql')` fissi; `ArtisanAction` usava `database.default` (con fallback a `mysql`). `migrate` gira sulla connessione di default, quindi e' quella da rinfrescare; `HandleArtisanActRequestAction` aveva ereditato il valore fisso. Presa la versione di `ArtisanAction`.

## Modifiche

| Prima | Dopo |
|---|---|
| mappe `const array` comando -> nome metodo nei 9 handler (`CACHE_COMMANDS`, `MODULE_COMMANDS`, `ROUTE_COMMANDS`, `ERROR_COMMANDS`, x2 alberi) e stringhe `'migrate'`, `'routelist1'`, ... nello `switch`/`match` | `Modules\Xot\Enums\ArtisanActEnum` (backed string, 18 case): i valori sono ESATTAMENTE gli act storici, nessun cambio di API. `HandleArtisanActRequestAction::execute()` fa `tryFrom()` (act sconosciuto -> `''`) e un `match` esaustivo sull'enum (PHPStan segnala un case dimenticato) |
| `array<string, mixed> $arguments` in `RunArtisanCommandAction` | `array<string, bool|int|string|list<string>>` (i valori che `Artisan::call` accetta davvero) |

Nomi dei comandi artisan e output invariati. Differenze minori ereditate dalla copia canonica 18.1 (non introdotte qui): `clear` e `debugbar:clear` restituiscono l'output invece di fare `echo` e restituire `''`.

### Eliminati (recuperabili da HEAD del repo del modulo Xot)

`app/Services/ArtisanService.php`; `app/Services/Artisan/{CommandRegistry,Contracts/CommandHandlerInterface}.php` e `Handlers/*` (9); `app/Actions/Artisan/{CommandRegistry,Contracts/CommandHandlerInterface}.php` e `Handlers/*` (9); `app/Actions/ArtisanAction.php`; `tests/Unit/Actions/ArtisanActionTest.php` e `tests/Unit/Services/ArtisanServiceTest.php` (due copie degli stessi 4 test, sull'`ArtisanAction` eliminato). Le modifiche non committate a `ModuleCommandHandler` (parametro privato rinominato `_moduleName` + `Assert::string`) non sono recuperabili da HEAD: erano un riparo cosmetico a un "parametro inutilizzato" e non servono piu'.

`CommandHandlerInterface` non e' stata spostata in `app/Contracts`: senza handler non ha implementatori.

### Test

- Nuovo `tests/Unit/Actions/Artisan/HandleArtisanActRequestActionTest.php`: act sconosciuto, valori dell'enum, 9 act "un comando artisan" (dataset), `module-enable/disable` col nome modulo, migrate senza/con modulo/con modulo non stringa. Gli act distruttivi (`clear`, `error-clear`, `debugbar:clear`, che cancellano log, sessioni, file debugbar) non sono eseguiti.
- `XotArtisanCommandsHelpersCoverageTest`: tolto il test "ArtisanAction act branches" (eseguiva `act('clear')` davvero, cancellando log e sessioni dell'ambiente di test, dentro un `try/catch` che rendeva il test inoffensivo ma vuoto) e gli import orfani.
- `XotExecuteCoverage50Test`: tolte le due chiamate `ArtisanAction::act('route-list'|'migrate')` in `try/catch` (la seconda lanciava un `migrate` reale) e l'import; test rinominato senza "e ArtisanAction".

## Verifica

Da `laravel/`, in background, `nice -n 10`:

```
vendor/bin/phpstan analyse Modules/Xot/app/Enums/ArtisanActEnum.php Modules/Xot/app/Actions/Artisan \
  Modules/Xot/tests/Unit/Actions/Artisan/HandleArtisanActRequestActionTest.php \
  Modules/Xot/tests/Unit/XotArtisanCommandsHelpersCoverageTest.php -c phpstan.neon --no-progress --memory-limit=3G
 [OK] No errors

vendor/bin/phpstan analyse Modules/Xot/tests/Unit/XotExecuteCoverage50Test.php -c phpstan.neon ...
 [OK] No errors
```

- `php -l` su tutti i file creati/modificati: nessun errore di sintassi.
- `rg` su `Modules Themes config routes app bootstrap tests database` (esclusi docs, `*.md`, vendor) per `ArtisanService`, `Services\Artisan\`, `Actions\ArtisanAction`, `CommandHandlerInterface`, `CommandRegistry`, `*CommandHandler`: zero riferimenti vivi (restano due menzioni in docblock "ex ArtisanService").
- Pest: `vendor/bin/pest Modules/Xot/tests/Unit/Actions/Artisan/HandleArtisanActRequestActionTest.php` non e' eseguibile qui: il `TestCase` di Xot apre transazioni sulle connessioni MySQL (`fixcity_user_test` inesistente), 16 failed su `SQLSTATE[HY000] [1049] Unknown database`, 0 assertion. Limite d'ambiente, non un verde.
- Probe senza DB (script fuori repo, bootstrap dell'app con sqlite in memoria, `Artisan` facade finto): `ok=18 ko=0`. Coperti: act sconosciuto, i 9 act "un comando", `module-enable/disable` con nome modulo, `migrate` senza/con modulo (e l'`<h3>` che il ramo modulo stampa), `routelist1`, `error`, `error-show`, `module-list` reale (output in `<pre>`). `STDIN` definito. Non eseguiti per non cancellare file reali: `clear`, `error-clear`, `debugbar:clear` (Action `Clear*` invariate).

## Decisioni

- Handler/registry eliminati e non spostati: due implementazioni della stessa mappa act -> comando, una senza chiamanti e con accoppiamento alla request globale, contro una Action con `match` esaustivo sull'enum. Una sola fonte dei nomi degli act.
- Enum senza `HasLabel`/`HasColor`: non e' un valore mostrato in UI, solo il vocabolario dell'API `act`. Niente metodo `artisanCommand()`: i letterali (`'route:cache'`, ...) restano nel `match`, dove si grep-pano.
- `key:generate` dentro `act=clear` e' storico (rigenera `APP_KEY` e invalida sessioni/dati cifrati): non toccato perche' cambierebbe il comportamento di `clear`, vedi "Aperto".

## Aperto

- `act=clear` include `key:generate`: un "clear cache" che rigenera la chiave applicativa e' pericoloso. Decisione dell'utente se toglierlo; nessun chiamante lo usa oggi.
- Nessun entrypoint (route/Filament) espone `HandleArtisanActRequestAction`: e' infrastruttura senza consumatori. Se resta cosi', candidata alla rimozione in un passaggio dedicato (non cancellata qui: e' la copia canonica della 18.1).
- Il report `docs/refactoring/artisan-service-refactoring-report.md` descrive il vecchio Strategy: marcato superseded con nota datata.
- I residui degli altri cluster Xot in `app/Services/` (`ConfigService`, `HtmlService`, `ModuleService`, `RouteDynService`, `RouteService`, `ThemeService`, `UrlService`, `XotService`, `Trend`, `Translators`) sono fuori perimetro.
