---
id: dcp-283
title: "DCP-283: chiusura dei punti aperti di esecuzione dinamica e fail-open (C-03, C-04, C-08)"
type: story
epic: go-live-security
status: done
priority: P0
owner: module:Cms
module: Cms
created: 2026-10-26
updated: 2026-10-26
qmd: "dcp 283 PageSlugMiddleware fail-closed allowlist middleware json ResolvePageAction modelli url profile user newQueryWithoutScopes NotificationTemplate compileString Blade render allowlist C-03 C-04 C-08"
related: [dcp-49, dcp-50, dcp-181, dcp-200, dcp-270]
tags: [sicurezza, go-live, cms, notify, fail-closed, allowlist, tdd, bmad]
---

# DCP-283: chiusura dei punti aperti di esecuzione dinamica e fail-open

## Fase BMAD

Dev (TDD), dopo analisi e decisione. Origine: gap C-03, C-04, C-08 del report `gap-C-cms-lang-seo-tenant`. Per ogni punto
c'e' una riga MISURATO o DEDOTTO. Prima del codice ogni difetto e' riprodotto con un test rosso; i test verdi finali sono nella
sezione Test. Il lavoro e' solo nel working tree (nessun commit).

## Stato

Fatto nel working tree (nessun commit). C-03, C-04 e C-08 sono chiusi e verificati con i comandi riportati nella sezione Esito. Restano due punti DA DECIDERE (sotto, in Esito) e quanto non e' verificabile da qui.

## Fatti misurati prima di toccare

### C-03, `PageSlugMiddleware` fail-open

1. **MISURATO, lettura del codice.** `Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php` aveva tre punti che rendono
   pubblica una pagina: `catch (\Throwable) { $middlewares = []; }` attorno a `Page::getMiddlewareBySlug`; il `catch ... continue`
   in `resolveCmsPageSlug` (uno slug duplicato lancia `RuntimeException`, il candidato viene saltato, la richiesta passa); e due
   `return $next($request)` quando un middleware non restituisce una `Response` o non ha il metodo `handle`.
2. **MISURATO con tinker (sola lettura).** `Page::getMiddlewareBySlug` legge il cast `array` dell'attributo `middleware`. Una
   stringa al posto della lista (`"middleware": "auth"`) viene salvata da Sushi come `auth`, il cast `array` la restituisce `null`
   e la pagina risulta senza middleware. Una lista con voci non stringa (`[{"a":1}]`) perde le voci per `array_filter(is_string)`.
   Sono due modi in cui una pagina che dichiara una protezione diventa pubblica senza errori.
3. **MISURATO, nessuna allowlist.** `executeMiddlewareChain` fa `app($middlewareClass)` su qualunque nome per cui `class_exists`
   sia vero. Un nome come `Illuminate\Http\Middleware\SetCacheHeaders` o una classe di test viene eseguito.
4. **MISURATO sui JSON** (script Python su ogni `**/database/content/pages/**/*.json` sotto `laravel/`, 347 JSON analizzati in
   tutto, 337 con la chiave top-level assente o null): il campo `middleware` assume solo questi valori. `["auth"]` in 15 file
   (`tickets.create`, `area-personale.{impostazioni,notifiche,pratiche,seguite}`, nelle copie `Modules/Fixcity/config` e
   `config/{local,eu}/fixcity`); `["throttle:10,1"]` in 3 file (`tickets.track`); `null` in 7 file (`home`, `tests.eventi`); assente
   nei restanti 312. Nessun JSON usa `web`, `guest`, classi o parametri diversi. Quindi la allowlist di partenza e' `auth` e
   `throttle`.
5. **MISURATO, test esistenti.** Baseline prima di toccare (`pest-scratch-db.sh` su 5 file Cms): 25 falliti, 11 passati. I
   fallimenti sono preesistenti e di infrastruttura (`HasBlocksTest` e `ResolvePageActionTest` senza `uses(...)`: nessuna
   applicazione; `PageBusinessLogicTest`: `bootIfNotBooted ... while it is being booted`). Con `XotBaseTestCase` il modello `Page`
   si avvia e legge `tickets.create` come `["auth"]` (sonda eseguita). I nuovi test usano quindi `XotBaseTestCase` o
   `Cms\Tests\TestCase` con `uses(...)` esplicito.

