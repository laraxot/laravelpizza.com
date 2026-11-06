---
title: "Cms: test che dicono la verita', tipi alla radice e Filament conforme"
type: story
status: ready-for-dev
priority: P2
created: 2026-10-20
updated: 2026-10-20
module: Cms
epic: ../../../Xot/docs/bmad/epic-code-quality-ratchet.md
depends_on: [xot-test-harness-truth, test-database-guard]
related: [phpstan-test-wave-cms, docs-organization-cms, ../../../Xot/docs/stories/code-quality-filament-label-audit.story.md, ../../../Xot/docs/bmad/stories/livewire-to-filament-widgets-fleet.story.md]
tags: [cms, test, pest, case-pair, skip, tipi, property, filament, livewire, volt, ratchet-w2, ratchet-w3]
qmd: "cms test verita coppie maiuscole loginvolttest FolioRoutesTest assertTrue true homepage JSON skip @property array Page PageContent Section discoverWidgets Livewire Page Show Volt"
---

# Cms: test che dicono la verita', tipi alla radice e Filament conforme

Fase BMAD: Plan (scheda di lavoro per domani). Scritta in sola lettura, senza Pest ne' PHPStan. Cifre del 2026-10-20 13:50-14:05 UTC, volatili.

## Richiesta
Ordine permanente dell'utente: migliorare la qualita' del codice con BMAD + second brain + filament blueprint, andando alla sorgente e capendo lo scopo, non il messaggio d'errore.

## Scopo
Cms serve le pagine del front office (Folio, blocchi JSON per lingua) e il pannello di redazione. I suoi test devono provare che una pagina si crea, si traduce e si serve. Oggi i corpi veri di 4 suite d'accesso stanno in file minuscoli che la suite non raccoglie, mentre gli stub PascalCase accanto dicono "see loginvolttest.php": la suite e' verde senza provare il login. Altri test asseriscono `true`, o trasformano 404 e 5xx in "skipped". I `@var` e i cast nei test esistono perche' i modelli dichiarano `array<array-key, mixed>` per campi che hanno una forma precisa (lingua => lista di blocchi): il tipo manca alla radice, quindi ogni consumatore lo ricostruisce a mano.

