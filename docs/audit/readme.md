# Audit LaravelPizza — indice

> Audit e correzioni del 5–11 novembre 2026, branch `dev`, partendo da `6fbf2141c`.
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
| Manuale d'uso | [`laravel/Themes/Meetup/docs/manuale-utente/`](../../laravel/Themes/Meetup/docs/manuale-utente/readme.md) — anche in [PDF](../../laravel/Themes/Meetup/docs/manuale-utente/pdf/manuale-completo.pdf) |

## Punteggi (0–100, motivati nei documenti)

| Area | Inizio | Ciclo 1 | Ciclo 3 | Note |
|---|---|---|---|---|
| Funzionalità rispetto al PRD | 25 | 60 | 90 | Tutti gli FR della v1 implementati e testati; FR-9 senza form unico email+password (decisione di prodotto) |
| Sicurezza applicativa | 35 | 65 | 80 | S-02, S-07, S-09, S-10 chiusi; resta la revisione dei moduli condivisi |
| Integrità dati | 30 | 60 | 70 | Slug univoci, pulizia dei collegamenti; restano migrazioni duplicate (D-01) e foreign key |
| Test | 20 | 45 | 80 | 395 test della suite Project verdi; moduli condivisi misurati a parte |
| Build/CI | 10 | 25 | 85 | PHPStan, Pint, test e build del tema verdi su `dev` |
| UX/i18n | 40 | 60 | 85 | Pagine core IT/EN, niente link rotti, home rifatta |
| Production readiness | 15 | 20 | 75 | Runbook, health check, backup/rollback, scheduler; mancano staging e prova di ripristino |

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

## Ciclo 3 — completamento per il rilascio (10–11 novembre 2026)

**Pannello organizzatore**: sedi, relatori, sponsor (Resource complete), sede/relatori/sponsor nel form evento con creazione al volo, tabella iscritti con annullamento ed export CSV, bacheca con iscritti su posti, creazione e modifica tramite le Action di dominio. Bug corretti: `user_id` salvato come `0` (cast `(int)` di un UUID) in `CreateEventAction` e `ProposeMeetupAction`; filtro "stato" con valori inesistenti; eliminazione dalla tabella che saltava `DeleteEventAction` e lasciava iscrizioni orfane.

**Sito pubblico**: ricerca per città e date, pagina eventi passati, home con i prossimi eventi a piena larghezza, modulo contatti funzionante (prima `action="#"` e 500), Chi siamo e Contatti in IT/EN senza numeri inventati, Privacy/Termini/Cookie policy reali (erano segnaposto), nessun link rotto (verificati 53 link), font serviti dal sito, file .ics e promemoria del giorno prima.

**Qualità e operatività**: CI verde (PHPStan livello 10, Pint su tutto il codice, suite Project, build del tema), suite dei moduli condivisi informativa in un job separato, health check pianificati, [runbook di rilascio](../deploy/runbook.md), symlink del tema, test spostati nei moduli.

**Da fare prima di andare online** (non risolvibili dal codice):
1. Dati legali del titolare (ragione sociale, indirizzo) in Privacy e Termini, e revisione legale.
2. Verificare che `hello@laravelpizza.com` e `partners@laravelpizza.com` esistano; impostare `CONTACT_EMAIL` e `HEALTH_NOTIFY_EMAIL`.
3. Server: cron dello scheduler, worker della coda, mailer reale, `storage:link`, backup notturni (runbook §1–§7).
4. Su un database esistente: controllo D-10b dello schema `profiles` prima del primo `migrate`.
5. Una prova di ripristino del backup su staging.

**Aperti, non bloccanti**: suite dei moduli condivisi (circa 1.600 test rossi, scritti per altri progetti: vanno sistemati nei repository dei moduli); alcune suite di Xot lanciano composer sul progetto reale; migrazioni duplicate (D-01).

## Limiti dell'audit

- Nessun test contro l'ambiente di produzione; lo schema reale di `profiles` in produzione va verificato (D-10b).
- `composer audit` non è stato eseguito: il proxy ha interrotto il download dell'advisory DB.
- La valutazione GDPR è tecnica, non legale.