### C-04, `ResolvePageAction` carica modelli dall'URL

6. **MISURATO, raggiungibilita'** (test in-process su database usa-e-getta, ospite e utente loggato, utente creato con
   factory): `GET /it/profile/<uuid>` risponde 200 e `GET /it/user/<uuid>` risponde 200; `GET /it/profile/99999999` risponde 404.
   Da loggato come un altro utente: 200 per entrambi. Quindi esiste un oracolo di esistenza per chiunque, senza autorizzazione.
   `/it/profile/<email>` risponde 404 (l'email non e' tra le chiavi candidate). `/it/users`, `/tenant`, `/comment`, `/media`,
   `/event`, `/activity`, `/job`, `/rating` rispondono 404 nel database usa-e-getta perche' le tabelle sono vuote (non provato
   che sarebbero 200 con una riga: DEDOTTO dal codice, vedi 7).
7. **DEDOTTO dal codice, insieme raggiungibile.** Con `Modules\<Ucfirst(container0)>\Models\<Ucfirst(rtrim(container0,'s'))>` e
   `App\Models\<...>` le uniche classi esistenti nel repository sono `Activity`, `Comment`, `Event`, `Job`, `Media`, `Rating`,
   `Tenant`, `User` (enumerazione sui file `Modules/*/app/Models`), piu' `App\Models\User`, piu' `Modules\User\Models\User` e
   `Profile` tramite il ramo `profile`. Chiavi provate: `getRouteKeyName()`, `slug`, `id`, `uuid`, `user_id`, `user_name`, prima con
   `newQuery()`, poi con `newQueryWithoutScopes()`, poi con una query grezza sulla tabella (che restituisce anche righe con
   soft delete).
8. **MISURATO, cosa vede un ospite.** Lo snapshot Livewire della pagina contiene
   `"item":[null,{"class":"Modules\\User\\Models\\User","key":"<uuid>","s":"mdl"}]` nella proprieta' pubblica `data` del
   componente Volt del tema (`Themes/Sixteen/resources/views/pages/[container0]/[slug0]/index.blade.php`). Non ci sono attributi
   del modello (l'email cercata non compare ne' nell'HTML ne' nello snapshot), ma compaiono il nome della classe e la chiave.
9. **MISURATO, nessun consumatore del modello generico.** Gli unici blocchi che leggono `item` sono `blocks/blog/detail` e
   `blocks/events/detail` e si aspettano un `Modules\Blog\Models\Article`, che arriva dal ramo `BLOG_PUBLISHED_FINDERS` (solo
   contenuti pubblicati). Nessun JSON di pagina, link di menu o contenuto punta a `/profile/`, `/user/`, `/event/`, `/comment/`,
   `/media/`, `/tenant/`, `/rating/`, `/job/`, `/activity/` (rg sui tre alberi di contenuto). `profile.view` non e' una pagina
   JSON. La chiave `xra.container0_model_map` e' letta dal codice ma non definita in alcun file di configurazione del repository.

### C-08, `NotificationTemplate::compileString`

10. **MISURATO, lettura del codice.** `compileString` fa `Blade::render($template, $data)` su `subject`, `body_html` e
    `body_text` letti dal database. `compile()` e' chiamato da `SendNotificationAction::handle` e da `preview()`; chi puo' scrivere un
    template esegue PHP sul server.
11. **MISURATO, template realmente esistenti.** Il database di sviluppo `fixcity_data` ha 0 righe in `notification_templates` e 0 in
    `mail_templates` (query `SELECT COUNT(*)` in sola lettura). `NotificationTemplateSeeder::run` chiama
    `xotSeedModelOnce(NotificationTemplate::class)`, che cerca la classe `Modules\Notify\Models\NotificationTemplateSeeder`: non
    esiste, quindi non semina nulla. Nessun JSON di contenuto contiene template di notifica. Quindi nel repository e in sviluppo i
    template "seminati" sono zero; i template di produzione non sono visibili da qui (NON VERIFICABILE).
12. **MISURATO, sintassi attesa.** I test e i fixture di Notify scrivono i segnaposto come `{{name}}` (senza `$`), per esempio
    `NotificationTemplateTest::it_can_compile_template_with_data` che si aspetta `Benvenuto Mario Rossi!`. In Blade `{{name}}`
    valuta una costante `name` e fallisce; l'unica sintassi che oggi funziona con `Blade::render` e' `{{ $name }}`. Un
    sostituto sicuro deve accettare entrambe e restituire lo stesso testo escapato.

