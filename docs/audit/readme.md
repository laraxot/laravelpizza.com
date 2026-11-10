# Audit LaravelPizza — indice

> Audit e correzioni del 5–9 novembre 2026, branch `dev`, partendo da `6fbf2141c`.
> Ogni affermazione rimanda a file, test o comandi riproducibili. Le valutazioni ancora provvisorie sono indicate come tali.

| Documento | Contenuto |
|---|---|
| [project-overview.md](project-overview.md) | Che cos'è il progetto, stack reale, stato prima e dopo |
| [architecture.md](architecture.md) | Architettura ricostruita dal codice, punti di forza, criticità |
| [module-inventory.md](module-inventory.md) | I 16 moduli: dimensioni, test, ruolo |
| [functional-coverage.md](functional-coverage.md) | Requisiti FR-1…FR-21 del PRD: stato e evidenze |
| [security-audit.md](security-audit.md) | Rilievi di sicurezza S-01…S-14 |
| [database-audit.md](database-audit.md) | Migrazioni, schema, integrità D-01…D-13 |
| [test-coverage.md](test-coverage.md) | Test eseguiti, risultati, test aggiunti, lacune |
| [risk-register.md](risk-register.md) | Rischi R-01…R-10 |
| [completion-roadmap.md](completion-roadmap.md) | Backlog P0–P3, roadmap in 6 fasi, percorso critico |
| Manuale d'uso | [`laravel/Themes/Meetup/docs/manuale-utente/`](../../laravel/Themes/Meetup/docs/manuale-utente/readme.md) |

## Punteggi (0–100, motivati nei documenti)

| Area | Prima | Dopo | Confidenza | Note |
|---|---|---|---|---|
| Funzionalità rispetto al PRD | 25 | 60 | Alta | 7 FR completi, 6 implementati e da verificare in produzione |
| Sicurezza applicativa | 35 | 65 | Media | Restano S-02 (resolver Cms), S-06 (segreti nel repo), S-07 (accesso `/admin`) |
| Integrità dati | 30 | 60 | Alta | Restano migrazioni duplicate (D-01) e assenza di foreign key |
| Test | 20 | 45 | Alta | 33 test Meetup preesistenti ancora rossi, nessun E2E in CI |
| Build/CI | 10 | 25 | Alta | CI ancora rossa per R-01 (lock Composer), ma ora onesta |
| UX/i18n | 40 | 60 | Media | Admin e pagine core in italiano; contenuti EN incompleti |
| Production readiness | 15 | 20 | Media | Nessun runbook di deploy, backup o monitoraggio |

## Ciclo 1 — cosa è stato fatto

Ogni correzione è coperta da test, oppure verificata nel browser durante la cattura degli screenshot del manuale.

**Bloccanti trovati usando l'app come un utente reale**
- `php artisan migrate` falliva su MySQL vuoto in 3 punti (D-11): corretto.
- Ogni pagina pubblica andava in 500: sezioni CMS duplicate e 171 file di test committati (D-12). Rimossi.
- Login dal sito non funzionante: al `LoginWidget` mancava lo stato del form `$data`. Corretto, con limite di 5 tentativi (S-05).
- **Registrazione nuovo utente in 500**: `users.name` obbligatorio e mai compilato. `CreateUserAction` ora lo ricava da nome e cognome. Dopo la registrazione si veniva mandati a `/ru/dashboard` (lingua sbagliata, pagina vuota); ora si torna alla pagina di provenienza o alla home nella lingua corrente.
- **Pannello organizzatore inutilizzabile su DB nuovo**: profili senza colonna `uuid` né chiave generata, dashboard con proprietà `$calendar` inesistente, lista eventi in 500 per le traduzioni degli enum, tutti i pannelli in 500 senza gli asset Geo compilati. Tutto corretto.
- Richieste autenticate in 500 su DB nuovo (schema `profiles` del modulo User, D-10).

