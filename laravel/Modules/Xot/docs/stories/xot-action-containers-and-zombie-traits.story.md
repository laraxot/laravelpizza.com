---
title: "Xot: contenitori travestiti da Action, trait zombie e codice morto"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: Xot
epic: ../bmad/epic-code-quality-ratchet.md
depends_on: [services-parity-audit-xot, debug-leftovers-cleanup-xot, livewire-to-filament-widgets-fleet]
related: [services-to-actions-global-wave, docs-organization-xot, ../../../../../bmad-output/epic-services-to-queueable-actions.md]
tags: [actions, queueable-action, trait-unused, zombie, helper, classmap, livewire, ratchet-w4]
qmd: "xot action contenitori statici execute void finto trait unused zombie Store Update HasXotTable Helper.php maiuscolo classmap XotBaseComponent"
---

# Xot: contenitori travestiti da Action, trait zombie e codice morto

Fase BMAD: Plan (scheda di lavoro per domani). Nessun PHP toccato per scriverla. Questa story NON rifa' il lavoro delle story collegate: contiene solo cio' che resta dopo di loro. Cifre del 2026-10-20 13:50-14:05 UTC, volatili.

## Richiesta
Ordine permanente dell'utente: migliorare la qualita' del codice con BMAD + second brain + filament blueprint, andando alla sorgente e capendo lo scopo. Per le Action: una classe = un use case con `execute()` vero, accodabile (Spatie QueueableAction). Un contenitore di metodi statici con un `execute(): void {}` vuoto aggira il gate "function execute(" e resta un Service.

## Scopo
Il gate del prompt 26 chiede `execute()` perche' solo cosi' una Action si accoda e si testa da sola. I contenitori sotto hanno aggiunto il metodo vuoto per superare il gate, ma la responsabilita' e' ancora quella di un Service (regola `no-services-rule.md`). Le Action zombie (zero chiamanti) e i trait senza consumatori sono silenziati con `@phpstan-ignore` invece di essere tolti: l'ignore nasconde il segnale che dice "questo non serve". Gia' coperto altrove, qui NON si ripete: `FileAction` e' stata eliminata (working tree, `Modules/Xot/app/Actions/File/FileAction.php` assente, zero riferimenti); la parita' dei Service e' in `services-parity-audit-xot`; i residui `dd/dddx` sono in `debug-leftovers-cleanup-xot`.

