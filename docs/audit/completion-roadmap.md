# Completion roadmap e backlog

> Audit del 2026-11-05. Il backlog sostituisce le liste di "missing features", "technical debt" e "improvement opportunities", per avere un solo elenco ordinato. ID: G = gap funzionale, T = debito tecnico, I = miglioramento; S/D/R rimandano a [security-audit.md](security-audit.md), [database-audit.md](database-audit.md), [risk-register.md](risk-register.md).
> Sforzo: S ≤ ½ giornata · M ≤ 2 giorni · L > 2 giorni. Confidenza della diagnosi: A alta (riprodotta o verificata nel codice), M media.

## Fatto nel ciclo 1 (verificato con test)

S-01, S-03, S-04, S-05, S-11, D-03 (in parte), D-04, D-05 (in parte), D-10, D-11, D-12, R-02, R-03, FR-1 (in parte), FR-5, FR-7, FR-9, FR-10, FR-11, FR-21, login del sito, fatal del `TestCase` del modulo User, 2 test con errori di sintassi, file spuri in `app/Helpers` che rompevano il boot. Elenco dei file in [readme.md](readme.md).

## Backlog

### P0 — Blocking

| ID | Cosa | Evidenza | Sforzo | Conf. | Criteri di accettazione |
|---|---|---|---|---|---|
| R-01 | **Install riproducibile**: `require.php` a `^8.4`, `composer update` per riallineare il lock ai `composer.json` dei moduli (il merge-plugin oggi lancia "Running composer update to apply merge settings" anche dopo `install`) | Log CI; install locale | M | A | `composer install` su un checkout pulito con PHP 8.4 termina senza update; il job CI "Install" è verde |
| T-01 | **Build del tema in CI**: `resources/css` importa `../../vendor/filament/support/...`, che non esiste senza `composer install` nel tema | Log CI "Theme Build" | S | A | Job Theme Build verde |
| S-06 | Rimuovere i `.env.*` con `APP_KEY` e password dal repo pubblico; ruotare le chiavi usate fuori dallo sviluppo | `git ls-files` | S | A | Nessun `.env*` tranne `.env.example` tracciato; `APP_KEY` nuova dove serve |
| D-10b | Verificare lo **schema reale di `profiles` in produzione** prima del deploy (fresh = `id` incrementale + `uuid`) | D-10 | S | M | Query `SHOW COLUMNS FROM profiles` documentata; se `id` è uuid, migrazione di conversione esplicita |
| S-02 | Limitare `ResolvePageAction` alla whitelist `xra.container0_model_map`; niente `newQueryWithoutScopes()` né query raw; rispettare `SoftDeletes` | Cms resolver | M | A | Test: `/it/user/{id}` → 404; modello soft-deleted → 404. Fix portato anche su `module_cms_fila5` |

### P1 — Essential (flussi del PRD)

| ID | Cosa | FR | Sforzo | Criteri di accettazione |
|---|---|---|---|---|
| G-02 | Resource Filament `Venue`, `Performer`, `Sponsor`; nel form evento: sede (`location_id`), relatori, sponsor, organizzatore; conferma all'eliminazione se collegati a eventi futuri | FR-1, FR-2 | M | Story 1.2 BMAD; test Livewire sulle Resource |
| G-04 | RelationManager "Iscritti" su `EventResource` (email, data, stato); export CSV **solo se confermato** | FR-4 | S | Story 1.4 |
| G-03 | Dashboard: eventi passati e iscrizioni per evento futuro, etichette tradotte | FR-3 | S | Story 1.3 |
| G-06 | Pagina "eventi passati" (scope `published()->past()`, ordinamento decrescente, senza CTA) | FR-6 | S | Story 2.2 |
| G-08 | Filtro per città e data server-side (query string), messaggio quando non ci sono risultati | FR-8 | M | Story 2.4 |
| G-15 | Contenuti EN di `home`, `events`, `about`, `contact`, `events/*`; ridurre `supportedLocales` a `it`,`en` o fornire le altre lingue | FR-15 | M | `/en/{slug}` per tutte le pagine core con contenuto inglese |
| G-18 | Includere `ui/cookiebar` nel layout; Google Fonts self-hosted o caricati dopo il consenso | FR-18, R-10 | S | Nessuna richiesta a terzi prima del consenso (verifica in DevTools) |
| G-09b | Decidere se il guest deve potersi iscrivere con email+password nello stesso form (PRD FR-9) o se bastano login e registrazione separati | FR-9 | S (decisione) | Decisione registrata nella story 3.1 |
| G-11 | `CreateEventAction` e `UpdateEventAction` usate dalle pagine Filament (`handleRecordCreation`/`handleRecordUpdate`) | FR-1 / AD-3 | S | Story 1.1 Task 3 |