**Sicurezza e regole di dominio**
- Bozze e pending non più pubblici; 404 per gli slug inesistenti (S-01).
- JSON-LD non più iniettabile (S-03).
- Capienza rispettata anche in concorrenza: transazioni sulla connessione giusta e `lockForUpdate` (S-04).
- **I middleware dichiarati nei JSON CMS (es. `auth`) non venivano mai applicati**: con Folio la rotta è il fallback senza parametro `slug`. `PageSlugMiddleware` ora ricava lo slug dal percorso; gli ospiti vanno al login nella loro lingua.
- `GET /auth/logout` eseguiva `dd('a')` (S-11).

**Funzionalità completate**
- Iscrizione a un evento dalla pagina evento, annullamento ed email di conferma (FR-9, FR-10, FR-11).
- "I miei eventi": la pagina non veniva caricata (il CMS legge solo `pages/*.json`, non le sottocartelle) e la sorgente `user_subscribed` non era implementata.
- Lista eventi: solo pubblicati e futuri; badge "Passato" errato su tutti gli eventi; date in italiano.
- Admin: capienza obbligatoria; eliminazione con conferma che indica il numero reale di iscritti; etichette e aiuti dei campi in italiano e inglese; tolti i widget duplicati e contraddittori.

**Interfaccia**
- CSS del tema ricompilato: hero sovrapposto alle card, `@source` sul modulo Meetup.
- `@filamentScripts` nel layout pubblico: i form Filament mostravano "Si è verificato un errore".
- Logo admin rotto, segnaposto `<nome progetto>`, testi di aiuto grezzi (`email`, `password`), intestazioni "empty" nei widget, chiave di traduzione del footer non tradotta.
- Voce "Dashboard" del menu utente rimossa (pagina inesistente); "Profilo" punta al profilo dell'utente.
- 404 per le pagine CMS inesistenti.

## Ciclo 2 — allineamento al dev aggiornato e manuale d'uso

Dopo il rebase sul `dev` aggiornato (nuovo `composer.lock`, PHPStan 2.3.5) sono emersi e sono stati corretti:

- `Modules/Xot/composer.json`: `autoload-dev` annidato dentro `autoload` e vuoto → nessuna suite di modulo partiva (`Modules\Xot\Tests\CreatesApplication` non trovato).
- `Venue`: regola `insteadof` su un metodo rimosso da `GeoTrait` → fatal error al caricamento.
- Login: chiavi `user::auth.login.*` diventate array → errore 500 nella vista del tema.
- Home: i blocchi CMS mostravano `{{ trans(...) }}` come testo dopo l'irrigidimento di `HasBlocks` (solo `route()`); ora sono ammesse anche `trans()`/`__()` con chiave letterale.
- Dopo login/registrazione: redirect a `/area-personale` (pagina che in LaravelPizza non esiste, 404); ora configurabile con `xra.post_login_path` (`/events-my`).
- Form eventi admin: etichette grezze dopo lo spostamento in `EventResource/Schemas/EventForm`.

Ancora aperti: test di modulo che lasciano dati sul DB `user` di test (es. `test@example.com`), 3 test `AuthFlowRedirectsTest` e il test `route('container0.index')` di Cms che presuppongono rotte di Fixcity.

Manuale d'uso per visitatore, partecipante e organizzatore, con screenshot: [`laravel/Themes/Meetup/docs/manuale-utente/`](../../laravel/Themes/Meetup/docs/manuale-utente/readme.md).

## Limiti dell'audit

- La CI non è stata portata a verde: richiede di rigenerare `composer.lock` (R-01), un'operazione che il maintainer deve decidere.
- Nessun test contro l'ambiente di produzione; lo schema reale di `profiles` in produzione va verificato (D-10b).
- `composer audit` non è stato eseguito: il proxy ha interrotto il download dell'advisory DB.
- La valutazione GDPR è tecnica, non legale.
