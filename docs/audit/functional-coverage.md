# Functional coverage — PRD FR-1 … FR-21

> Audit del 2026-11-05, branch `dev`. Ogni stato è motivato con un riferimento al codice.
> Legenda: ✅ completo e verificato · 🟢 implementato, non verificato end-to-end · 🟡 parziale · 🔴 difettoso · ⛔ mancante o non raggiungibile.

Percorsi abbreviati: `M/` = `laravel/Modules/`, `T/` = `laravel/Themes/Meetup/resources/views/`, `P/` = `laravel/config/local/laravelpizza/database/content/pages/`.

## Epic 1 — Amministrazione eventi

| FR | Stato | Evidenza | Cosa manca |
|---|---|---|---|
| FR-1 Crea/modifica/elimina evento | 🟡 → 🟢 | `M/Meetup/app/Filament/Resources/EventResource.php`: form con `title, description, start_date, end_date, location, status, attendees_count, max_attendees, cover_image` | ✔ **Corretto in questo ciclo**: `max_attendees` `required()->integer()->minValue(1)`; eliminazione con conferma che indica il numero di iscrizioni e passa da `DeleteEventAction` (che ora rimuove anche le righe pivot); `attendees_count` in sola lettura. ⏳ Restano: scelta di sede, relatori, sponsor e organizzatore nel form; create e update ancora senza `CreateEventAction`/`UpdateEventAction`. |
| FR-2 Sedi, relatori, sponsor | ⛔ | Modelli `Venue`, `Performer`, `Sponsor` presenti; nessuna Resource in `M/Meetup/app/Filament/Resources/` oltre a `EventResource` | Resource CRUD e associazione evento ↔ relatori/sponsor/sede. |
| FR-3 Dashboard | 🟡 | `M/Meetup/app/Filament/Widgets/EventStatsOverviewWidget.php`: totale eventi, eventi futuri, partecipazioni totali | Eventi passati, iscrizioni per evento futuro. Etichette hardcoded in italiano. |
| FR-4 Lista iscritti | ⛔ | Nessuna RelationManager o Resource su `EventUser` | Vista iscritti per evento con stato; export da confermare. |

## Epic 2 — Scoperta pubblica

| FR | Stato | Evidenza | Cosa manca |
|---|---|---|---|
| FR-5 Eventi futuri | 🔴 → ✅ | `P/events.json` usa `events.list` con `query` senza `scope`; `T/components/blocks/events/list.blade.php:18-37` esegue `Event::query()->orderBy()->limit(50)` | ✔ **Corretto**: `scopes: [published, upcoming]` in `events.json` e `articles.json`; il blocco supporta `scopes` come `ResolveBlockQueryAction`. Test: `EventVisibilityPageTest`. |
| FR-6 Eventi passati | 🟡 | Scope `Event::scopePast()` esiste | Nessuna pagina o blocco lo usa; il filtro è solo lato client per `status`. |
| FR-7 Dettaglio evento | 🔴 → ✅ | `T/pages/[container0]/[slug0]/index.blade.php:37` e `T/components/blocks/events/detail.blade.php:11` usano `Event::where('slug', …)->first()` | ✔ **Corretto**: `Event::visibleTo($user)` e `abort(404)`; il proprietario vede la propria bozza. ⏳ La capienza residua usa ancora il contatore denormalizzato. |
| FR-8 Filtro città/data | ⛔ | Nessun parametro di query o filtro; `P/events/near-me.json` è solo contenuto | Filtro server-side e messaggio quando non ci sono risultati. |

## Epic 3 — Iscrizione

| FR | Stato | Evidenza | Cosa manca |
|---|---|---|---|
| FR-9 Iscrizione email+password | ⛔ → 🟢 | `RegisterAttendeeToEventAction` e `RegisterWithGdprAction` sono usate solo nei test (`rg` in `Modules/` e `Themes/`). La CTA in `detail.blade.php:327` porta a un `registration_url` esterno, altrimenti mostra "registration open soon" | ✔ **Implementato**: componente `Modules\Meetup\Http\Livewire\EventRegistration` nella pagina evento. L'utente autenticato si iscrive o annulla; il guest va al login e torna all'evento (`url.intended`). ⏳ Il PRD chiede email+password nello stesso form: oggi il guest passa da login o registrazione separati (decisione di prodotto). |
| FR-10 Email di conferma | ⛔ → 🟢 | Nessuna Notification o Mailable per l'iscrizione in `Modules/` | ✔ **Implementato**: `EventRegistrationConfirmedNotification` (coda, `afterCommit`, lingua dell'utente) inviata da `JoinEventAction`. ⏳ In produzione serve un worker di coda e un mailer reale (`.env.example` usa `MAIL_MAILER=log`). |
| FR-11 No sovra-iscrizione | 🟡 → ✅ | `RegisterAttendeeToEventAction` verifica `isFull()` in transazione, con test unitario | ✔ **Corretto**: transazione sulla connessione `meetup` (prima girava sulla connessione di default e non proteggeva nulla), `lockForUpdate()`, solo eventi pubblicati e non iniziati; `isUserRegistered()` interroga la pivot (prima dava sempre false). Test con modello stantio. |

