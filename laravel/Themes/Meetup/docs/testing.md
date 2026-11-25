---
title: "Testing del tema Meetup"
type: guide
status: active
theme: Meetup
qmd: "testing test pest testcase databasetransactions env.testing migrate refresh database audit front office a11y axe playwright guardie architetturali"
---

# Testing del tema Meetup

Il tema non ha logica di dominio: i test che lo riguardano stanno in tre posti (ogni modulo ha la sua cartella `tests/`; non si aggiungono test in `laravel/tests/`). Questa pagina dice dove sono, come si lanciano, quali regole del database valgono e quali controlli manuali/automatici si fanno prima di un rilascio.

## Dove stanno i test

| Cosa | Dove | Note |
|---|---|---|
| Contratti del tema (test sul sorgente, senza app) | `Themes/Meetup/tests/Unit/PagesAndAuthFormsContractTest.php` | Pest. Verifica che `index`, `[slug]`, `[container0]/index`, `[container0]/[slug0]/index` usino `<x-page` e mai `content-resolver`, e che login/registrazione siano i widget `Modules\User\Filament\Widgets\Auth\LoginWidget` e `Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget` (vedi [ADR](adr/README.md)) |
| Rendering delle pagine del tema | `Modules/Meetup/tests/Feature/` | `PagesTest`, `HeaderLocalizationTest`, `HeaderNavigationTest`, `SeoTechnicalTest`, `FrontOfficePrivacyAndSeoTest`, `EventDetailPageTest`, `PublicEventsListTest`, `ProfileDetailPageTest`, `ProfileEditPageTest`, `ContactFormTest`, `AuthTest`, ... |
| Guardie architetturali | `Modules/Meetup/tests/Unit/Architecture/` | `ThemeIntegrityTest`, `ThemePublicSymlinkTest`, `ModuleAssetsSymlinkTest`, `FolioPagesWithoutSideEffectsTest`, `UniqueVoltFragmentNamesTest`, `NoMergeConflictMarkersTest`, `ProfileContractPhpdocTest` |
| Pagine CMS / Folio / blocchi | `Modules/Cms/tests/` | es. `Feature/Frontoffice/TranslationsTest.php` legge anche il tema |

La suite `Project` di `laravel/phpunit.xml` punta a `Modules/Meetup/tests` ed e' quella che blocca la CI; la suite `Modules` raccoglie `Unit` e `Feature` di tutti i moduli.

```bash
cd laravel
vendor/bin/pest --testsuite=Project                         # suite che blocca la CI
vendor/bin/pest Modules/Meetup/tests/Unit/Architecture      # solo le guardie del tema
vendor/bin/pest Themes/Meetup/tests                         # contratti del tema
```

Solo Pest, mai PHPUnit diretto. Su un ambiente di produzione Pest non si esegue: i test si scrivono e si lanciano in sviluppo.

## TestCase e database (regole critiche)

- `Modules/Meetup/tests/TestCase.php` usa il trait `Modules\Xot\Tests\CreatesApplication` e `DatabaseTransactions` (connessioni `mysql`, `user`, `meetup`). Registra i provider `XotServiceProvider`, `UserServiceProvider`, `MeetupServiceProvider` e in `setUp()` imposta `xra.pub_theme = Meetup` e `xra.main_module = Meetup` (come in produzione, cosi' il profilo e' `Modules\Meetup\Models\Profile`) aggiornando anche `XotData`.
- **Mai** `RefreshDatabase`, `migrate:fresh`, `migrate:refresh` ne' `--force` nei test o negli script: i dati sono sacri e le tabelle dei moduli sono condivise. Si usa solo `DatabaseTransactions` (rollback a fine test).
- **Mai** eseguire migration dentro `setUp()` (niente flag statico `$migrated`): lo schema si prepara una volta fuori dai test con `php artisan migrate --env=testing`.
- **Mai** duplicare nei test la configurazione delle connessioni di modulo (`config(['database.connections.notify' => ...])`, `DB::purge(...)`): le connessioni modulari le crea `TenantServiceProvider` come copia della default; `CreatesApplication` le mappa gia'. Non si inventano variabili `.env` per modulo (`GDPR_DB_DATABASE`, ...).
- `.env.testing` e' una copia di `.env` con database di test (suffisso `_test`) e `APP_ENV=testing`; tutto il resto resta identico. Tutti i moduli condividono lo stesso database di test.
- I TestCase dei moduli derivano dal bootstrap comune di Xot (`CreatesApplication`); i test in `Themes/*` non introducono un bootstrap alternativo.
- Per i test con la lingua: usare `refreshApplicationWithLocale($locale)` e richieste con prefisso (`$this->get('/en/')`), vedi [localization](localization.md).
- Test UI non affidabili nell'ambiente: si sistemano se riproducibili, altrimenti si rinominano `.old` per non inquinare il gate; niente skip a runtime.
- Prerequisito DB: se `php artisan migrate --env=testing` fallisce (es. `Duplicate column name 'user_id'` su `create_event_user_table` del modulo Meetup), i test del tema dipendenti dal DB non sono affidabili: il guasto e' di schema, non di UI/Blade.