## Stato misurato
- Coppie di path che differiscono per maiuscole in `Modules/Cms/tests`: 11 gruppi, 7 identici (authentication, login, loginwidget, registertype, registertypewidget, dashboard, example), 4 divergenti. Script `os.walk` con `lower()` e sha256 (nota in Verifica). `loginvolttest.php`: 24 test, 50 asserzioni (12520 B); `LoginVoltTest.php:12`: 1 test in skip che rimanda a "loginvolttest.php" (425 B). `passwordconfirmationtest.php`: 3 test; `PasswordConfirmationTest.php`: 1 skip. `registertest.php` 843 B contro `RegisterTest.php` 861 B. `pest.php` contro `Pest.php`: differiscono solo per commenti (`diff`), vince `Pest.php`.
- Altri 2 file mai raccolti senza controparte: `Feature/Auth/EmailVerificationTest.pest.php` (3 test), `Feature/Auth/RegisterTypeWidgetTest.php.broken`.
- `assertTrue(true)`: `Feature/Auth/PasswordUpdateTest.php:12,16` e `ProfileUpdateTest.php:24,28,32,36,40` (7 in tutto) - `rg -n 'assertTrue\(true\)' Modules/Cms/tests`.
- `Feature/Frontoffice/FolioRoutesTest.php:56,64,67`: dentro il `foreach` sulle rotte Folio, `markTestSkipped` su rotta dinamica, su 404 e su status >= 500; il primo caso interrompe tutto il test.
- Loader homepage: `tests/TestCase.php:93` `Assert::markTestSkipped('No homepage JSON ...')`; 6 chiamanti (`HomepageFilamentBlocksArchitectureTest` x3, `FilamentBuilderBlocksTest` x2, `IndividualFolioRoutesTest:287`). `find Modules Themes config -path '*/database/content/pages/*.json'` non trova nessun file, quindi su questo tenant tutti saltano.
- Skip: 83 occorrenze (30 `markTestSkipped`, 51 `todo(`, 2 `->skip(`; `IndividualFolioRoutesTest.php` 18). `rg -oP 'markTestSkipped|->skip\(|\btodo\(' Modules/Cms/tests --glob '*.php' | wc -l`. La cifra "95" del censimento era euristica e non si riproduce.
- Tipi: la story `phpstan-test-wave-cms.story.md:104` conta 23 `@var` e 3 cast `(string) $response->getContent()`. Oggi `@var` in `tests/`: 94 (10 in `PageManagementBusinessLogicTest.php`, 8 in `registertypetest.php` e 8 nel gemello identico); cast: 3 in `RegisterTypeTest.php`, 3 nel gemello, 3 in `Frontoffice/TranslationsTest.php`. Radice: `@property array<array-key, mixed>|null` su `Page.php:19-28`, `PageContent.php:17,19`, `Section.php:17,19`.
- `FrontPanelProvider.php:45-48`: `discoverWidgets(in: app_path('Filament/Front/Widgets'), for: 'App\\Filament\\Front\\Widgets')`: la cartella non esiste (`ls laravel/app/Filament` fallisce) ne' in `Modules/Cms/app/Filament/Front` (solo `Pages`).
- Filament: 1 `extends` diretto, `app/Filament/AdminPanelProvider.php:11 extends PanelProvider`, doppione NON registrato (`module.json:11` e `composer.json:17` registrano `Providers\Filament\AdminPanelProvider`). Stringhe hardcoded: 27 su una riga (`Blocks/NavigationBlock.php` 11, `FeatureSectionsBlock.php` 5, `StatsBlock.php` 4, `CtaBlock.php` 4, `Pages/Themes.php:34`...). Script `extends` risolto con gli `use` (nota in Verifica); il censimento diceva 29.
- Livewire/Volt: `app/Http/Livewire/Page/Show.php` (113 righe) ha zero chiamanti (`rg -n 'cms::livewire.page.show|Page\\Show'`); 7 classi in `app/Http/Volt/` (`Verify`, `Login`, `Register`, `Counter`, `Password/{Token,Confirm,Reset}Component`) con zero riferimenti fuori dal proprio file; `_components.json` di `Http` e' `[]`.