## Epic 4 — CMS

| FR | Stato | Evidenza | Cosa manca |
|---|---|---|---|
| FR-12 Render da JSON | ✅ | `M/Cms/app/Models/Page.php` (`SushiToJsons`), `T/pages/[slug].blade.php`, blocchi in `T/components/blocks/` | Restano file JSON spazzatura `P/1.json … 8.json` con `content_blocks: null` e slug duplicati (`blog.view`). |
| FR-13 Blocchi multi-tipo | ✅ | `hero`, `features`, `cta`, `events.list`, `events.detail`, `profile.detail`… | `events/index.blade.php` è vuoto (0 righe). |
| FR-14 Update senza deploy | 🟢 | Sushi legge i JSON a runtime | Comportamento della cache Sushi in produzione da verificare. |

## Epic 5 — Localizzazione

| FR | Stato | Evidenza | Cosa manca |
|---|---|---|---|
| FR-15 IT/EN via prefisso | 🔴 | `home.json`, `events.json`, `about.json`, `contact.json`, `articles.json`, `events/*.json` hanno solo `content_blocks.it` | Contenuti EN delle pagine core. `config/laravellocalization.php` abilita 6 lingue (it, en, de, fr, es, ru) contro le 2 del PRD. |
| FR-16 Selettore lingua | 🟢 | Regole mcamara in CLAUDE.md; selettore nei layout | Test end-to-end del cambio lingua sulla stessa pagina. |
| FR-17 Nessuna stringa hardcoded | 🔴 | Esempi: `"Skip to main content"` in `T/components/layouts/main.blade.php:14`; `'Totale Eventi'` nel widget; `'Cancelled'` nella Resource; `title: "Upcoming Events"` in `events.json`; date formattate `'F j, Y'` in `Event::toBlockArray()` | Audit completo e chiavi di traduzione. |

## Epic 6 — Conformità

| FR | Stato | Evidenza | Cosa manca |
|---|---|---|---|
| FR-18 Cookie consent | ⛔ | `T/components/ui/cookiebar.blade.php` esiste ma non è incluso in nessun layout (`rg` trova solo il file stesso). Google Fonts caricati senza consenso in `layouts/main.blade.php:8` | Includere il banner e self-hostare i font o caricarli dopo il consenso. |
| FR-19 WCAG 2.1 AA | 🟢 da misurare | Skip link presente; `aria-*` su login e register | Audit axe/Lighthouse: non eseguito, l'app non è avviabile in questo ambiente. |
| FR-20 SEO metadata | ✅ (base) | `M/Cms/resources/views/components/metatags.blade.php`: title, description, canonical, og:* | Unicità per pagina e `hreflang` da verificare. |
| FR-21 JSON-LD evento | 🔴 → ✅ | `detail.blade.php:396-398` stampa `{!! json_encode($schemaOrg, …) !!}` senza `JSON_HEX_TAG` | ✔ **Corretto**: `JSON_HEX_TAG|AMP|APOS|QUOT`, anche nel JSON-LD di pagina (`metatags.blade.php`). Test dedicato. |

## Riepilogo

| | Prima del ciclo | Dopo il ciclo |
|---|---|---|
| ✅ completi | 3 (FR-12, 13, 20) | 7 (+ FR-5, 7, 11, 21) |
| 🟢 implementati, da verificare in produzione | 3 (FR-14, 16, 19) | 6 (+ FR-1, 9, 10) |
| 🟡 parziali | 4 | 2 (FR-3, FR-6) |
| 🔴 difettosi | 5 | 2 (FR-15, FR-17) |
| ⛔ mancanti | 6 | 4 (FR-2, 4, 8, 18) |

Journey UJ-1 (l'organizzatore pubblica): **possibile, ma senza sede, relatori e sponsor**. Journey UJ-2 (il partecipante si iscrive e riceve la conferma): **completabile** per un utente registrato. Il login stesso dal sito pubblico era rotto: al `LoginWidget` mancava la proprietà di stato `$data` del form. Corretto e coperto da test.

## Funzionalità fuori PRD presenti nel codice

- Proposta e approvazione di meetup da parte degli utenti: `ProposeMeetupAction`, `ApproveMeetupAction`, `RejectMeetupAction`. Hanno test ma non sono collegate alla UI.
- Import di eventi da JSON: `ImportEventsFromJsonAction` e `Filament/Actions/ImportEventsAction`.
- Feedback (`Feedback`, `CreateFeedbackAction`), profili pubblici (`profile/[id]`), moduli Rating, Geo, Notify (SMS, push, Telegram…).

Da decidere in sede di prodotto se tenerli, nasconderli o rimuoverli dalla v1.
