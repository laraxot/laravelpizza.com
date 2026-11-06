---
title: "Censimento verificato: Services to Queueable Actions"
type: bmad-census
status: verified
module: Xot
track: bmad-method
created: 2026-10-20
updated: 2026-10-20
snapshot_evening: 2026-10-20
tags: [bmad, services, queueable-actions, census, w0]
qmd: "censimento services queueable actions chiamanti storia git copie risorte adapter zero dirs"
related:
  - ./services-to-queueable-actions-objective.md
  - ./services-to-queueable-actions-brainstorming.md
  - ./services-to-queueable-actions-architecture.md
  - ./brainstorming-services-to-actions-wave.md
  - ./planning-services-to-actions-zero-folders.md
  - ../stories/services-to-actions-global-wave.story.md
---

# Scopo

Dati misurati il 2026-10-20 per chiudere il task W0 della story fleet. Sono fatti
letti dal filesystem e dalla storia git, non decisioni: la decisione per classe
(`migrate`, `split`, `retire`, `retain as adapter`) resta alla story fleet.

# Metodo e limiti

- Perimetro: ogni `.php` sotto `Modules/*` e `Themes/*`, escluso `vendor`, `node_modules`, `docs` e `tests`, che sta in una cartella `Services/` o si chiama `*Service.php`. Risultato: **42 file, 5005 righe**.
- Chiamanti cercati con `rg -P` su `.php` (anche Blade), `.json` e `.neon` di `Modules`, `Themes`, `config`, `app`, `routes`, `bootstrap`, `database`: FQCN (con 1 a 4 backslash, per le stringhe), `use ...\Nome;` e nome corto nella stessa cartella. Colonna "chiamanti" = file di produzione / file di test.
- Secondo metodo sugli zeri: `git grep -w <Nome>` sui file tracciati. Non ha confermato nessuno zero in modo pulito: ci sono omonimi (`NotificationManager` esiste anche in `Notify/app/Actions`, `GeoService` ha 4 file con quel nome corto). **"0 chiamanti" qui significa "nessun chiamante statico trovato", non "codice morto".**
- Non coperti: classi costruite con stringhe concatenate, bind del container per nome, `Facade` esterne al repo. Vanno verificati classe per classe prima di cancellare.

# Cosa dicono i dati


## Addendum snapshot filesystem: 2026-10-20 (sera, prevale)

