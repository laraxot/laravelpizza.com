---
title: "[STORY] Sync del 2026-11-19: merge a storie non correlate committato nel root, riparazione e prevenzione"
type: story
module: Xot
bmad: true
status: in-progress
priority: critical
created: 2026-11-19
updated: 2026-11-19
tags: [sync, merge, marker-conflitto, regressioni, phpstan, pest, forward-only]
qmd: "sync merge_remote_repo_2 allow-unrelated-histories marker regressioni file resuscitati blob antenato comune phpstan pest binding"
related:
  - ./module-sync-stale-snapshot-and-phpstan-zero.story.md
  - ../../../../../bashscripts/docs/sync-repair-tools.md
  - ../../../../../docs/wiki/rules/merge-conflict-marker-resolution.md
---

# Sync del 2026-11-19: riparazione e prevenzione

Seconda volta in tre giorni (la prima: [story del 2026-11-17](./module-sync-stale-snapshot-and-phpstan-zero.story.md)).

## Cosa è successo

Alle 11:46–11:57 è stato eseguito `bashscripts/git/subtrees/merge_remote_repo_2.sh`, marcato
"DEPRECATO — NON eseguire" dal 2026-09-15 ma senza nulla che lo impedisse. In ogni pacchetto ha
fatto `git init` (branch `master`), `commit -am .` e `merge laraxot/dev --allow-unrelated-histories`,
e ha pushato al remoto. Il commit del root `4a268e3c78 "."` ha poi preso tutto:

| Danno | Quanti | Effetto |
|---|---|---|
| file con marker | 2.424 in 19 pacchetti (~6.650 blocchi) | PHPStan non partiva (`unexpected token "<<"`) |
| file tornati a versioni di set/ott | 633 | es. `Rating/app/Datas/RatingData.php` senza `formFieldLabel()` |
| file che il root aveva cancellato | 438 | `app/Services/*`, `lang/*/.php`, report `ULTIMATE_*`, nomi con date |
| dipendenze perse | `neuron-core/neuron-ai`, `laravel/mcp` in AI | 44 `class.notFound` |

Il remoto stesso era già regredito: i mirror di massa del 17/11 ("Marco Xot .") lo avevano
riportato a blob vecchi, e alle 12:00–12:02 la stessa sync ha pushato i marker anche lì.

## Riparazione (commit `efeec2ebd3`, `137b8fbf25`)

Metodo e strumenti: [sync-repair-tools](../../../../../bashscripts/docs/sync-repair-tools.md).
- marker: fast-forward / merge a 3 vie sul blob antenato comune per ~2.300 file; casi meccanici;
  107 `.md` e 3 test fusi a mano per significato (4 subagenti, numeri verificati sul codice);
- regressioni ripristinate alla versione pre-sync, file resuscitati tolti di nuovo;
- `Comment/tests/Support/CanCommentStub.php`: doppione incompleto di
  `Tests/Fixtures/Concerns/InteractsWithCommentsContractStub`, faceva morire PHPStan
  (`Model::getKey()` senza tipo contro `CanComment::getKey(): mixed`), tolto;
- dipendenze AI e Notify allineate (lock + vendor);
- Pest: il binding `uses()->in()` nei `Pest.php` di Cms, Tenant e Rating non gira col runner di
  root (che legge solo `laravel/tests/Pest.php`) e con `--test-directory` raddoppia il binding
  (`TestCaseAlreadyInUse`). Tolto; 53 file che usavano il TestCase senza legarlo ora lo legano:
  110 test che non partivano passano. Restano 74 fallimenti di debito già noto (tabella
  `tenants` assente nei DB `_test`, route Folio, componenti Livewire `auth.*`);
- 8 copie in minuscolo dei test di `Cms/tests/Feature/Auth` tolte (PSR-4); per `LoginVolt` e
  `PasswordConfirmation` il contenuto vero ha sostituito i segnaposto `skip`.

## Seconda passata: lavoro esistito solo sul remoto

La punta di `laraxot/dev` non era una verità affidabile: i commit "." delle 11:50–12:04 sul remoto
hanno "risolto" i loro conflitti cancellando un lato intero (es. `module_ai_fila5` `3a87af7`: ~3.100
righe, il fornitore `local`, i binding degli agenti, le dipendenze). Il confronto giusto è con
l'**ultimo commit remoto prima della sync** (`find_remote_only_losses.py`, `--before`).
Su ~1.400 file diversi, quasi tutti erano blob dei mirror "." del 17/11; filtrando i commit con un
messaggio vero restano **50 file di lavoro reale**: 44 ripristinati (il contenuto attuale era un
loro antenato), 1 fuso a 3 vie, 5 di AI fusi a mano dall'agente insieme alle sue correzioni.
- AI: PHPStan 28 → 0; trovati e corretti due bug runtime che bloccavano ogni run degli agenti
  (binding `MessageStoreInterface`/`PersistenceInterface` persi; `EloquentPersistence` di neuron
  esige `STRICT_TRANS_TABLES`, la connessione `mysql` del tenant è `strict => false`:
  `StrictModeEloquentPersistence`).