## Stato misurato
- `execute(): void {}` vuoti: 9 (Xot `ModuleAction.php:95`, `XotAction.php:23`, `ThemeAction.php:56`, `ArrayAction.php:60`, `UrlAction.php:39`, `ContextCompressorAction.php:122`; AI `ContextCompressorAction.php:122` (corpo identico a Xot, `diff` vuoto); User `Shield/ShieldUtilsAction.php:318` con 37 `public static`; Geo `GoogleMapsAction.php:189`). `rg -nU -P 'function execute\(\)\s*:\s*void\s*\{\s*(//[^\n]*\n\s*)*\}' Modules/*/app -g '*.php'`.
- Chiamanti (parola intera in `app`, `resources`, `routes`, `config`): zero per `ModuleAction`, `XotAction`, `ThemeAction`, `ArrayAction`, `UrlAction`, `ConfigAction` (29 righe, senza `execute`) e `ShieldUtilsAction`; `ContextCompressorAction` solo un test AI; `GoogleMapsAction` un chiamante vivo (`Geo/app/Actions/Elevation/GetElevationAction.php:42`).
- `@phpstan-ignore`: 69 in `Modules/*/app`, Xot 44, `HasXotTable.php` 25 (13 `method.deprecated`, 8 `alreadyNarrowedType`; righe 91-538, `rg -n '@phpstan-ignore' Modules/Xot/app/Filament/Traits/HasXotTable.php`).
- `trait.unused`: 24 in 6 moduli (`rg -n 'trait\.unused' Modules/*/app -g '*.php'`). Xot 11. Senza alcun consumatore reale in `app`: `HasUuid`, `HasDynamicFillable`, `HasCommonScopes`, `HasCsrfToken`, `HasCustomModelLabel`, `HasTableFunctionsTrait`, `EnumIntegerTrait`, e `HasSchemalessAttributes` (Profile usa il trait Spatie omonimo, non questo). Con consumatori veri e ignore stantio: `HasCustomRelations` (Quaeris `SurveyPdf`, `QuestionChart`), `HasExtraTrait` (5 file in User, Limesurvey, Quaeris), `NavigationPageLabelTrait` (Job `CreateSchedule`, User `PasswordExpired`).
- Albero `Actions/Model/Store/*` (12 file, 6 sono stub `LogicException`): `StoreAction.php` ha zero chiamanti, nemmeno nei test. Albero `Update/*` (14 file): raggiunto solo da `UpdateAction` (dispatch `__NAMESPACE__.'\\Update\RelationAction'`, `UpdateAction.php:45`) e dai suoi figli, piu' 2 test (`tests/Unit/Actions/Model/Update/CustomRelationActionTest.php`, `XotHasManyWidgetCoverageTest.php`).
- `Modules/Xot/Helpers/Helper.php` (1220 righe) non e' caricato (carica `helpers/Helper.php`, 348 righe, `vendor/composer/autoload_files.php:177`) ma ridefinisce `dddx(): string` (:164) e definisce `getModuleModels` (:615, unico chiamante nello stesso file) e `cssInLine` (:1169), usata come funzione da `Modules/Notify/resources/views/layouts/ark.blade.php:11`: se il layout `ark` (tema Notify selezionabile, `NotifyThemeForm.php:42`) viene reso, fallisce con funzione indefinita (non verificato a runtime).
- `catch` vuoti (tokenizer): 25 in `Modules/*/app`, Xot 11 (`XotBaseServiceProvider.php:81,127,201`, `XotSeedHelper.php:50`, `xot.seed.helper.php:59`, `ModuleAction.php:86`, `Cast/SafeArrayByModelCastAction.php:38`, `Model/GetAllModelsByModuleNameAction.php:62`, `Model/GetSicureArrayByModelAction.php:29`, `Widgets/XotBaseInfolistWidget.php:70`, `OptimizeFilamentMemoryCommand.php:363`).
- Classmap stantia: `vendor/composer/autoload_classmap.php` (10:37) elenca 21 path Xot inesistenti (`FileAction`, 9 Service...), Geo 6, Tenant 6, Notify 2, Lang 2, User 2, UI 1.
- Comandi duplicati `xot:view-db-config` e `xot:parse-print-page`: Xot e DbForge, stessa signature; le copie Xot ora sono mirror (commento "Mirror di ... canonico"); entrambi registrati da `XotBaseServiceProvider::registerCommands()` (:147) e dalle voci di `app/Console/Commands/_components.json` dei due moduli.
- `Http/Livewire/XotBaseComponent.php`: zero sottoclassi e zero import (`rg 'Http\\Livewire\\XotBaseComponent'`).

## Lavoro
1. **Gusci morti a zero chiamanti** (`ModuleAction`, `XotAction`, `ThemeAction`, `ArrayAction`, `UrlAction`, `ConfigAction`, `Xot/ContextCompressorAction`): cancellare con i loro eventuali test (regola 25). Rischio basso. Prima `rg -w` di nuovo e controllare che i successori citati in `services-parity-audit-xot` esistano.
2. **`AI/ContextCompressorAction`** (copia identica, un test): tenere una sola copia e dare un `execute()` vero (decisione 1). Rischio basso.
3. **`ShieldUtilsAction` (User) e `GoogleMapsAction` (Geo)**: cross-modulo, non si toccano da qui. Segnalare agli owner: ShieldUtils ha zero chiamanti in `app` (due test lo usano), GoogleMaps ha un chiamante. Fix proposto: azioni piccole, una per responsabilita'. Rischio medio (Geo), basso (User).
4. **Albero `Store/*` e `Update/*`**: cancellare `StoreAction` con `Store/*`; per `Update/*` decidere (decisione 2). Rischio basso-medio (2 test Xot).
5. **8 trait Xot senza consumatori**: cancellare con i test (`Fixtures/Traits/*Probe`, `HasCommonScopesTest`). `EnumIntegerTrait.php:39` dichiara un trade-off (API di piattaforma): serve decisione 3. **3 ignore stantii** (`HasCustomRelations.php:20`, `HasExtraTrait.php:25`, `NavigationPageLabelTrait.php:9`): togliere e verificare con PHPStan mirato. Altri 12 trait di altri moduli: elenco in "Decisioni aperte".
6. **`HasXotTable.php` (25 ignore)**: i `method_exists` difensivi su metodi sempre presenti e i 13 `method.deprecated` si correggono con l'API Filament 5, non con altri ignore. Rischio medio (744 righe, usato da tutte le tabelle): un solo agente, PHPStan mirato.
7. **`Helpers/Helper.php` maiuscolo**: unire o eliminare. Prima porta `cssInLine` dove serve a Notify (o correggere il layout `ark` a usare `$_theme->cssInLine`, come gli altri template), poi cancellare. Rischio medio (Notify).
8. **Comandi duplicati**: togliere le copie Xot e rigenerare `Xot/app/Console/Commands/_components.json`. Rischio basso; la regola e' che un comando nuovo senza voce nel JSON non si registra.
9. **11 `catch` vuoti Xot**: log con contesto o rilancio. Rischio basso, tranne i provider (`XotBaseServiceProvider`) dove l'ignore e' intenzionale per asset opzionali: decisione per riga.
10. **`XotBaseComponent` Livewire**: RETIRE a foglie chiuse, cioe' dopo la story `livewire-to-filament-widgets-fleet` (le 23 classi Livewire); qui solo il controllo finale.