## Controlli prima di un rilascio che tocca il tema

1. `cd laravel/Themes/Meetup && npm run build` (vedi [assets-and-build](assets-and-build.md)).
2. Pest: suite `Project` (e `--filter Cms` se si toccano pagine Folio/Volt/blocchi).
3. `npm run a11y` — axe-core (WCAG 2.1 A/AA) su `/it, /en, /it/events, /it/events/past, /it/about, /it/contact, /it/auth/login, /it/auth/register, /it/privacy, /it/cookie-policy` (`BASE_URL` per cambiare host, esce con 1 se trova violazioni; vedi [accessibility](accessibility.md)).
4. `npm run audit:fo` — audit del front office (`scripts/front-office-audit.cjs`, Playwright): ospite e utente loggato, desktop e telefono. Segnala stato HTTP (le pagine inesistenti devono dare 404), errori JS/console, richieste a siti terzi (la cookie policy promette zero: niente Google Fonts, Gravatar, CDN), chiavi di traduzione non risolte, immagini rotte, `h1` diversi da uno, `title`/meta description mancanti, scroll orizzontale su telefono, violazioni axe. Variabili: `BASE_URL`, `USER_ID`, `ORGANIZER_ID`, `MAP_HOST`. Screenshot e `report.json` in `audit-shots/` (ignorata da git); exit 1 se qualcosa non va.
5. `npm run audit:bo` — audit del back office (`scripts/back-office-audit.cjs`).
6. Verifica nel browser (`/it`) e, se serve il confronto con l'originale, `npm run screenshots` (vedi [visual-parity](visual-parity.md)).

Regressione visiva con screenshot (Playwright `toHaveScreenshot`) e' una scelta consigliata ma non c'e' una cartella `tests/Playwright` nel tema: oggi la verifica visiva e' manuale o via gli script sopra.

## Cosa ha trovato l'audit del front office (e la regola che ne deriva)

| Problema | Regola / correzione |
|---|---|
| Stesso `<title>` e stessa descrizione su ogni pagina | titolo e descrizione per pagina (vedi [seo-structured-data](seo-structured-data.md)) |
| Email dell'organizzatore o del profilo visibili a tutti, anche nel JSON-LD | email e indirizzo solo al titolare; id inesistente = 404 |
| Avatar da Gravatar (richiesta a terzi) | `xra.gravatar = false`, iniziali in locale |
| Pagine password / verifica email in inglese fisso, senza `h1`, SVG inline | `<x-ui.auth-card>` e `<x-ui.auth-field>`, tradotte nelle lingue del tema (vedi [auth-pages](auth-pages.md)) |
| 404/403/419/429 con pagina Laravel di default | pagine errori nel layout del tema (`resources/views/errors/page.blade.php`), 500/503 autonome |
| Logout dal menu mobile con POST alla home | POST a `route('logout')` |
| `/it/login` e `/it/register` davano 404 | alias verso `/it/auth/login` e `/it/auth/register` (`config/local/laravelpizza/seo.php`) |
| `/it/auth/password/confirm` in 500 dopo il sync dei moduli: il modulo User porta pagine Folio con gli stessi nomi Volt del tema | i nomi `@volt()` del tema gia' usati da un modulo hanno il prefisso `meetup.`; guardia `UniqueVoltFragmentNamesTest` |
| URL di contenitori senza modello ne' pagina CMS rispondevano 200 con pagina vuota | ora 404 (`PagesTest`) |

## Vedi anche

- [quality-and-dependencies](quality-and-dependencies.md) — PHPStan e qualita' del codice
- [chaos-monkey-playbook](chaos-monkey-playbook.md) — diagnosi quando qualcosa si rompe a caso
- [troubleshooting](troubleshooting.md)
