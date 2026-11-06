---
title: "[STORY] Xot: parita' dei Service cancellati con le Action successore"
type: story
status: ready-for-dev
created: 2026-10-20
updated: 2026-10-20
module: Xot
epic: ../../../../../bmad-output/epic-services-to-queueable-actions.md
tags: [services, queueable-action, parity, xot, fake-conversion, no-services-rule, w2]
qmd: "xot services parita action successore conversione finta translators trend file action ot_action profiletest helper maiuscolo getModuleModels cartella app services"
related:
  - ./services-to-actions-global-wave.story.md
  - ./services-to-actions-xot-artisan.story.md
  - ./services-to-actions-xot-route.story.md
  - ./services-to-actions-xot-small.story.md
  - ../services/queueable-action-migration.md
---

# [STORY] Xot: parita' dei Service cancellati con le Action successore

Fase BMAD: Dev, wave W0 (solo documentazione). Questa story prepara la wave W2 (parita') del modulo Xot. Nessun codice PHP e' stato toccato per scriverla.

## Richiesta

Ordine dell'utente (2026-10-20): "i services vanno tutti convertiti in spatie queable actions, capisci il perche' capisci il senso". Lo stato finale chiesto e' la cartella `laravel/Modules/Xot/app/Services/` inesistente, non solo l'assenza di classi `*Service`. Epic: [epic-services-to-queueable-actions](../../../../../bmad-output/epic-services-to-queueable-actions.md).

## Stato misurato il 2026-10-20 alle 12:44 UTC (volatile)

- Dal disco (12:47): `Xot/app/Services/` non esiste. Alle 12:44 conteneva `.gitignore` (tracciato) e `RouteService.php.bak` (non tracciato, 10590 byte, 357 righe, sha256 `388dc8d063fd772c57d4526a1968fddf9ba4c74bca0bad655107438e9ac80944`). La rimozione e' dichiarata dalla sessione `base-quaeris-fila5-94`; il file `.bak` non si trova piu' in nessuna cartella del repo (`find` per `RouteService.php.bak*`: vuoto).
- Il contenuto del `.bak` esiste ancora come blob nel database oggetti di `Modules/Xot`: `git cat-file -p def10b017e95 | sha256sum` restituisce lo stesso sha256 e `git cat-file -s def10b017e95` 10590 byte. Il blob non e' in `ls-tree HEAD`, ma `git log --all --find-object=def10b017e95` lo trova in tre commit di luglio (`6d0e7637f`, `795dba20b`, `7953b2040`), tutti su `app/Services/RouteService.php`: il contenuto del `.bak` coincide con una versione tracciata di quel file, quindi si recupera con `git show <commit>:app/Services/RouteService.php`.
- `git -C Modules/Xot ls-tree -r --name-only HEAD -- app/Services` e `laraxot/dev`: 1 file (`.gitignore`). Alle 10:00 `laraxot/dev` ne aveva 33: la pulizia e' arrivata a monte alle 12:19 con `398a78fa1`. Controprova della misura: stesso comando su Geo restituisce 6.
- La cartella `Xot/tests/Unit/Services/` esiste ancora (e il comando `find ... -name Services` la stampa) con 2 test tracciati (`ThemeServiceTest`, `UrlServiceTest`) che importano solo le Action (`Get/Set/Is/GetPathThemeAction`, `IsValidUrlAction`), non i Service.
- Il merge su Xot e' chiuso (nessun `MERGE_HEAD`, nessun file non risolto alle 12:34). Prima di agire rifare `git -C Modules/Xot status --short` e `git -C Modules/Xot diff --name-only --diff-filter=U`.

## Analisi dello scopo dei Service cancellati

Fonte: censimento del 2026-10-20 e codice recuperato con `git -C Modules/Xot show 398a78fa1^:app/Services/<File>`.

| Service | A cosa serviva |
|---|---|
| `ArtisanService` (7 static) | Pannello `act=...` (migrate, routelist, optimize, clear, error, module-list) e wrapper di `Artisan::call` da browser. A livello di file definiva `STDIN`. |
| `ConfigService` | Nessuno: singleton con costruttore commentato. |
| `HtmlService` (`toPdf`) | HTML in PDF con Html2Pdf, in tre uscite (contenuto, file, show). |
| `ModuleService` | Elencare i modelli concreti di un modulo per riflessione su `Models/*.php`. Teneva stato in un singleton (`$name`). |
| `RouteDynService` (18 static) | DSL di route da config verso `Route::group/resource/match`. Teneva `$namespace_start` statico. |
| `RouteService` (8 static) | Helper di route: sei in admin, URL dell'azione, nome route annidato, URL per lingua, azione, modulo, controller e view correnti. |
| `ThemeService` (4 static) | Tema attivo: set, get, is, path. Teneva `$currentTheme='default'` statico piu' `Config::set('theme.active')`. |
| `UrlService` | Validita' di un URL con `filter_var`. |
| `XotService` | Restituire la classe Tenant (`Modules\User\Models\Tenant`, dipendenza da User). |
| `Translators/*` (6 classi) | Stub mai implementati di traduttori esterni (Apertium, DeepL, Google, MyMemory, Systran, base). Il traduttore vivo e' `Lang/app/Adapters/TranslatorAdapter.php`. |
| `Trend/Adapters/*` (4 classi) | Copia delle strategie SQL che `Flowframe\Trend` sceglie da solo; esistono altre due copie in `Actions/Trend/{Adapters,Format}`. |
| `ProfileTest` | Stub di `Profile` con `isSuperAdmin(): true`: codice di produzione che dice sempre sì. Nessun chiamante. |
| `FileService.ot_action` (35708 byte) | Bozza non autoloadabile di `FileService` con 30 static (asset, path2Url, getRealFile, copy, getComponents, vite...). |

## Tabella metodo del Service verso Action o Adapter successore

Ogni path e' stato verificato su disco il 2026-10-20. "Prod" = file di produzione che citano la classe in codice (esclusi la classe stessa, test, docs, commenti), misurati con `rg -P` e controprova su `GetTenantNameAction` (5) e `SafeStringCastAction` (164).

| Metodo del Service | Successore | Prod |
|---|---|---|
| `ArtisanService::act` | `app/Actions/Artisan/HandleArtisanActRequestAction.php` + `app/Enums/ArtisanActEnum.php` | 1 (l'enum; nessun route o pagina espone `act`) |
| `errorShow`, `showRouteList` | `ShowArtisanErrorLogAction`, `ShowArtisanRouteListAction` (stessa cartella) | 1 ciascuna (solo la catena sopra) |
| `errorClear`, `sessionClear`, `debugbarClear` | `ClearArtisanErrorLogAction`, `ClearArtisanSessionFilesAction`, `ClearArtisanDebugbarFilesAction` | 1 ciascuna (stessa catena) |
| `exe` | `RunArtisanCommandAction` | 1 (la catena `act`) |
| (uso reale da Filament) | `app/Actions/ExecuteArtisanCommandAction.php` | 2 (`Filament/Pages/ArtisanCommandsManager`, Passport dashboard) |
| `HtmlService::toPdf` | `app/Actions/Html/HtmlToPdfAction.php` | 2 (Quaeris `MakePdfAction`, Notify `NotifyTheme/Attachment/Pdf`) |
| `ModuleService::getModels` (+ `make`, `setName`) | `app/Actions/Model/GetAllModelsByModuleNameAction.php` | 3 (Tenant `ResolveTenantModelClassAction`, Xot `GetAllModelsAction`, `Helpers/Helper.php` non caricato) |
| `RouteDynService::dynamic_route` e 17 passi | `app/Actions/Route/RegisterDynamicRoutesAction.php` (12 helper privati, 366 righe) + `GetRouteMethodAction.php` | 0 la prima (solo test), 1 la seconda (la prima) |
| `RouteService::inAdmin` | `app/Actions/Route/IsAdminRouteAction.php` | 0 |
| `urlAct`, `getRoutenameN`, `urlLang` | `BuildActionUrlAction`, `BuildNestedRouteNameAction`, `BuildLanguageUrlAction` | 0 |
| `getAct`, `getModuleName`, `getControllerName`, `getView` | `GetCurrentRoute{ActionName,ModuleName,ControllerName,View}Action` (tutte su `GetCurrentRouteHandlerAction`) | 0 (4 per l'handler, interni) |
| `ThemeService::getTheme` | `app/Actions/Theme/GetThemeAction.php` | 3 (Cms `Livewire/Page/Show` due volte, piu' `GetThemePathAction`/`IsThemeAction`) |
| `setTheme`, `isTheme`, `getThemePath` | `SetThemeAction`, `IsThemeAction`, `GetThemePathAction` | 0 |
| `UrlService::checkValidUrl` | `app/Actions/Url/IsValidUrlAction.php` | 0 |
| `XotService::getTenantClass` | `app/Actions/Xot/GetTenantClassAction.php` | 0 |
| `ConfigService` | nessuno, nessun caso d'uso | n.a. |
| `Translators/*` | `Lang/app/Adapters/TranslatorAdapter.php` (Adapter, non Action) | 2 (Lang) |
| `Trend/Adapters/*` | `app/Actions/Trend/Adapters/*` + `Trend/Format/*` + `BuildTrendCollectionAction` | 0 (`BuildTrendCollectionAction`, 1 test) |
| `FileService.ot_action` (30 static) | `app/Actions/File/` (15 file). `FileAction.php` (1092 righe, 30 static, `execute()` vuoto) e' una copia della bozza | 0 in produzione (126 chiamate in 6 test) |
| `ProfileTest` | nessuno (da non ricreare) | n.a. |

Lettura: otto successori su dieci non hanno consumatori in produzione. Cancellare il Service era sicuro; non e' provato che il successore faccia lo stesso lavoro, e questo e' il lavoro di W2.

## Difetti ereditati da verificare e correggere in W2

1. Conversioni finte. Il commit `e935134ab` ("aggiunge QueueableAction ed execute ai Services esistenti", 17 file, +372 righe) ha messo `use QueueableAction` e un `execute()` dentro 8 Service (`ArtisanService`, `HtmlService`, `ModuleService`, `RouteDynService`, `RouteService`, `ThemeService`, `UrlService`, `XotService`; `ConfigService` non compare in quel commit, mentre il censimento del coordinatore ne conta nove), piu' `Translators/*` (6 classi) e `Trend/Adapters/AbstractAdapter`. Le classi restavano in `Services/` e `*Service`: non e' una conversione (definizione di "chiuso" dell'epic, punto 2). I file sono stati cancellati da `398a78fa1`, ma `docs/services/queueable-action-migration.md` (127 righe, ancora tracciato) descrive quella strategia come riuscita: va marcata `superseded`, non cancellata.
2. Debito W5, lane unica per Xot: `Actions/File/FileAction.php` e' un Service travestito da Action. 1092 righe, 30 metodi `public static`, `use QueueableAction` e un `execute(): void` vuoto (riga 1087, con un commento che lo dichiara "Action di raccolta"), 4 `dddx()` attivi nel codice (righe 349, 421, 435, 526, contati col tokenizer PHP con controprova; gli altri `dddx` del file sono in commenti). E' la `FileService.ot_action` rinominata. Chiamanti: 126 chiamate statiche `FileAction::` in 6 file, tutti sotto `Modules/Xot/tests/`, zero in produzione (con `(?<![A-Za-z0-9_])FileAction::`; il conteggio "149 in 19 file" del censimento senza confine di parola include falsi positivi come `GenerateFormByFileAction::class`, `DownloadLogFileAction::class`, `ReadTranslationFileAction::class`: controprova senza confine = 150 occorrenze). Va diviso per caso d'uso verso le 15 Action gia' presenti in `Actions/File/` (`AssetAction` ha 5 consumatori); il censimento del coordinatore conta 19 metodi senza Action propria (non rifatto qui; quelli che ho trovato senza Action: `path2Url`, `getRealFile`, `allDirectories`, `getNiceFileSize`, `vitePath`, `viteCopy`, `url2Path`, `configCopy`), da valutare uno a uno senza assumere che servino. Con zero chiamanti in produzione la prima domanda e' se servono. Rischio alto: i 6 file di test dipendono dalle firme statiche.
3. `HtmlToPdfAction` (2 consumatori vivi) conserva i difetti del Service: se `request('debug')` e' vero ritorna l'HTML grezzo; nel `catch` fa `dddx()` e `echo` dell'errore. Un'Action accodata non ha `request()` e non deve fare `echo`.
4. `ProfileTest` con `isSuperAdmin(): true` e' stato cancellato. Controllare che non rientri da un altro modulo: `rg -P 'isSuperAdmin\(\): bool' Modules -g '*.php'` e cercare classi di prova nel namespace `Services`.
5. `Helpers/Helper.php` (maiuscolo, 33 KB) non e' caricato: `Modules/Xot/composer.json` e `vendor/composer/autoload_files.php` puntano a `helpers/Helper.php` (minuscolo, 10 KB). Funzioni con `function_exists`: 65 nel maiuscolo, 20 nel minuscolo, 57 solo nel maiuscolo, 12 solo nel minuscolo, 8 in comune. `getModuleModels()` (riga 609) oggi delega a `GetAllModelsByModuleNameAction` e non ha chiamanti fuori dal file: non e' piu' un ponte verso `ModuleService`, ma resta irraggiungibile. Un cambio di autoload la renderebbe viva insieme a 56 altre funzioni. Decisione da prendere prima di toccare, e solo con un unico file canonico.
6. Stato globale: `ThemeService` leggeva lo stato statico `$currentTheme` (default `'default'`); `GetThemeAction` legge `config('theme.active', 'default')`. Dopo `set` coincidono; prima del `set` no, se un altro punto valorizza `theme.active`. Verificare che `RouteDynService::$namespace_start` non sia sopravvissuto in `RegisterDynamicRoutesAction`.
7. `ArtisanService` definiva `STDIN` al caricamento; il guard e' stato portato in `RunArtisanCommandAction` (righe 47-48). Verificare che `act=clear` non includa piu' `key:generate` senza conferma.
8. `Trend`: tre copie delle strategie (le due in `Actions/Trend/` e quella cancellata) e il pacchetto `Flowframe\Trend` che le sceglie da solo. Decidere se `BuildTrendCollectionAction` (0 consumatori, 1 test) serve.
9. Duplicati Tenant/Xot: `Xot/Actions/Config/GetTenantConfigPathAction` e `GetTenantConfigArrayAction` esistono anche in Tenant; i consumatori usano quelle di Tenant (8 file), le copie Xot hanno solo test. Segnalare, non decidere qui (vedi story Tenant).

## Cosa non fare

- Nessuna Action nuova per i metodi senza chiamanti (`RouteService`, `ThemeService`, `UrlService`, `XotService`, `ConfigService`): i successori esistono.
- Nessuna Action che incarta una relazione Eloquent gia' presente su model o trait.
- Non trasformare `Translators/*` in Action: un Translator Laravel vive in `Adapters/`.
- Nessuna modifica a `phpstan.neon` (solo l'utente).
- Non cancellare `RouteService.php.bak` se ricompare: era non tracciato; oggi esiste solo come blob `def10b017e95`.
- Non modificare `laravel/tests/Architecture/ModulesArchitectureTest.php` (ratchet con allowlist `archAllowedServicesDirs()`, oggi solo Geo): si cita, non si duplica.
- Non toccare file in stato di merge (`DU`, `UD`, `UU`) finche' chi ha avviato il merge non lo chiude. Prima di ogni file: `rg -c '^(<<<<<<<|=======|>>>>>>>)' <file>`.
- Non riabilitare `Helpers/Helper.php` maiuscolo "per sicurezza".

## Acceptance criteria

- [ ] Per ogni riga della tabella sopra, la parita' tra Service (da `git show 398a78fa1^:...`) e successore e' registrata nella story con differenze volute e non volute.
- [ ] Verificato il 2026-10-20 12:49 (da rimisurare prima della chiusura): la cartella `laravel/Modules/Xot/app/Services/` non esiste (su disco e nell'indice del repo del modulo). Comando: `find laravel/Modules laravel/Themes laravel/app -type d -name Services -not -path '*/vendor/*'` (non stampa nessun `app/Services`; stampa ancora `Xot/tests/Unit/Services` e `Notify/tests/Unit/Services`, che non sono `app/Services`) e `git -C laravel/Modules/Xot ls-files app/Services` vuoto.
- [ ] I file non-Service che la cartella conteneva sono stati eliminati dall'auto-sync (commit delle 12:14-12:19) senza rinomina: `ProfileTest` (nessun successore, da non ricreare), `Translators/*` (successore `Lang/app/Adapters/TranslatorAdapter.php`), `Trend/Adapters/*` e `Trend.test` (successore `app/Actions/Trend/Adapters/*`), `FileService.ot_action` (successori parziali in `app/Actions/File/`), `XotService.php.no`, `cacheservice.md`, `composer.json` e `bashscripts/*` (nessun lettore). Confermare con `git -C laravel/Modules/Xot show 398a78fa1 --stat` e registrare "eliminato, successore X" nella story.
- [ ] `RouteService.php.bak` (non tracciato) non c'e' piu' su disco dopo le 12:44; il suo contenuto (10590 byte, sha256 `388dc8d0...80944`) coincide con il blob `def10b017e95`, presente nella storia git di `app/Services/RouteService.php`. Registrare in questa story il commit scelto come copia di riferimento; nessuna copia su disco e' richiesta.
- [ ] Da verificare: la rimozione di `app/Services/.gitignore` e' sicura. La radice copre `*.lock`, `package-lock.json`, `*.bak` (righe 3, 9, 23: verificato); `docs/phpstan/` e `/vendor` non verificati.
- [ ] La cartella `tests/Unit/Services/` di Xot non esiste piu' (il ratchet `laravel/tests/Architecture/ModulesArchitectureTest.php` controlla solo `Modules/*/app/Services`, non questa): `ThemeServiceTest` e `UrlServiceTest` spostati con `git mv` in `tests/Unit/Actions/Theme/` e `tests/Unit/Actions/Url/` (cartelle oggi inesistenti; i due test provano le Action), senza rinominare i file di altri. Stessa decisione per `Notify/tests/Unit/Services` (vuota, non tracciata).
- [ ] Debito W5 (lane unica Xot, test mirati): `FileAction` e' diviso per caso d'uso o ridotto a quel che serve davvero (126 chiamate statiche, tutte in 6 test); `execute()` vuoto eliminato; zero `dddx()` attivi in `Actions/File/FileAction.php` (oggi 4).
- [ ] Vettori di rigenerazione (W4), solo da citare qui: `laravel/config/localhost/modules.php:136` aveva `'generate' => true` per `services` e alle 12:5x risulta `false` con commento, modifica non ancora committata (`git status` mostra `M`); `php artisan module:make-service` di nwidart (`vendor/nwidart/laravel-modules/src/Commands/Make/ServiceMakeCommand.php`, `getDestinationFilePath`) crea `app/Services/<Nome>.php` senza guardare `generate`. Nessuna azione in questa story.
- [ ] `HtmlToPdfAction` non legge `request()` e non fa `echo`.
- [ ] `docs/services/queueable-action-migration.md` marcato `status: superseded` con rimando a questa story.
- [ ] Decisione scritta su `Helpers/Helper.php` maiuscolo (un solo file canonico).
- [ ] Nessun file in stato di merge toccato; PHPStan eseguito solo sul perimetro modificato.

## Verifica

Da `laravel/`, comandi dell'epic:

```bash
rg --files Modules/Xot -g '**/Services/**' -g '!**/vendor/**'
git -C Modules/Xot ls-tree -r --name-only laraxot/dev -- app/Services | wc -l
rg -nP '\bclass\s+\w+Service\b' Modules/Xot -g '*.php' -g '!**/vendor/**' -g '!**/tests/**'
find Modules Themes app -type d -name Services -not -path '*/vendor/*'
find Modules Themes app -type d -name Actions -not -path '*/vendor/*' | wc -l   # controprova: > 0 (oggi 57)
```

Atteso a fine W2: primo e terzo comando vuoti, secondo 0, quarto senza `Modules/Xot/app/Services` e senza `tests/Unit/Services`. Guardia di cartella gia' presente: `php artisan test tests/Architecture/ModulesArchitectureTest.php --filter="has no Modules"` da `laravel/` (non eseguito da questa sessione).

## Non verificato

- La parita' di comportamento riga per riga tra Service e Action (e' il compito di W2).
- Il numero di chiamanti indiretti via stringhe FQCN o config (il conteggio sopra e' per nome di classe).
- Se `docs/phpstan/` e `/vendor` in `app/Services/.gitignore` siano ridondanti.
- Lo stato dei lock e dei merge dopo le 13:00 UTC: altre sessioni modificano il modulo senza lock.
- La discrepanza con il censimento del coordinatore ("il `.bak` non coincide con nessuna delle 31 versioni tracciate"): `git log --all --find-object` mostra il contrario per il blob `def10b017e95`. Puo' dipendere da fine riga o dal confronto fatto su un altro percorso; non indagato.