## Causa

- C-03: il middleware e' nato per essere tollerante (un errore non deve bloccare la pagina) e ha applicato la tolleranza anche
  alla protezione. Il nome della classe arriva da dati editabili (JSON) e viene istanziato senza elenco di nomi ammessi.
- C-04: `ResolvePageAction` e' una scorciatoia di sviluppo ("prova a caricare un modello con il nome del contenitore") rimasta in
  produzione. Il default e' "tutto e' ammesso" invece di "solo cio' che e' elencato".
- C-08: il motore Blade e' stato usato per sostituire i segnaposto, ma e' un motore che esegue PHP.

## Decisioni

1. **C-03 fail-closed.** Qualunque errore nel determinare slug, middleware dichiarati o loro validita' porta a HTTP 503
   (pagina tema `errors/503`), con `Log::error` di slug, nomi dei middleware e classe/messaggio dell'eccezione. Il log non
   contiene indirizzo IP, utente, query string ne' percorso (il percorso puo' contenere identificativi). Il 503 e' scelto perche'
   il guasto e' lato server e transitorio; un 404 nasconderebbe la causa agli operatori.
2. **C-03 allowlist.** Chiave `cms.config.page_middleware_allowlist`, default `['auth', 'throttle']` (i soli nomi nei JSON,
   fatto 4). Confronto sul nome prima dei due punti, come scritto nel JSON. `web` resta un no-op come prima (gruppo gia'
   applicato dallo stack Folio): non e' in allowlist ma e' scartato prima del controllo. Per aggiungere un middleware (anche una
   classe) si modifica la configurazione, non il JSON.
3. **C-03 forma del campo.** `Page::getMiddlewareBySlug` lancia `UnexpectedValueException` se `middleware` e' dichiarato ma non e'
   una lista di stringhe non vuote (stringa, oggetto, voci non stringa). `null` o assente restano "nessun middleware" (pagina
   pubblica, come `home`).
4. **C-03 esecuzione.** Un middleware ammesso che non restituisce una `Response` o non ha `handle` non fa piu' proseguire la
   richiesta: lancia `LogicException` (500, mai servita). L'eccezione nell'esecuzione vera dei middleware (login, throttle) non
   viene catturata: la gestisce Laravel come prima.
5. **C-04 default negato.** `ResolvePageAction` carica un modello solo per `blog` e `events` (ramo gia' esistente, solo contenuti
   pubblicati) e per i contenitori elencati in `cms.config.container0_models` (mappa contenitore => classe, default vuota).
   Resta letta, come alias retrocompatibile, `xra.container0_model_map`. Tolti: ramo `profile`, euristica del singolare,
   `App\Models\...`, `newQueryWithoutScopes`, query grezza sulla tabella, scansione delle chiavi `id/uuid/user_id/user_name`. Per i
   modelli elencati si usa `resolveRouteBinding()` (chiave di rotta e scope del modello) e poi `Gate::allows('view', $item)`: senza
   policy che lo consenta (ospite incluso) il risultato e' lo stesso di "non trovato" (404), quindi nessun oracolo. Un modello con
   dati personali (User) non e' in elenco di default.
6. **C-04 contratto dei blocchi.** Nessun blocco legge `item` per modelli diversi da `Article` (fatto 9): il contratto non cambia e
   il tema non viene toccato. Non si modifica il componente Volt del tema.