## Acceptance criteria
- [ ] `rg -nU -P 'function execute\(\)\s*:\s*void\s*\{\s*\}' Modules/Xot/app -g '*.php'` non stampa nulla.
- [ ] `rg -n 'trait\.unused' Modules/Xot/app -g '*.php'` non stampa nulla.
- [ ] `rg -c '@phpstan-ignore' Modules/Xot/app/Filament/Traits/HasXotTable.php` stampa 0.
- [ ] `ls Modules/Xot/Helpers/Helper.php Modules/Xot/app/Actions/Model/StoreAction.php` dice "No such file".
- [ ] `rg -n 'cssInLine' Modules/Notify/resources/views/layouts/ark.blade.php` non usa piu' una funzione globale.
- [ ] Il contatore Xot `@phpstan-ignore` in `Modules/Xot/app` scende da 44 e la baseline del ratchet e' abbassata.

## Verifica
Per ogni zero: ripetere il `rg` su un caso noto (`rg -w 'UpdateAction' Modules/Xot/app/Actions/Model/Update` deve trovare 4 file). `php -l` e PHPStan mirato sui file toccati, in coda `flock`. Dopo la cancellazione di una classe, `rg -w` sul nome in `app`, `resources`, `routes`, `config`, `tests`, `docs`, e controllo di `Modules/*/app/**/_components.json`.

## Vincoli
- Nessun Pest/PHPUnit finche' la guardia DB non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta. PHPStan solo mirato, in coda `flock` di `11-phpstan.md`; un solo run completo a swarm fermo e a RAM libera. `laravel/phpstan.neon` immutabile.
- Un solo agente per modulo che edita PHP (Xot qui; User, Geo, Notify, AI: owner propri). Forward-only. Pest resta Pest.
- Niente nuovi `*Service`; logica in Spatie QueueableAction con `execute()`. Niente `mixed`, `@var`, ignore di comodo.
- `composer dump-autoload` NON si lancia senza il via dell'utente: `post-autoload-dump` esegue `artisan package:discover` e `artisan filament:upgrade`, cioe' boota l'app.

## Decisioni aperte
1. `ContextCompressorAction`: tenere la copia Xot o AI? 2. `Update/*`: cancellare o completare (6 stub su 14)? 3. `EnumIntegerTrait`: API di piattaforma da tenere o ritirare? 4. `composer dump-autoload` (21 righe stantie Xot): quando, e chi lo lancia. 5. Altri trait zombie per owner: Notify `HasContact`, `HasNotificationRateLimiting`, `HasNotificationTracking`, `HasTenantNotifications`; Activity `HasEvents`, `HasSnapshots`; Lang `HasStrictTranslations` e `TranslatorTrait` (usato solo dal probe `TranslatorTraitPhpstanProbe`); User `HasPasswordExpiry`, `HasTeamsMembershipAdministration`, `HasPassportConfiguration`, `HasRoles` proprio; ignore stantii: Tenant `SushiToPhpArray` (usato da User `SocialProvider`).

## Come ripartire
1. Rilancia i `rg` di "Stato misurato" e scrivi in fondo una nota datata con le differenze (le altre sessioni cancellano file mentre lavori).
2. Parti dalle voci 1 e 4 (zero chiamanti, rischio basso): per ognuna `rg -w` sul nome in tutto il repo, cancella classe e test, aggiorna `_components.json` se serve.
3. Poi le voci 5 e 8; lascia `HasXotTable` (voce 6) a un agente dedicato con PHPStan mirato in coda.