### P2 — Important

| ID | Cosa | Sforzo |
|---|---|---|
| R-04 | I test non devono saltare sui 500 (`cmsSkipTest`); riscrivere i 33 test Meetup obsoleti (rotte inesistenti, stub, HTML vecchio) | M |
| D-01 | Consolidare le migrazioni duplicate (27 tabelle), una per tabella, modulo per modulo | L |
| D-02 | Rimuovere le migrazioni delle tabelle orfane `event_performers` ed `event_sponsors` | S |
| D-06 | Slug evento unico con suffisso (o `spatie/laravel-sluggable`) | S |
| D-12b | `Cms/tests/Feature/PageManagementBusinessLogicTest.php` non deve scrivere nei JSON reali (usare una directory temporanea) | S |
| D-13 | 55 file PHP vuoti: ripristinarli dalla storia Git o rimuoverli | M |
| S-07 | Chiarire chi può entrare in `/admin` (oggi qualsiasi utente autenticato) | S |
| S-08 | `PageSlugMiddleware` deve fallire in modo chiuso | S |
| S-09 | Rimuovere `Blade::render()` su dati di blocco | S |
| S-10 | Email dell'organizzatore visibile solo con opt-in | S |
| S-12 | Rimuovere le 77 chiamate attive a `dd`/`dddx` | S |
| S-13 | Aggiornare le dipendenze npm vulnerabili | S |
| G-17 | Stringhe hardcoded nel tema e nel widget (FR-17) e date localizzate in `Event::toBlockArray()` | M |
| T-02 | Pint sull'intero codice (1.868 problemi) in un commit separato di sola formattazione | S |
| T-03 | Riallineare la documentazione a Laravel 13 e PHP 8.4; ripulire i 377 `.md` con marker di conflitto | M |
| R-06 | Riportare upstream le correzioni a Cms e User (`module_cms_fila5`, `module_user_fila5`) | S |

### P3 — Enhancement

| ID | Cosa | Valore / rischio |
|---|---|---|
| I-01 | Lista d'attesa quando l'evento è pieno | Alto per i meetup popolari; basso rischio |
| I-02 | File `.ics` allegato alla conferma e link "aggiungi al calendario" | Alto, sforzo S |
| I-03 | Promemoria 24 ore prima (scheduler + coda) | Medio; richiede lo scheduler attivo (R-09) |
| I-04 | Enforcement dei confini tra moduli (PHPArkitect) | Medio; previene dipendenze come Cms → Meetup |
| I-05 | Test end-to-end Playwright del journey UJ-2 in CI | Alto per la regressione |
| I-06 | Comando di riconciliazione `attendees_count` ↔ `event_user` | Medio |

## Roadmap

| Fase | Obiettivo | Attività | Prerequisiti | Completata quando |
|---|---|---|---|---|
| 1. Stabilizzazione | Build, CI e dati affidabili | R-01, T-01, S-06, D-10b, S-02, T-02 | — | CI su `dev` verde e rossa solo per test reali; `migrate` da zero ok (✔ già); nessun segreto nel repo |
| 2. Completamento funzionale | Tutti i FR del PRD | G-02, G-04, G-03, G-06, G-08, G-11, G-09b | Fase 1 per la CI | Epic 1-3 BMAD `done`, con test |
| 3. Qualità e affidabilità | Test che proteggono davvero | R-04, D-12b, D-02, D-06, S-07…S-12, I-05 | Fase 2 | 0 fallimenti nella suite Meetup; E2E di UJ-1 e UJ-2 verdi |
| 4. Ottimizzazione | i18n, UX, debito | G-15, G-17, D-01, D-13, T-03, S-13 | Fase 3 | Pagine core in IT/EN; axe senza violazioni A/AA su Home, Eventi e Dettaglio (FR-19) |
| 5. Production readiness | Operatività | Runbook di deploy e rollback, worker di coda (supervisor), mailer reale, backup e restore del DB testati, health check (`config/health.php`), error tracking, G-18, verifica legale GDPR | Fasi 1-4 | Restore provato su un ambiente di staging; alert attivi |
| 6. Evoluzione | Valore per la community | I-01, I-02, I-03, I-04, pagamenti v2 (fuori dallo scope v1) | Fase 5 | — |

**Percorso critico**: R-01 → CI verde → G-02/G-04 (dipendono dai test in CI) → G-18 + G-15 → runbook e staging → rilascio.
