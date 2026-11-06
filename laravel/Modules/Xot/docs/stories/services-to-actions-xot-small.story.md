---
title: "[STORY] Services piccoli di Xot verso Actions, const verso tipi adatti"
type: story
status: done
priority: high
created: 2026-10-08
updated: 2026-10-08
module: Xot
tags: [bmad, services, queueable-actions, const, enum, trend, translators, xot]
related:
  - ../../../../../bmad-output/epic-code-standards-services-mixed-const.md
  - ../../../../../bashscripts/ai/wiki/rules/no-services-rule.md
  - ../services.md
---

# [STORY] Services piccoli di Xot verso Actions, const verso tipi adatti

## Richiesta

Epic `epic-code-standards-services-mixed-const`, cluster "Xot-small": `ConfigService`, `HtmlService`, `UrlService`,
`XotService`, `ModuleService`, `ThemeService`, `ProfileTest`, `Trend/*`, `Translators/*` e le `const` di classe di
`Xot/app` fuori dai perimetri `ArtisanService` e `RouteService`/`RouteDynService` (altri due agenti).

Fase BMAD: dev (implementazione + verifica). Perimetro: solo i file qui sotto.

## Analisi: lo scopo, non il messaggio

Per ogni Service ho cercato i chiamanti (FQCN, nome breve, stringhe, config, provider, test, classmap) in
`laravel/Modules` e `laravel/Themes`. Risultato netto: **nessun Service aveva chiamanti di produzione**. La migrazione
precedente aveva gia' creato le Actions equivalenti e spostato i chiamanti; i Services erano residui. L'unico riferimento
era un test.