7. **C-08 sostituto.** Una Action `RenderNotificationTemplateStringAction` sostituisce solo le espressioni `{{ ... }}` che sono un
   segnaposto: nome (con o senza `$`) o percorso con punti (`{{ $user.name }}`). Il valore e' scalare o `Stringable`, escapato
   con `e()` (HTML), cioe' la stessa semantica di `{{ }}` di Blade. Tutto il resto resta testo: altre espressioni, `{!! !!}`,
   direttive `@php`, `@if`, `@lang`, `@verbatim`, parentesi graffe triple. Le espressioni non ammesse sono registrate con
   `Log::warning` (solo l'espressione, mai i dati). Una variabile mancante produce stringa vuota e un warning con il nome.
   Costrutti `route(...)`, `@lang`, `localizeURL` NON sono implementati: non servono a nessun template misurato (fatto 11).
   **DA DECIDERE (titolare/Notify):** quali costrutti in piu' servono ai template di produzione, visto che da qui non si vedono.
   Proposta: dopo il deploy leggere il log `Espressione non ammessa in un template di notifica` e aggiungere solo quelli visti,
   ognuno con un test, come fatto per `HasBlocks` (DCP-181).

## Criteri di accettazione

1. `PageSlugMiddleware`: un'eccezione nella ricerca della pagina, nella lettura dei middleware o nella loro validazione produce
   503 e `$next` non viene chiamato. Verificabile con i test `PageSlugMiddlewareFailClosedTest`.
2. Un middleware non in allowlist (classe di test con effetto osservabile) non viene mai istanziato ne' eseguito, e la risposta
   e' 503.
3. Ogni valore di `middleware` presente in OGNI JSON di pagina del repository supera la validazione della allowlist (test che
   percorre tutti i JSON, con controllo che ne trovi almeno uno per `auth` e uno per `throttle`).
4. `auth` e `throttle:10,1` continuano a funzionare come prima (la catena viene eseguita; `auth` da ospite lancia
   `AuthenticationException`; `throttle:10,1` risponde 200 con le intestazioni di limite).
5. `Page::getMiddlewareBySlug` lancia per stringa e per voci non stringa; restituisce `[]` per assente e `null`.
6. `GET /it/profile/<uuid esistente>` e `GET /it/user/<uuid esistente>` rispondono 404 come per un id inesistente, per ospite e
   per utente loggato. `blog` e `events` restano invariati (test Blog esistenti).
7. Un contenitore elencato in `cms.config.container0_models` carica il modello solo se `Gate::allows('view')` e senza
   `newQueryWithoutScopes` (un record escluso dallo scope globale non e' raggiungibile).
8. `NotificationTemplate::compile` rende lo stesso testo di prima per `{{ $name }}` e (nuovo, atteso dai test) `{{name}}`;
   `{{ system('id') }}`, `@php ... @endphp`, `{!! $x !!}` e `{{{ ... }}}` non eseguono nulla e restano testo.
9. PHPStan livello massimo a zero sui file nuovi o modificati; Pint sui soli file toccati.

## Test

Cartella `Modules/Cms/tests` e `Modules/Notify/tests`, Pest, eseguiti con `bashscripts/tools/pest-scratch-db.sh`.

- `Modules/Cms/tests/Unit/Http/Middleware/PageSlugMiddlewareFailClosedTest.php` (criteri 1, 2, 4).
- `Modules/Cms/tests/Unit/Actions/ValidatePageMiddlewareActionTest.php` (criteri 2, 3, validazione di forma).
- `Modules/Cms/tests/Unit/Content/PageJsonMiddlewareAllowlistTest.php` (criterio 3 sui JSON reali).
- `Modules/Cms/tests/Unit/Models/PageMiddlewareFieldTest.php` (criterio 5).
- `Modules/Cms/tests/Feature/ResolvePageModelExposureTest.php` (criteri 6 e 7, richieste HTTP in-process; piu' un test che
  blog ed events restano serviti dal finder dei soli contenuti pubblicati, con un `ThemeComposer` finto, perche' i test Blog
  esistenti non girano nel database usa-e-getta, vedi Esito).
- `Modules/Notify/tests/Unit/Actions/RenderNotificationTemplateStringActionTest.php` (criterio 8).

## Owned file scope

File esistenti modificati (ognuno con lock `DCP-283 w2a`):
- `laravel/Modules/Cms/app/Http/Middleware/PageSlugMiddleware.php`
- `laravel/Modules/Cms/app/Models/Page.php`
- `laravel/Modules/Cms/app/Actions/ResolvePageAction.php`
- `laravel/Modules/Cms/config/config.php`
- `laravel/Modules/Notify/app/Models/NotificationTemplate.php`
- `laravel/Modules/Cms/docs/bmad/decision-log.md`
- `laravel/Modules/Cms/docs/wiki/concepts/cms-page-middleware-json-ssot.md`

File nuovi:
- `laravel/Modules/Cms/app/Actions/ValidatePageMiddlewareAction.php`
- `laravel/Modules/Notify/app/Actions/RenderNotificationTemplateStringAction.php`
- i sei file di test elencati sopra
- questa story

Non toccati: `Modules/Comment/**`, `Modules/Seo/**`, `FixcityServiceProvider`, blocchi Sixteen blog e events, `laravel/routes/web.php`,
`Themes/Sixteen/**`.

## Esito

Data: 2026-10-26. Agente w2a. Tutti i comandi dalla radice del repo o da `laravel/`, solo working tree.

### Rosso prima del codice (TDD)

- Tutti i test nuovi scritti prima del codice. Esecuzione su codice originale: `Tests: 81 failed, 8 passed (310 assertions)`.
  Molti rossi erano "classe inesistente" (le due Action nuove non c'erano ancora); i tre difetti reali sono stati riprodotti cosi:
  - C-03: middleware con lettura che lancia -> risposta 200 e `$next` chiamato (atteso 503); classe di prova in `middleware`
    istanziata ed eseguita (`$calls` = 1, atteso 0).
  - C-04: `GET /it/profile/<uuid>` e `/it/user/<uuid>` rispondevano 200 (atteso 404), per ospite e per utente loggato.
  - C-08: `compileString('{{ dcp283NotifyMarker() }}')` eseguiva la funzione (`Failed asserting that true is false`).
- Prova inversa su C-04: rimessa temporaneamente la vecchia `ResolvePageAction`, i test del punto danno
  `Tests: 6 failed, 4 passed (12 assertions)`; ripristinata la nuova versione (file identico al backup, verificato).

### Verde dopo il codice

`PEST_OUT=... bash bashscripts/tools/pest-scratch-db.sh` sui sei file di test nuovi:

```
Tests:    78 passed (432 assertions)
Duration: 25.79s
scratch eliminati: 0 rimasti
```

PHPStan (`./vendor/bin/phpstan analyse <i 13 file toccati> --memory-limit=4G --no-progress`, config unica, nessun ignore,
nessuna baseline, nessun `assert()`):

```
[OK] No errors
```

Pint: `vendor/bin/pint --test` sui soli 8 file nuovi: `passed`. Sui 5 file PHP esistenti modificati non e' stato lanciato Pint
(la configurazione del repo riformatterebbe tutto il file, vedi Page.php): ne e' stata controllata solo la regione modificata.

### Regressioni

Eseguiti (stesso runner) i test esistenti che toccano le stesse classi: `PageSlugMiddlewareTest` (due cartelle),
`ResolvePageActionTest`, `PageBusinessLogicTest`, `HasBlocksTest`, `BlogFrontOfficeEventsTest`, `BlogFrontOfficeNovitaTest`,
`PersonalAreaPagesJsonGuardTest`, `TicketCreatePageMiddlewareGuardTest`, `TicketTrackPageJsonGuardTest`, `NotifyModelsCoverageTest`,
`NotifyHighestMissCoverageTest`, `TemplateManagementBusinessLogicTest`, `NotificationTemplateVersionBusinessLogicTest`:
`Tests: 61 failed, 1 risky, 3 skipped, 28 passed`.

- I tre test JSON di Fixcity (`PersonalAreaPagesJsonGuardTest`, `TicketCreatePageMiddlewareGuardTest`,
  `TicketTrackPageJsonGuardTest`) passano.
- Per i quattro file Cms il confronto con la baseline presa prima di toccare e' identico per file
  (`HasBlocksTest` 1 ok / 15 ko, `PageBusinessLogicTest` 1/4, `PageSlugMiddlewareTest` 9/2, `ResolvePageActionTest` 0/4). I ko
  sono di infrastruttura e non miei: test senza `uses(...)` (nessuna applicazione: `facade root`, `Target class [config]`),
  avvio ricorsivo del modello `Page` (`bootIfNotBooted ... while it is being booted`), `$this->skipTest()` inesistente.
  Nota: i due test `resolveCmsPageSlug ...` del `PageSlugMiddlewareTest` fallivano gia' prima (il `Page` non si avvia senza
  applicazione); ora falliscono con l'eccezione vera invece che con un `null`, perche' `resolveCmsPageSlug` non inghiotte piu' gli errori.
- I test Blog (10) e Notify (esistenti) falliscono per cause che non passano dal codice modificato: `DemoContentSeeder` del Blog
  (`Duplicate entry '' for key 'PRIMARY'`, prima di arrivare a `ResolvePageAction`), contenitore senza applicazione e Faker senza
  `words` in Notify, `NotificationTemplateTest` con `@test` non riconosciuto da Pest ("No tests found"). NON c'e' una baseline
  di queste suite presa prima di toccare: la lettura "non miei" e' DEDOTTA dal punto in cui falliscono, non MISURATA.
  Per compensare, il ramo `blog`/`events` di `ResolvePageAction` (codice non modificato, righe identiche nel diff) ha un test
  proprio nel file nuovo; i `compile`/`preview` del modello hanno test propri nel file Notify nuovo.

### Fatti misurati dopo il codice

- Pagine reali del tenant (tinker, sola lettura): 111 pagine, 0 slug duplicati, 0 pagine con campo `middleware` illeggibile.
  Quindi il 503 per slug duplicato o campo illeggibile non cambia nessuna pagina esistente.
- JSON di pagina percorsi dal test `PageJsonMiddlewareAllowlistTest`: 225 file (tenant, copie nel modulo Fixcity, configurazioni
  di moduli e temi); ogni `middleware` dichiarato passa la allowlist.
- Nessun commit, nessuna migrazione, nessuna dipendenza nuova, nessun file del tema toccato.

### Stato per punto

- **C-03: FATTO e VERIFICATO.** `PageSlugMiddleware` fail-closed (503 con log senza dati personali), allowlist `auth`/`throttle` in
  `cms.config.page_middleware_allowlist`, campo `middleware` validato nella forma, middleware senza `Response` o senza `handle`
  non fanno piu' passare la richiesta. Comportamento delle pagine esistenti invariato (`["auth"]`, `["throttle:10,1"]`, `null`).
- **C-04: FATTO e VERIFICATO.** `/it/profile/<uuid>` e `/it/user/<uuid>` danno 404 come un id inesistente, per ospite e per
  loggato, e lo snapshot non porta piu' classe e chiave. Allowlist `cms.config.container0_models` (vuota di default) con
  `resolveRouteBinding` e policy `view`. Il rischio di regressione e' stato misurato prima (fatto 9: nessun consumatore) e
  `blog`/`events` hanno un test di non regressione.
- **C-08: FATTO e VERIFICATO sui template misurati; DA DECIDERE per quelli di produzione.** `compileString` non esegue piu' PHP.
  I template "seminati" sono zero (fatto 11), quindi la parita' e' provata con la sintassi dei test e dei fixture (`{{ $name }}`,
  `{{name}}`, percorsi con punti), confrontata con `Blade::render` dove Blade funziona.

### DA DECIDERE e non verificabile da qui

1. **Costrutti dei template di produzione (titolare/Notify).** Se i template reali usano `route()`, `@lang`, `localizeURL`,
   `@if` o espressioni, ora restano testo (con `Log::warning`) invece di essere eseguiti. Proposta: dopo il deploy leggere il
   warning `Espressione non ammessa in un template di notifica` e aggiungere solo i costrutti visti, ognuno con un test.
   Alternativa piu' prudente prima del deploy: esportare i template di produzione e passarli al renderer nuovo e a Blade, e
   confrontare l'output.
2. **Proprieta' pubbliche Livewire `pageSlug` e `data` del componente Volt del tema** (modificabili dal client, `#[Locked]`
   assente): non misurato se un client puo' forzare un `item` diverso. Con l'allowlist il server non carica piu' modelli
   arbitrari, ma il componente e' nel tema e non e' stato toccato (vincolo). Proposta: story separata sul tema con `#[Locked]`.
3. **Altri contenitori** (`/event`, `/comment`, `/media`, `/tenant`, `/rating`, `/job`, `/activity`): la raggiungibilita' prima del
   fix e' DEDOTTA dal codice (tabelle vuote nel database usa-e-getta), non misurata con una riga reale. Dopo il fix non sono
   raggiungibili per costruzione (allowlist vuota).
4. Il percorso "slug duplicato" e' provato con la cucitura `findPageBySlug` (test) e non con due JSON reali duplicati, perche' nel
   tenant reale non ce ne sono.
5. Il binding `uses(Tests\TestCase::class)` nel test Feature e' dichiarato nel file perche' `Modules/Cms/tests/Pest.php` non e'
   caricato da `pest-scratch-db.sh`; la `TestCase` del modulo Cms darebbe l'errore PHPStan `pest.config.redundantLocalUse`.