| Misura | Esito |
|--------|-------|
| `find Modules -type d -path '*/app/Services'` | **0** |
| `find Modules -path '*/app/Services/*.php'` | **0** |
| `find Themes+Modules+app -type d -name Services` (prod) | **0** |
| Actions `app/Actions/*.php` | **~770** |
| `laraxot/dev` `app/Services` (Xot/Fixcity/Notify/User/Geo/Tenant) | **0** file |
| Falsi positivi `*Service.php` | `Themes/Sixteen/.../MunicipalService.php`, `Service.php` = **modelli dominio** (servizi comunali), non layer Services |
| Residuo Blade | `Themes/TwentyOne/.../hero/dynamic.blade.php`: ex `PredictService` (modulo Predict assente); orchestratore → **props**, non layer Services |
| Ratchet | `NoServicesTest.php` (DCP-270): allowlist vuota; **3 PASS** (sera, pest-scratch) |
| `use Modules\…\Services\` prod | **0** |

Religione: la cartella `app/Services` **non deve riapparire**. Merge che la riesuma → DELETE se Action/adapter gia' esistono; altrimenti migrare a QueueableAction. Planning maintain: [planning-services-to-actions-zero-folders.md](./planning-services-to-actions-zero-folders.md).

## Addendum snapshot filesystem: 2026-10-20 (pomeriggio, storico)

Il census storico (42 file) **non** rappresenta il working tree corrente. Per lo
stato vivo usare l'addendum **sera** sopra.

| Misura | Esito |
|--------|-------|
| `find Modules -type d -path '*/app/Services'` (escl. vendor/tests) | **0** |
| `find Modules -path '*/app/Services/*.php'` | **0** |
| Actions `*Action.php` | **~682** |
| Mid-sessione (~12:40) | 8 dirs + 5 Geo PHP riesumati; `rg 'use Modules\\Geo\\Services\\'` = **0** (match solo commenti «Sostituisce…») |
| Successori Geo | `LoadGeoHierarchyAction`, `ValidateGeoDataIntegrityAction`, `GoogleMapsHttpAction`, Distance/Polygon Actions |
| Ratchet | `archAllowedServicesDirs()` = `[]` |

Se un merge riesuma Geo Services → **delete-again**, non convertire. Non inferire
sicurezza solo dal disco: controllare diff, Action successore e caller dinamici.

1. **Solo ~22 dei 42 sono Service applicativi.** Gli altri sono adapter di driver (`Trend/Adapters` x4), strategie di config (`Tenant/Config` x5, con un contratto), traduttori (`Translators` x6, ognuno ha gia' una `*TranslateAction`), un motore mail (`MailtrapEngine`), uno stream HTTP (`VideoStream`), un file con nome da test (`ProfileTest`) e un falso positivo (`User/app/Http/Livewire/TermsOfService.php`, widget Livewire fuori da `Services/`).
2. **25 su 42 non hanno nessun chiamante di produzione statico.** Tra questi `AIService` (690 righe), `GeoService` (8 metodi statici), `RouteService` (353 righe), `SmsService`, `SubtitleService`.
3. **Quasi tutti hanno gia' un'Action affine** nello stesso modulo (colonna "Action affine", trovata per nome: l'equivalenza funzionale non e' verificata).
4. **Sono risorti coi pull.** `AI`, `Job`, `Lang`, `Media`, `Notify` e `Tenant`: cancellati l'8 ottobre, riaggiunti da commit del 20 ottobre. `Geo`: non sono in HEAD, ma stanno nell'index come aggiunti (cancellati da `60524329`, 8 ottobre). La lane Tenant lo conta come la quarta volta. Per `Xot` e `UI` la storia git non e' lineare (cancellazione piu' recente dell'aggiunta, file presente in HEAD): non interpretare.
5. **Catene interne:** `GeoDataService` usa `GeoDataValidator`, `GoogleMapsService` usa `BaseGeoService`, `TenantService` e' chiamato da `HereService` e dai resolver di `Tenant/Config`.
6. **Chiamanti vivi trovati:** `TenantService` (3), `ArtisanService` (6), `ThemeService` (5), `RouteDynService` (2), `HtmlService`, `UrlService`, `XotService` (1 ciascuno). `ModuleService` e' chiamato solo da `Xot/Helpers/Helper.php` (maiuscolo): la lane xot riporta che composer non lo carica, da verificare.

# Tabella

Colonne: statici/pubblici = metodi `public static` / `public`; storia = ultimo commit che ha cancellato e ultimo che ha aggiunto il file nel repo del modulo.

| Modulo | File (sotto `app/Services/`) | Righe | Stat/pub | Chiamanti | In HEAD | Cancellato | Aggiunto | Action affine |
|---|---|---|---|---|---|---|---|---|
| AI | `AIService.php` | 690 | 0/8 | 0/1 | si | dfed680 2026-10-08 | 0c5e0a4 2026-10-20 | GenerateDs4Action, ChatDs4Action |
| Geo | `BaseGeoService.php` | 146 | 0/0 | 1/0 | no | 60524329 2026-10-08 | b1bc1fb3 2026-09-24 | GoogleMapsHttpAction |
| Geo | `GeoDataService.php` | 254 | 0/5 | 0/0 | no | 60524329 2026-10-08 | b1bc1fb3 2026-09-24 | GetRegionsAction, LoadGeoDataAction |
| Geo | `GeoDataValidator.php` | 217 | 0/3 | 1/0 | no | 60524329 2026-10-08 | b1bc1fb3 2026-09-24 | GeoMapDatasetAction |
| Geo | `GeoService.php` | 218 | 8/8 | 0/0 | no | 60524329 2026-10-08 | b1bc1fb3 2026-09-24 | GetAddressFromBingMapsAction, GeocodeAddressAction |
| Geo | `GoogleMapsService.php` | 90 | 0/3 | 0/0 | no | 60524329 2026-10-08 | b1bc1fb3 2026-09-24 | FormatCoordinatesAction, CalculateDistanceMatrixAction |
| Geo | `HereService.php` | 75 | 1/1 | 0/0 | no | 60524329 2026-10-08 | b1bc1fb3 2026-09-24 | GetCitiesAction, GetProvincesAction |
| Job | `ScheduleService.php` | 36 | 0/2 | 0/0 | si | a14e3d09 2026-10-08 | fbf2ed7d 2026-10-20 | GetActiveSchedulesAction, ClearScheduleCacheAction |
| Lang | `TranslatorService.php` | 62 | 0/2 | 0/0 | si | 2d15ac80 2026-10-08 | 04d814ea 2026-10-20 | RecordMissingTranslationAction, PublishTranslationAction |
| Media | `SubtitleService.php` | 207 | 2/11 | 0/0 | si | 4d58d665 2026-10-08 | ef8c0917 2026-10-20 | UpdateModelSubtitleFieldAction, ParseSubtitleXmlAction |
| Media | `VideoStream.php` | 168 | 0/1 | 0/0 | si | 4d58d665 2026-10-08 | ef8c0917 2026-10-20 | - |
| Notify | `MailEngines/MailtrapEngine.php` | 94 | 2/5 | 0/0 | si | 3d83897ad 2026-10-08 | f066459c9 2026-10-20 | - |
| Notify | `NotificationManager.php` | 166 | 0/7 | 0/4 | si | 3d83897ad 2026-10-08 | f066459c9 2026-10-20 | SendRecordsNotificationAction |
| Notify | `SmsService.php` | 155 | 2/5 | 0/0 | si | 3d83897ad 2026-10-08 | f066459c9 2026-10-20 | SendNotificationAction, SendAgiletelecomSMSv1Action |
| Tenant | `Config/ConfigResolverRegistry.php` | 63 | 0/2 | 0/0 | si | ccbfc94 2026-10-08 | 40f7efe 2026-10-20 | - |
| Tenant | `Config/Contracts/ConfigResolverInterface.php` | 25 | 0/2 | 4/0 | si | ccbfc94 2026-10-08 | 40f7efe 2026-10-20 | - |
| Tenant | `Config/Resolvers/DatabaseConfigResolver.php` | 103 | 0/2 | 2/0 | si | ccbfc94 2026-10-08 | 40f7efe 2026-10-20 | - |
| Tenant | `Config/Resolvers/MorphMapConfigResolver.php` | 106 | 0/2 | 1/0 | si | ccbfc94 2026-10-08 | 40f7efe 2026-10-20 | - |
| Tenant | `Config/Resolvers/StandardConfigResolver.php` | 124 | 0/2 | 1/0 | si | ccbfc94 2026-10-08 | 40f7efe 2026-10-20 | - |
| Tenant | `TenantService.php` | 382 | 13/13 | 3/0 | si | ccbfc94 2026-10-08 | 40f7efe 2026-10-20 | TranslateTenantKeyAction, ResolveTenantModelInstanceAction |
| UI | `UIService.php` | 16 | 1/1 | 0/0 | si | db03c36b 2026-10-08 | 2510f44d 2026-09-24 | GetUserDataAction, GetAllBlocksAction |
| Xot | `ArtisanService.php` | 291 | 7/7 | 6/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | ClearArtisanDebugbarFilesAction |
| Xot | `ConfigService.php` | 44 | 2/2 | 0/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | GetTenantConfigPathAction |
| Xot | `HtmlService.php` | 98 | 2/2 | 1/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | GeneratePdfAction |
| Xot | `ModuleService.php` | 116 | 2/4 | 1/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | ModuleAction |
| Xot | `ProfileTest.php` | 27 | 0/3 | 0/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | - |
| Xot | `RouteDynService.php` | 371 | 18/18 | 2/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | GetRouteMethodAction, RegisterDynamicRoutesAction |
| Xot | `RouteService.php` | 353 | 9/9 | 0/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | ExecuteArtisanCommandAction, ShowArtisanRouteListAction |
| Xot | `ThemeService.php` | 53 | 4/4 | 5/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | SetThemeAction, GetThemeContextAction |
| Xot | `Translators/BaseTranslator.php` | 10 | 0/0 | 5/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | - |
| Xot | `Translators/{Apertium,DeepL,Google,MyMemory,Systran}.php` | 10 ciascuno | 0/0 | 0/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | `*TranslateAction` (una per driver) |
| Xot | `Trend/Adapters/AbstractAdapter.php` | 11 | 0/1 | 3/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | - |
| Xot | `Trend/Adapters/{MySql,Pgsql,Sqlite}Adapter.php` | 27 ciascuno | 0/1 | 0/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | - |
| Xot | `UrlService.php` | 43 | 2/3 | 1/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | BuildActionUrlAction, BuildLanguageUrlAction |
| Xot | `XotService.php` | 22 | 0/1 | 1/0 | si | caf205bf8 2026-10-09 | 1ad60d0f7 2026-09-28 | ModuleAction, GetViewAction |
| User | `app/Http/Livewire/TermsOfService.php` (falso positivo) | 38 | 0/2 | 2/0 | si | - | 35fe9567b 2026-09-24 | - |

# Vincoli emersi dal run PHPStan di oggi

- **Il pull li riporta.** Se `laraxot/dev` non viene ripulito, ogni merge riesuma i Service e i test rotti. Una conversione solo locale si perde. Serve un guard che fallisca quando compare un namespace `*\Services` fuori da un elenco ammesso (come il ratchet dei cicli in `laravel/tests/Architecture/ModulesArchitectureTest.php`; da verificare se copre gia' `Services`).
- **Le lane PHPStan hanno corretto sul posto** alcuni di questi file (Geo x4, Tenant, Media `SubtitleService`, Job `ScheduleService` ridotto a facciata `@deprecated` che delega alle Action, Xot `Helper.php`, `RouteService`, `UrlService`, `RouteDynService`). Dopo ogni conversione rilanciare PHPStan sui file toccati.
- **`SendNotificationAction` definisce `handle()`**, mentre `QueueableAction` in coda cerca `execute()`: un invio accodato fallirebbe (trovato dalla lane notify-a, non corretto). Chi converte `SmsService` e `NotificationManager` deve risolverlo.
- **Pest non e' eseguibile** (DB di test assente e regola MySQL): la verifica del comportamento e' PHPStan, `php -l` e test caratterizzanti solo per le funzioni pure.