| Service (eliminato) | Caso d'uso | Action che lo assorbe (gia' esistente) | Chiamanti trovati |
|---|---|---|---|
| `ConfigService` | nessuno: singleton vuoto, nessun metodo | nessuna (non c'e' un caso d'uso) | 0 |
| `HtmlService::toPdf()` | HTML verso PDF con Html2Pdf | `Actions\Html\HtmlToPdfAction` (port 1:1 verificato) | 0 |
| `UrlService::checkValidUrl()` | validita' URL | `Actions\Url\IsValidUrlAction` | 0 |
| `XotService::getTenantClass()` | classe Tenant | `Actions\Xot\GetTenantClassAction` | 0 |
| `ModuleService::getModels()` | modelli concreti di un modulo | `Actions\Model\GetAllModelsByModuleNameAction` (corpo identico; usata da Tenant) | solo `tests/Unit/ModuleServiceTest.php` |
| `ThemeService` (get/set/is/path) | tema attivo | `Actions\Theme\{Get,Set,Is,GetPath}ThemeAction` | 0 (esistono altri `ThemeService` in UI e Sixteen: non toccati) |
| `ProfileTest` | stub con `hello()`, `hasArea()` e `isSuperAdmin()` sempre `true` | nessuna | 0 |

`ProfileTest` non era un test: era un doppio di `Profile` rimasto nel codice di produzione con `isSuperAdmin(): true`.
Nessun chiamante, nessun contratto implementato: rimosso.

### Trend (strategie per driver DB)

Esistevano **tre** copie delle stesse tre strategie (mysql, pgsql, sqlite), tutte senza chiamanti:
`Services/Trend/Adapters/*` (questa), `Actions/Trend/Adapters/*` (copia gia' spostata, identica) e
`Actions/Trend/Format/*` (variante Action). Il codice vivo e' `Actions\Trend\BuildTrendCollectionAction`, che usa
`Flowframe\Trend\Trend`: il vendor sceglie da solo l'adapter dal driver della connessione (`mysql`/`mariadb`, `sqlite`,
`pgsql`) e in piu' supporta `week`. Prova: `vendor/flowframe/laravel-trend/src/Trend.php:173-177`.
Decisione: eliminata la copia in `Services/Trend`; nessun driver perso (restano le due copie in `Actions/Trend` e quelle
del vendor). Eliminati anche `Trend.test` e `trend.test` (bozza identica di una classe `Trend` che importava la
namespace appena rimossa, mai caricabile perche' senza estensione `.php`).
Non convertito in "Action che sceglie il driver": sarebbe una quarta copia di cio' che il vendor gia' fa.

### Translators

Sei classi da 7 righe (`BaseTranslator` astratta vuota + Google, DeepL, MyMemory, Systran, Apertium che la estendono
senza metodi). FQCN `Modules\Xot\Services\Translators` cercato: nessun riferimento ("Google" compare 141 volte nel
monorepo, ma come parola). Erano stub mai implementati: eliminati. Il `docs.md` accanto conteneva solo segnalibri
(riportati qui sotto, nulla di normativo):
- npm: `rhysd/translate-markdown`, `markdown-translator`;
- servizio a pagamento: `customer.stepes.com/instant-translation-quote/`;
- integrazione da rileggere: `integromat.com/en/integrations/google-translate/markdown`.

### Test

`tests/Unit/ModuleServiceTest.php` (143 righe) controllava via reflection la struttura del Service (`hasMethod`,
visibilita', docblock) e faceva chiamate senza asserzioni. Le uniche asserzioni di comportamento (array vuoto per modulo
inesistente, chiavi/valori stringa, classi astratte escluse) sono gia' coperte da `tests/Feature/ModuleServiceIntegrationTest.php`
sulla `GetAllModelsByModuleNameAction`. Eliminato senza riscrittura: riscriverlo avrebbe duplicato quel test.

## Const di classe (17 in Xot/app fuori dai perimetri degli altri due agenti)

| Const | Esito | Motivo |
|---|---|---|
| `PRIMARY_HEX`, `INSTITUTIONAL_BLUE_HEX` x3 (`Support\PaDesignColors`, `Actions\PaDesignColorsAction`, `Actions\Design\GetPaFilamentPaletteAction`) | enum backed `Enums\PaDesignColorEnum` (`Primary`, `InstitutionalBlue`) | insieme chiuso di colori di marca, replicato in 3 classi. `PaDesignColors` resta il punto documentato (SSoT citato in decine di docs e CSS del tema Sixteen) e legge dall'enum; `PaDesignColorsAction::filamentPalette()` ora delega a `PaDesignColors::filamentPalette()` (prima ne duplicava il corpo); `GetPaFilamentPaletteAction` aveva 0 chiamanti (nome, FQCN, docs): eliminata |
| `SUPPRESSED_IDENTIFIERS` (`PestInternalClassAccessIgnoreExtension`) | resta `private const array` | identificatori PHPStan privati dell'estensione |
| `MAX_RECORDS`, `CHUNK_SIZE` (`FakeSeederAction`) | restano `private const int` | limiti interni di una sola classe, mai riusati |
| `CSV_ESCAPE` (`XotBaseExporter`) | resta `public const string` | valore di protocollo condiviso da writer e reader (3 Jobs + test): deve restare un'unica costante |
| `GROUPS` (`EnvWidget`) | resta `private const array` | layout del form di un solo widget; un campo non elencato compare comunque |
| `PREFIX` (`RecordAnchor`) | resta `public const string` | prefisso dell'ancora HTML; e' l'unica fonte, usata solo dalla classe stessa |
| `MODULE_CONNECTIONS` (`BuildTestSqliteCommand`) | resta `private const array` | nomi di connessione per un comando di sviluppo; non sono in `config/database.php` (e' il motivo del comando) |
| 4 x `*_COMMANDS` (`Actions/Artisan/Handlers/{Cache,Error,Module,Route}CommandHandler`) | **saltate**, non mie | vedi "Aperto" |

## Modifiche

- Eliminati (recuperabili da `HEAD` del repo `Modules/Xot`): `app/Services/{ConfigService,HtmlService,UrlService,XotService,ModuleService,ThemeService,ProfileTest}.php`,
  `app/Services/Trend/Adapters/{Abstract,MySql,Pgsql,Sqlite}Adapter.php`, `app/Services/Translators/*` (6 classi + `docs.md`),
  `app/Services/{Trend.test,trend.test,XotService.php.no,xotservice.php.no}`, `app/Actions/Design/GetPaFilamentPaletteAction.php`,
  `tests/Unit/ModuleServiceTest.php`.
- Nuovo: `app/Enums/PaDesignColorEnum.php`.
- Modificati: `app/Support/PaDesignColors.php` (enum al posto delle const, tipo di ritorno stretto a `array<string, array<int, string>>`),
  `app/Actions/PaDesignColorsAction.php` (enum, delega della palette), `docs/services.md` (nota datata).
- Nessun chiamante da aggiornare altrove: `rg` su `laravel/Modules`, `laravel/Themes`, `config`, provider, classmap non trova
  riferimenti ai Services eliminati (restano solo docblock "Replaces ..." nelle Actions).

## Verifica

- `php -l` su `PaDesignColorEnum`, `PaDesignColors`, `PaDesignColorsAction`: nessun errore.
- PHPStan mirato (12 file: i 3 toccati, i chiamanti `MetatagData`, `XotServiceProvider`, `MetatagDataTest` e i 6 file con
  const che restano), da `laravel/`: `[OK] No errors`.
- Probe senza DB (script fuori repo): palette di `PaDesignColors` e di `PaDesignColorsAction` identiche (`===`) a quella
  attesa costruita con gli stessi hex; hex dell'enum e `execute()` invariati: `PROBE OK`.
- Pest: non eseguito (MySQL di test 10.100.200.53 non raggiungibile da questo host). I test coinvolti
  (`MetatagDataTest`, `ModuleServiceIntegrationTest`) non dipendono dai file eliminati.

## Decisioni

1. Nessuna Action nuova: ogni caso d'uso aveva gia' la sua Action; crearne un'altra sarebbe stata una copia.
2. `PaDesignColors` non e' stato eliminato nonostante i chiamanti di codice usino l'Action: e' il nome citato come SSoT dalla
   documentazione di tema e wiki.
3. Le copie in `Actions/Trend/*` e le Actions "contenitore" della root (`ModuleAction`, `ThemeAction`, `UrlAction`, `HtmlAction`,
   `XotAction`, `ConfigAction`) restano: fuori perimetro.

## Aperto

- Classmap ottimizzata di Composer (`vendor/composer/autoload_classmap.php`) elenca ancora i Services eliminati: serve
  `composer dump-autoload` (non lanciato, `vendor/` e' condiviso).
- `app/Services/` contiene ancora file non PHP non miei: `FileService.ot_action` (35 KB, bozza), `cacheservice.md`,
  `composer.json`, `bashscripts/`, `.gitignore`. Da smistare quando gli altri due agenti avranno finito con `RouteService`/`RouteDynService`.
- `Actions/Trend/Adapters/*` (non sono Action: niente `execute()`, regola "no-services-rule" li vuole in `Adapters/`) e
  `Actions/Trend/Format/*` sono duplicati senza chiamanti di `Flowframe\Trend`; `ModuleAction`, `ThemeAction`, `UrlAction`,
  `HtmlAction`, `XotAction`, `ConfigAction` (root `Actions/`) sono Actions "contenitore" con 0 chiamanti: candidati a eliminazione.
- Const dei 4 handler in `Actions/Artisan/Handlers` (`CACHE_COMMANDS`, `ERROR_COMMANDS`, `MODULE_COMMANDS`, `ROUTE_COMMANDS`):
  file con lock dell'agente Artisan, che ha creato `Enums/ArtisanActEnum` con gli stessi valori `act`. Da chiudere li'.
  Handlers e `CommandRegistry` non hanno chiamanti fuori dal loro albero (il `match` e' in `HandleArtisanActRequestAction`).
- I docblock "Replaces ... (archived to .bak)" nelle Actions `Html`, `Url`, `Theme`: i `.bak` non esistono, la riga e' solo storica.