- Rating: PHPStan 71 → 0 (dettaglio nella story del modulo `2.3.phpstan-rating-tail-contracts`).
- Gdpr/Lang: recuperati i test di registrazione agnostici e `info_banner`; 32 test Gdpr falliscono
  perché `Gdpr/lang/en/register.php` contiene i testi di un altro progetto ("Start Your Pizza
  Journey"), presenti in tutte le versioni: debito di neutralità del modulo, non una regressione.

## Mirror del 2026-11-17: differenze di significato

Il commit del root `8a8f309737` ("chore: mirror al root di moduli e temi dopo il pull") ha riscritto
13.250 file col contenuto dei repo dei pacchetti. Formattati entrambi i lati con Pint, restano **42
file** in cui la versione prima del mirror (`8a8f309737~1`) e quella attuale dicono cose diverse.
Nessuno dei 42 è stato toccato dopo il mirror, e la storia dei pacchetti è schiacciata in un solo
commit "." del 19/11: la decisione si prende sul contenuto (codice, chiavi di traduzione presenti,
test, ADR), mai scegliendo un lato per default.

Schema emerso:
- **Blade di Sixteen, mappa di UI**: prima del mirror le stringhe erano già chiavi `pub_theme::` /
  `ui::` (presenti in it/en/de/es); il mirror ha rimesso il testo italiano/inglese scritto a mano.
  Lavoro perso → ripristinato.
- **PHP di Sixteen (`app/`, `routes/auth.php`)**: la versione prima del mirror **non compilava**
  (righe vecchie e nuove incollate sulla stessa riga, `use` doppi: `php -l` fallisce su tutti e 11).
  Quella attuale è il lato nuovo pulito di quella fusione (enum al posto delle costanti, tipi,
  scope tipizzati) → si tiene.

| File | Verdetto | Prova |
|---|---|---|
| `Modules/Activity/lang/it/activities.php` | attuale | tolto `'tooltip' => 'delete'`, segnaposto non tradotto |
| `Modules/Activity/tests/Feature/ActivityManagementTest.php` | attuale | `uses(TestCase::class)` con import; il `beforeEach` che saltava i test senza DB nascondeva i fallimenti |
| `Modules/Gdpr/app/Providers/GdprServiceProvider.php` | attuale | evoluzione DCP-153/445: `InjectCookieBanner` (esiste dal 14/10), vista e traduzioni `cookie-consent` del modulo; guardia `Gdpr/tests/Unit/Providers/CookieConsentWiringTest.php` |
| `Modules/Geo/resources/views/maps/farmshops/index.blade.php` | **ripristinato** | il mirror aveva aggiunto `maximum-scale=1.0, user-scalable=no`: blocca lo zoom, viola WCAG 1.4.4 |
| `Modules/Notify/lang/it/channel.php` | attuale | prima del mirror c'erano in più solo `fields.mail/sms/whatsapp` con valori segnaposto ("mail"); l'attuale ha le stesse chiavi di en/de |
| `Modules/UI/lang/it/.php` | prima (solo forma) | stesso contenuto; l'attuale era un `var_export` (`array (`), riportato alla sintassi corta di Pint |
| `Modules/UI/resources/views/livewire/components/map/interactive-map.blade.php` | **ripristinato** | 26 chiavi `ui::interactive_map.*` presenti in it/en/de/es, il mirror le aveva sostituite con testo italiano fisso |
| `Modules/UI/resources/views/metatags.blade.php` | **corretto** | il mirror aveva `<meta nome="googlebot">` (attributo inesistente): torna `name=` |
| `Modules/UI/tests/Feature/TimestampColumnTest.php` | **ripristinato + `group('no-ui-db')`** | il mirror aveva tolto `uses(TestCase::class)` (ADR `pest-testcase-binding-per-file`); il test non usa lo schema `ui`, senza il gruppo il TestCase di UI lo saltava |
| `Modules/UI/tests/Fixtures/UiPhpstanTraitProbes.php` | attuale | namespace `Modules\UI\Tests\Fixtures` = PSR-4 di `UI/composer.json`; `Tests\Modules\UI\...` era sbagliato |
| `Modules/User/lang/de/validation.php` | attuale | `uploaded` col messaggio "il file potrebbe essere troppo grande", lo stesso scelto in `Xot/lang/*/validation.php`; aggiunta la chiave `file` |
| `Modules/User/lang/es/validation.php` | attuale | come sopra |
| `Themes/Sixteen/app/Http/Livewire/Appointment/CreateAppointment.php` | attuale | prima: parse error riga 78 (fusione incollata); l'attuale è il lato tipizzato |
| `Themes/Sixteen/app/Models/Appointment.php` | attuale | prima: parse error riga 142; costanti `STATUS_*`/`SERVICE_*` sostituite da `AppointmentStatusEnum`/`AppointmentServiceTypeEnum` (nessun uso residuo) |
| `Themes/Sixteen/app/Models/Municipal/ContactPoint.php` | attuale | prima: parse error; `TYPES` → `ContactPointTypeEnum` |
| `Themes/Sixteen/app/Models/Municipal/MunicipalEvent.php` | attuale | prima: parse error; costanti → enum `MunicipalEvent*Enum` |
| `Themes/Sixteen/app/Models/Municipal/MunicipalLocation.php` | attuale | prima: parse error; costanti → enum `MunicipalLocation*Enum` |
| `Themes/Sixteen/app/Models/Municipal/MunicipalNews.php` | attuale | prima: parse error; costanti → enum `MunicipalNews*Enum` |
| `Themes/Sixteen/app/Models/Municipal/MunicipalService.php` | attuale | prima: parse error; relazioni con `static::class` e closure tipizzate |
| `Themes/Sixteen/app/Models/Municipal/OrganizationalUnit.php` | attuale | prima: parse error; `TYPES` → `OrganizationalUnitTypeEnum` |
| `Themes/Sixteen/app/Models/Municipal/PublicPerson.php` | attuale | prima: parse error; `CATEGORIES`/`ROLES` → `PublicPersonCategoryEnum`/`PublicPersonRoleEnum` |
| `Themes/Sixteen/app/View/Composers/SixteenComposer.php` | attuale | prima: `use MenuBuilderAction` doppio (fatal); l'attuale aggiunge i controlli `is_array` sulla config del menu |
| `Themes/Sixteen/routes/auth.php` | attuale | prima: quattro `use` duplicati (fatal) |
| `Themes/Sixteen/resources/views/components/accessibility/contrast-toggle.blade.php` | **ripristinato** | chiavi `agid_components.contrast_toggle.*` |
| `.../components/accessibility/font-size.blade.php` | **ripristinato** | chiavi `agid_components.font_size.*`; l'attuale aveva due righe spazzatura `f7ac8eda (.)` stampate nella pagina |
| `.../components/blocks/appointment-step/partials/breadcrumb.blade.php` | **ripristinato** | `aria-label` tradotto invece di "breadcrumb" |
| `.../components/blocks/geo/mappa-static.blade.php` | **ripristinato** | chiavi `blocks_content.mappa_static.*` |
| `.../components/blocks/governance/cards.blade.php` | **ripristinato** | `alt` "random image" e titoli fissi → chiavi |
| `.../components/blocks/rating/default.blade.php` | **ripristinato** | `aria-label` "Rating" e "N stelle" → `components_reports.rating.*` con `trans_choice` |
| `.../components/bootstrap-italia/button.blade.php` | **ripristinato** | "Caricamento..." → chiave |
| `.../components/confirms-password.blade.php` | **ripristinato** | chiavi `pub_theme::` invece delle stringhe inglesi di Jetstream |
| `.../components/data-display/avatar.blade.php` | **ripristinato** | chiavi `components_common.*` |
| `.../components/data-display/callout.blade.php` | **ripristinato** | chiavi |
| `.../components/data-display/list-group.blade.php` | **ripristinato** | l'attuale aveva `icon="heroicon-o-{{" $item['icon'] }}`: virgolette spostate, icona rotta |
| `.../components/data-display/modal.blade.php` | **ripristinato** | `aria-label="Close"` → chiave |
| `.../components/forms/upload.blade.php` | **ripristinato** | 9 testi → `components_forms.upload.*` |
| `.../components/layouts/navigation.blade.php` | **ripristinato** | chiavi del tema invece di `__('Dashboard')` ecc. |
| `.../components/ui/cookiebar.blade.php` | **ripristinato** | chiavi |
| `.../components/ui/hero.blade.php` | **ripristinato** | chiavi (l'attuale mescolava italiano e inglese) |
| `.../components/ui/notifiche.blade.php` | **ripristinato** | chiave |
| `.../components/ui/services-grid.blade.php` | **ripristinato** | chiavi |
| `.../components/validation-errors.blade.php` | **ripristinato** | chiave invece di "Whoops! Something went wrong." |

Le 66 chiavi `pub_theme::` e le 26 `ui::` rimesse esistono in tutte e quattro le lingue (controllo
con script sulle `lang/{it,en,de,es}`). Ripristino fatto applicando al file attuale l'inverso del
diff senza spazi (`patch -R -l`), così resta la formattazione corrente dove non c'è differenza di
significato.

Verifica: PHPStan `Modules/UI Modules/Geo` 0 errori; Pint pulito; ogni Blade toccata compila
(`Blade::compileString` + `php -l`); `php -l` sugli 11 PHP di Sixteen tenuti; Pest con
`pest-scratch-db.sh` su `TimestampColumnTest`, `BladeTemplatesCompileTest`,
`BootstrapItaliaComponentsTest`, `HeaderAreaPersonaleLinksContractTest`: verdi; checksum di
`laravel/config` e `Modules/*/lang` invariati prima/dopo.

Da fare: le stesse correzioni vanno nei repo `module_ui_fila5`, `module_geo_fila5`,
`theme_sixteen_fila5`, altrimenti il prossimo mirror le annulla di nuovo.

## Prevenzione

- `merge_remote_repo_2.sh` usciva con errore senza `ALLOW_DEPRECATED_MERGE=1` (bashscripts
  `6e7813a27`); la guardia è stata tolta alle 12:27 dal commit "." `718a8ae47`. **Decisione
  dell'utente**: rimetterla o sapere perché serve eseguirlo.
- La sync automatica committa il working tree ogni minuto ("." `2f184dec3d`): una modifica a metà
  finisce nella storia.

## Ambiente, trovato durante il lavoro

- Dopo le 12:11 una sessione esterna ha fatto `chown -R www-data` sull'intero repo (git: "dubious
  ownership", `composer.lock` non scrivibile). Ripristinato `marco:www-data` con scrittura di gruppo.
- `public_html/assets/<modulo>` erano cartelle copiate, non symlink: 11 copie identiche sostituite
  dal link. Poi anche `fixcity` (un `images/logo.svg` non referenziato da nessuna parte), `geo` (bundle
  Vite vecchi che il manifest del modulo non usa) e `ui` (screenshot più vecchi di quelli del modulo):
  ora tutti e 14 sono symlink. Tolta `XotAssetTest/`, cartella vuota lasciata da una versione vecchia di
  `AssetActionsTest`. `public_html/assets/.gitignore` ha la voce di ogni modulo con `public/`
  (la guardia `ModulePublicAssetsLinksTest` falliva per 11 moduli).

## Aperto

- [ ] Portare le correzioni nei repo dei pacchetti: i loro `laraxot/dev` contengono marker e
      regressioni, e il prossimo mirror li riporterebbe nel root. I repo annidati sono ancora in
      un merge non concluso su `master`.
- [ ] Debito di nomi per maiuscole, già presente prima della sync: `database/Factories` e
      `factories`, `Migrations`/`migrations`, `Seeders`/`seeders` (Cms, Comment, Tenant),
      `Xot/lang/pt_BR` e `pt_br`, `Notify/.github/ISSUE_CONTENT` e `issue_content`,
      `Notify/config/Config`, `Job/tests/feature`, `Lang/tests/unit`, `Geo/docs/*`. Le migrazioni
      doppie vanno guardate una per una prima di togliere qualcosa.
- [x] PHPStan: `analyse Modules` a zero (commit `6debfe0f72`).
- [x] Binding Pest: ADR `Xot/docs/adr/pest-testcase-binding-per-file.md` + guardia (commit `2d57064ac1`).

## Terza occorrenza: 2026-11-24, PHPStan non boota

Il rischio scritto in "Aperto" si è avverato: i repo dei pacchetti avevano ancora i marker nel loro
`laraxot/dev` e un nuovo merge li ha riportati nel root. Ordine dell'utente: `analyse Modules` e
correggere tutto. Il run non dà un conteggio, si ferma al boot con `Application bootstrap failed ...
unexpected token "<<"` dopo 2 secondi (JSON vuoto). L'extension-installer è a posto, il guasto è
nel codice. Il 21/11 `analyse Modules` era a zero: il traguardo è tornarci.

**Misure (sola lettura).** Root `HEAD~4` (`13f95412dc`, 15:10 UTC) senza marker nei `.php`; `HEAD~3`
(`50aa4ee7f8`, 15:14, messaggio ".") con 343 `.php` marcati. Perciò **`SYNC_BASE=13f95412dc`**, non
`HEAD~1`: `HEAD~1` ha già i marker (tre commit "." di fila) e gli strumenti confronterebbero marker
con marker. Dry-run di `classify_conflict_hunks.py` su `Modules`: 4.100 file con marker, 4.310 hunk
divergenti, 284 file con marker annidati o rotti. Codice e config: 340 file (php 338, json 2), circa
140 con giudizio; `.md` di docs: 3.741 (Notify 2.908, User 294, Geo 129, Cms 95). Nei repo dei moduli
il marker sta nel `HEAD` di Cms, Geo, Lang, Notify, UI, User, Xot; Activity e Media non hanno commit
locali e hanno i marker solo nel working tree. `resolve_by_common_blob.py` dà `no-common-base` quasi
ovunque: sono divergenze vere, non fast-forward. 349 file hanno marker ma solo 312 falliscono
`php -l` (in `ActivityServiceProvider.php` stavano in un docblock): il lint verde non basta.
Mancano i `pre-commit` col guard (`bashscripts/git/guard-conflict-markers.sh` esiste) in root e Notify.

**Metodo, forward-only.** (1) Hunk meccanici (identici, lato vuoto, sottoinsieme): union con
`classify_conflict_hunks.py <dir> --apply`, nessuna riga persa. (2) Divergenti: leggere i due lati,
i chiamanti e la storia; "ours" = `git show 13f95412dc:laravel/<path>`. Se il testo del lato
`laraxot/dev` compare nella storia del root prima di `13f95412dc` è una copia vecchia (mirror ".") e
vale il lato del root; se non c'è mai stato è contenuto nuovo, da valutare nel merito (unione di
aggiunte indipendenti, mai due versioni della stessa funzione). (3) Scrittura con `Edit` sul blocco
esatto: se un altro agente l'ha già cambiato l'edit fallisce e il file si salta; `stat -c %Y` prima,
sotto 120 s il file è caldo. (4) `php -l` su ogni file toccato; niente PHPStan finché restano marker
nei file di boot.

**Criteri.** Zero marker nei file di codice e config di `Modules` e `Themes` (con controprova
positiva); `php -l` pulito; PHPStan boota; baseline `analyse Modules` valida (exit e `totals`), poi
fix per famiglia. I 3.741 `.md` sono una seconda fase e non bloccano il boot. Prevenzione
(`pre-commit` col guard nei repo dei moduli, rimessa della guardia su `merge_remote_repo_2.sh`):
decisione dell'utente, perché la sync smette di committare invece di committare marker.

### Coordinamento (24/11)

| Agente | Scope | Nota |
|--------|-------|------|
| codex (PID 1919367, osservato, nessun claim scritto) | `Modules/Activity`, scritture recenti in Lang, Media, UI, Cms `routes/` | in corso: marker di codice Activity da 20 a 6 e UI da 16 a 8 in pochi minuti. Non toccare. |
| claude-coordinatore | misure, story, baseline PHPStan a marker azzerati | in corso |
| lane-xot | `Modules/Xot` codice e config con marker | in corso |
| lane-user | `Modules/User` codice e config con marker | in corso |
| lane-cms-geo-notify | `Modules/Cms`, `Modules/Geo`, `Modules/Notify` codice e config con marker | in corso |
| claude (secondo coordinatore, 24/11 15:45 UTC) | nessuno scope di scrittura | arrivato sullo stesso ordine: baseline delle 15:45 = 578 `phpstan.parse` in 86 file, zero errori di tipo; 24 di quei file erano gia' riparati alle 15:49. Non scrive sui marker e non rilancia la baseline (e' del claude-coordinatore): riprende solo a marker azzerati, se il coordinatore non l'ha gia' fatto. |
| claude (secondo coordinatore, 24/11 16:15 UTC) | `Modules/Cms/resources/views/components/{head,foot}.blade.php`, `tests/fixtures/slug-probe.blade.php`; `docs/adr` di tutti i moduli (issue #252) | fatto per le 3 viste Cms (ferme da 53 min, non PHP, fuori da PHPStan): `head` stampava `<<<<<<< HEAD` dentro `<head>` e non aveva `@stack('styles')`; risolte per unione (`@see` tenuto, `@stack` dal lato `dev`; la fixture era gia' il sovrainsieme nel lato `HEAD`), Blade compilato e `php -l` ok. `docs/adr`: 4 lane in corso, solo `docs/adr`, nessun codice. Restano a te i marker PHP: `Gdpr/app/Models/Traits/HasGdpr.php` ha marker `.merge_file_*` vivi (57 s) e non e' stato toccato (e il suo e' un marker dentro un docblock: `php -l` passa, non e' `phpstan.parse`). **Baseline bloccata alle 16:08:** `analyse Modules` con `APP_ENV=testing` esce in 3 s con `Application bootstrap failed` / `.env.testing mancante` (guardia di `App\Application::environmentFile()`, nessun fallback su `.env` per scelta); ieri 21:22 lo stesso comando dava 0 errori, quindi il file c'era. Nessuna misura PHPStan e nessun Pest finche' l'owner delle credenziali non lo rimette: non ricrearlo e non cambiare `APP_ENV`. Parse errors di codice residui: 0. |
| claude (secondo coordinatore, 24/11 16:20 UTC) | nessuno (solo misura) | **Quarta occorrenza, ripresa mentre si ripulisce.** Alle 16:07 i file di codice con marker erano 1 (docblock di Gdpr); alle 16:14 sono 28, di cui 26 in `Modules/Lang` (`routes/web.php`, `routes/api.php`, vista del language switcher, test) e 1 in `Activity/app/Providers/ActivityServiceProvider.php`, tutti di meno di 11 minuti. Nel repo di Lang il marker e' **nel `HEAD`**: `routes/web.php` ha 0 marker in `HEAD~1` (9 min fa) e 2 in `bed006b2`/`4b1524db` ("first" e "." di 2-3 min fa). Quindi `merge_remote_repo_2.sh` ha fatto il merge con `laraxot/dev`, lasciato i marker e committato/pushato. Stessa sorte per i README `docs/adr` e `docs/contracts` di Lang appena riscritti dalle lane. Finche' la sync gira senza guardia, ogni fix locale viene ripristinato e il marker torna su `laraxot/dev` (da cui tirano ptvx, trade, restaurant, fixcity). Non e' una decisione mia ne' dei peer: restano la guardia `pre-commit` nei repo dei moduli (`bashscripts/git/guard-conflict-markers.sh`) o la sospensione della sync su Lang, **da decidere dall'utente**. Nessuno ha toccato lo script. |
| claude (terzo coordinatore, 24/11 16:30 UTC, sessione `analyse Modules`) | lane Lang, User, Geo, Notify+Media+UI: file PHP/js/blade/json con marker. Ora solo `Modules/Geo`: tipi PHPStan nei trait `HasAddresses`, `HasCoordinatePicker`, `GeographicalScopes`, `SushiToJsons` e in `MapPickerTest` (file senza marker). | Ho trovato i file gia' risolti da altri (Lang 7 su 9, Geo 8 su 9, User 16 su 16): nessuna scrittura contro-corrente, gate mtime 120 s. `lint-modules.sh` = OK (da 42 file PHP rotti a 0). **Baseline valida alle ~16:10, ambiente di default (senza `APP_ENV=testing`, per questo non vedo il blocco `.env.testing` della riga sopra)**: `analyse Modules` exit 1 con `totals` valorizzato, zero `phpstan.parse`, 104 errori veri = Geo 103 (32 posizioni distinte, ripetute per ogni classe che usa il trait) e User 1 (`passport_stats.php`, gia' sistemato da un altro agente). Un resolver aveva scelto HEAD e perso 17 `->group('<ID>-INV-n')` (User 4, Media/Notify/UI 13): ripristinati dal backup. Confronto con `13f95412dc`: 37 file su 68 identici; 5 con lato `dev` scelto per merito (User `package.json`/`vite.config.js`/`tailwind.config.js`, `UserResourceTest`, UI `ThemeModelTest`), testo mai presente nella storia del root. Aperto, non toccato: `User/package-lock.json` non coerente con `package.json`; `NoCmsPhantomFolioImportsTest` (User) probabilmente rosso per l'ADR; 2 blade di User citano `app.scss` assente; fixture `*PhpstanProbe*` di Geo contro la regola no-phpstan-probe-models. `merge_remote_repo_2.sh laraxot` gira ancora (Lang, poi Notify): rimisurare i marker a sync finita. |
| lane-lang-ui (24/11 ~16:40 UTC) | `Modules/Lang/app/**`, `Modules/UI/app/**` (+ `Job/JobResource`, `Gdpr/HasGdpr` nello stesso giro) | **fatto.** Marker azzerati in `app/`: Lang 12, UI 9, Job 1, Gdpr 1. Strategia: empty-HEAD→blob pulito `ORIG_HEAD`/`laraxot/dev` (non il solo frammento theirs, che tronca il file); Gdpr docblock → `@see HasGdprTraitTest`. Feature tenute: `SaveTransAction`, blocchi UI (`GetAllBlocksAction` / `ResolveLocalizedBlockDataAction`). Nessun `require Xot/routes/empty.php`. `php -l` OK su tutti. |
| lane-notify-media (24/11 ~16:40 UTC) | `Modules/Notify/app/**`, `Modules/Media/app/**` | **fatto.** Marker azzerati in `app/`: Notify 9, Media 7. Stessa strategia blob pulito. Feature tenute: Mailjet (`CreateMailjetTransportAction`), S3/CloudFront (`TestCloudFrontConnectionAction`, `S3Test`). Nessun `empty.php`. `php -l` OK su tutti. |
| claude (quarto coordinatore, 24/11 17:10 UTC, sessione `analyse Modules`) | `Modules/Xot/app/Models/Policies/Concerns/RequiresOperationalPermissions.php`; `Modules/Notify/tests/Unit/**` e `Notify/docs/parcheggio/tests/**` | **Dipendenze allineate**: `composer update -W` reale, 0 rimozioni; Excel `^4.0` deciso con la storia; exit 255 = `post-autoload-dump` su app con `use` duplicato in User `EmailVerificationController`, lock e vendor gia' scritti. **`trait.unused`, evidenze a due metodi (`rg -P` + `/bin/grep`, 24/11 17:07):** `RequiresOperationalPermissions` ha 32 consumatori in Roosko e un test locale che la usa, l'ADR `module-admin-role-policy-bypass` la nomina: **non parcheggiare**, ripristinata live con ignore motivato (nell'HEAD di Xot c'era gia' un ignore dentro un blocco con marker, stessa direzione). `HasCustomRelations` (quaeris 2, workorder 1) e `HasCommonScopes` (workorder 1) cablate dalla lane in `XotBaseModel`/`NotificationTemplate`: giusto, e la `scopeActive` inline di `NotificationTemplate` e' identica a quella del trait, va tolta. `HasSchemalessAttributes`: nessun consumer di produzione, solo fixture di test in 9 progetti e un probe in workorder, quindi la regola 42 (riferimenti zero) non e' soddisfatta: decide la lane. Notify: tolti i dummy e i test delle tre trait parcheggiate (`tests/Unit/Traits/*`, un test case in `NotifyCoverage100RemainingTest` e uno in `NotifyHighestMissCoverageTest`) con un `rm` unico, fuori regola 42: i quattro file sono ora in `Notify/docs/parcheggio/tests/Unit/Traits/*.zero_used` (sha1 uguale al blob di HEAD), i due test case solo in `git show HEAD:`. **Alla lane Notify:** aggiungere queste righe alla tabella `.zero_used` del README parcheggio (non l'ho toccato: caldo e con marker nel front matter). La copia parcheggiata di `RequiresOperationalPermissions` ora e' ridondante. |
| claude (terzo coordinatore, seguito delle 16:30 UTC) | misura, prompt `bashscripts/docs/prompts/37-phpstan.md` e `59-conflitti-git.md` (sezione "Dopo un resolver automatico"); nessuna scrittura su codice | **Quarta occorrenza: confermata dal boot di PHPStan.** Alle 16:13 `analyse Modules/Geo` e' morto in 5 s con `Application bootstrap failed ... unexpected token "<<"` (stack da `XotBaseServiceProvider::register`): marker nel `HEAD` di Activity (`ActivityServiceProvider.php`), Gdpr (`HasGdpr.php`), 26 file PHP di Lang e poi 10 di Media, committati da `merge_remote_repo_2.sh laraxot` (terminale dell'utente, pts/1). La sync di questo progetto e' finita alle 16:22:09 e in quel momento i file PHP/JSON/neon con marker erano **0** (`rg -P` e `grep -E`, controprova positiva riuscita). La sync del progetto gemello `base_laravelpizza_fila5` gira ancora e spinge sugli stessi remoti: lo zero vale al momento della misura. **Run 16:22:31-16:22:49, ambiente di default:** exit 1 (letto dal mio file `.exit`), JSON valido con `totals.file_errors` = 86 e `errors` = 0, stderr senza `severe`/`incomplete`. Sono 85 in Geo (`HasCoordinatePicker` ripetuto per 9 classi, `HasAddresses` e `GeographicalScopes` nel contesto dei fixture: `missingType.iterableValue` 64, `missingType.generics` 11, `argument.type` 10) e 1 in Activity (`tests/fixtures/CanPaginateHarness.php:63`, `property.notFound` su `$defaultPerPageOption`): 13 posizioni distinte. `->group('<ID>-INV-n')`: 34 occorrenze nei 59 file del backup, 0 mancanti. Alle 16:24:17, a run finita, un altro scrittore ha riscritto in 10 ms `CanPaginateHarness.php`, `HasCoordinatePicker.php` e 4 fixture Geo (`*TestModel`, `*PhpstanProbe`): sono i punti della run, quindi **li lascio a lui** (lane-cms-geo-notify) e rimisuro con una run dietro il gate a file fermi da 120 s. Aperto per l'utente: le 7 sonde `*PhpstanProbe*`/`GeoPhpstanProbeModel` di Geo tornano dai merge (docs `no-phpstan-probe-policy.md`: tolte 27/07 e 24/09) e cancellarle riporta `trait.unused` su `HasAddresses`, `GeographicalScopes`, `SushiToJsons`, `HasPlaceTrait` (nessun utente reale): decidere insieme se eliminare anche i trait morti. `HandlesCoordinatesProbe` NON e' una sonda PHPStan (host dei metodi protetti per `HandlesCoordinatesTest`): tenerla. |
| claude (quinto coordinatore, 24/11 ~17:35, sessione `analyse Modules`, a sync finita) | **S1** `Modules/User/lang/**` (27 `array.duplicateKey` + `passport_stats.php` con `return` doppio); **S2** `Xot/app/Datas/MetatagData.php:515`, `Xot/app/Filament/Resources/Pages/XotBaseListRecords.php:112`, `Xot/app/Filament/Widgets/XotBaseSchemaWidget.php:92`, `Xot/app/Models/Traits/RelationX.php:115`; **S3** `UI/app/Traits/TableLayoutTrait.php` (`trait.unused`) | in corso, un subagente per slice, scope disgiunti, gate mtime 120 s. **Baseline 17:31, ambiente di default:** 36 errori in 19 file (User 28, Xot 7, UI 1; `array.duplicateKey` 27, `assign.overwritten` 5, `deadCode.unreachable` 3, `trait.unused` 1), zero `phpstan.parse`, nessuno dei 19 file toccato nei 5 minuti prima del run. Ultimo commit pulito del root: `dd46996a4` (0 marker PHP; `SYNC_BASE` per questo albero). Ho riparato i due `return new class` doppi delle migrazioni User (`fix_profiles_id_autoincrement`, `create_users_table` 2026_11_17); gli altri 8 file con parse error li avevano gia' sistemati i lane. **Aperto, non toccato:** (1) `User/database/migrations` ha 7 `create_users_table` che il base pulito non aveva (2024_01_01_00000{1,2,6,7}, 2026_02_13_17213{5,6}, 2026_11_12_120000): risuscitati dalla sync, violano "una tabella una migrazione", da guardare uno per uno; (2) `User/lang/it/attach_role.php`: l'unione ha tenuto chiavi segnaposto (`placeholder`/`description` uguali al nome della chiave, `icon`, `navigation` in inglese) che il codice non usa (`AttachRoleAction.php:32,34,43,44` legge solo 4 chiavi) e che `en` non ha; il base `dd46996a4` e' la versione curata, 11 chiavi come `en`; (3) manca `User/lang/de/attach_role.php`. **Risultato (24/11 ~17:55):** `analyse Modules` exit 0, `totals` errors 0 e file_errors 0, stderr senza `severe`/`incomplete` (misura puntuale: altre lane scrivevano ancora). S1/S2 erano già chiusi dalle lane quando i miei subagenti li hanno raggiunti (verificati, più `@see` e docs). S3: `UI\Traits\TableLayoutTrait` non aveva alcun riferimento per nome completo (i due test UI importano il trait vivo `UI\Filament\Actions\Table\TableLayoutTrait`; la ricerca per nome corto dava falsi consumatori), quindi **parcheggiato** in `UI/docs/parcheggio/app/Traits/TableLayoutTrait.php.zero_used` (sha1 = blob di `dd46996a4`) senza `@phpstan-ignore`. Nei 12 progetti fratelli le copie vecchie dei due test (21/11) importano ancora il trait legacy: vanno allineate. |