## Lavoro
1. **Quattro coppie divergenti**: `diff`, portare il corpo vero nel file PascalCase (`LoginVoltTest.php` prende i 24 test di `loginvolttest.php`), stub solo dove il SUT manca (scala `10-test.md`); togliere il minuscolo solo dopo il diff. `pest.php` -> togliere (solo commenti). Perche': oggi il login non e' provato. Rischio medio: i corpi riesumati possono avere SUT assente. Dipende dal binding (story `xot-test-harness-truth`, decisione 1).
2. **Sette coppie identiche**: togliere il minuscolo (`cmp`). Rischio basso.
3. **`EmailVerificationTest.pest.php`** -> rinominare in `*Test.php`; `.broken` -> decidere (decisione 3).
4. **7 `assertTrue(true)`** (`PasswordUpdateTest.php`, `ProfileUpdateTest.php`): asserire il comportamento (la password cambia, il profilo si aggiorna) oppure `->skip('<X> not implemented')`. Rischio basso.
5. **`FolioRoutesTest.php:56,64,67`**: dataset Pest per rotta; 404 e >= 500 FALLISCONO; skip solo per le rotte dinamiche con fixture dichiarata. Rischio basso, ma potrebbe rivelare rotte rotte vere.
6. **Loader homepage** (`TestCase.php:93`): su Quaeris il JSON non c'e'; o si fa fallire con messaggio, o skip motivato con nome del tenant (decisione 2).
7. **Tipi alla radice**: dichiarare la forma di `content_blocks`/`blocks`/`title` su `Page`, `PageContent`, `Section` (es. `array<string, list<array{type: string, data: array<string, mixed>}>>`, forma gia' in `tests/TestCase.php:75`) e togliere i `@var` e i cast dai test. Mai `mixed`. Rischio medio: tocca i tre modelli, un solo agente su Cms.
8. **`discoverWidgets` in `FrontPanelProvider`**: togliere la chiamata (cartella inesistente, `blueprint` regola 4). Rischio basso.
9. **Doppione `app/Filament/AdminPanelProvider.php`**: cancellare (zero riferimenti, verificare con due metodi). Rischio basso.
10. **27 stringhe hardcoded**: chiavi in `lang/<locale>/` del modulo, `->label()` tolto dove la risoluzione e' automatica; coordinare con `code-quality-filament-label-audit`. Rischio basso, volume alto.
11. **Livewire/Volt**: `Page\Show` RETIRE (orfano) e le 7 classi Volt senza chiamanti; ritiro nella wave della fleet, non da soli. Rischio basso.

## Acceptance criteria
- [ ] Lo script delle coppie stampa 0 gruppi (oggi 11).
- [ ] `rg -n 'assertTrue\(true\)' Modules/Cms/tests` non stampa nulla.
- [ ] `rg -n 'markTestSkipped' Modules/Cms/tests/Feature/Frontoffice/FolioRoutesTest.php` stampa al massimo la riga delle rotte dinamiche con fixture.
- [ ] `rg -c '@var ' Modules/Cms/tests` e i cast `(string) $...->getContent()` scendono a 0 nei sei file citati.
- [ ] `rg -n 'discoverWidgets' Modules/Cms/app` non stampa nulla.
- [ ] `ls Modules/Cms/app/Filament/AdminPanelProvider.php` fallisce; lo script `extends` stampa 0.
- [ ] `find Modules/Cms/app/Http/Volt Modules/Cms/app/Http/Livewire -name '*.php'` non stampa nulla (dopo la fleet).

## Verifica
Script di sola lettura: coppie con `os.walk` + `lower()` + sha256 su `Modules/Cms/tests` (controprova: trova 11); `extends` risolto: per ogni `class X extends Y` in `app/Filament` si risolve `Y` con gli `use` e si segnala se comincia per `Filament\` o `Livewire\` (controprova: lo stesso script su Notify trova `ChannelCheckboxList`). Per gli zero: ripetere il `rg` su un caso noto. PHPStan solo sui file toccati, in coda.

## Vincoli
- Nessun Pest/PHPUnit finche' la guardia DB non e' dentro e l'utente non ha confermato che i DB `*_test` sono usa-e-getta (`test-database-guard.story.md`).
- PHPStan solo mirato e in coda `flock` di `11-phpstan.md`; un solo run completo a swarm fermo e a RAM libera. `laravel/phpstan.neon` immutabile.
- Un solo agente per modulo che edita PHP. Forward-only. Pest resta Pest (5 classi PHPUnit in Cms: conversione separata).
- Niente nuovi `*Service`; logica in Spatie QueueableAction con `execute()`. Niente `mixed`, `@var`, ignore di comodo.

## Decisioni aperte
1. Binding: `uses()` nel file o `Pest.php` (11 file Cms hanno gia' `uses()` e il modulo lega `->in('Feature','Unit')`). 2. Homepage senza JSON su Quaeris: fallire o skip motivato? 3. `RegisterTypeWidgetTest.php.broken` (tracciato in git): ripristinare come test o cancellare. 4. La lane docs ha lasciato decisioni aperte in `docs-organization-cms.story.md` (sezione "Aperto": coppie `PHILOSOPHY.md`/`philosophy.md`, `INDEX.md`/`index.md`, radice di `docs/` a 567 file, link rotti): non sono di questa story.

## Come ripartire
1. Rilancia lo script delle coppie e i `rg` di "Stato misurato"; annota le differenze in fondo.
2. Parti dalle sette coppie identiche e da `pest.php` (voce 2, solo rimozioni dopo `cmp`), poi `diff` della coppia `loginvolt`.
3. Per le voci 7-9 aspetta che nessun altro agente tenga Cms; un solo agente PHP per volta.
