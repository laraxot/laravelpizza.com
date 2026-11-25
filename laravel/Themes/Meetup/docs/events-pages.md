---
title: "Pagine eventi: elenco e dettaglio"
type: reference
status: active
theme: Meetup
qmd: "events page eventi elenco dettaglio event detail events.json events/view slug0 container0 blocks events list detail iscrizione ics json-ld visibleTo livewire plain blade parity"
---

# Pagine eventi: elenco e dettaglio

Gli eventi sono il cuore del sito. Questa pagina spiega come arrivano da JSON del CMS e dal modello `Modules\Meetup\Models\Event` fino alle view del tema, le regole che evitano le rotture ricorrenti e come si confronta il risultato con laravelpizza.com ([visual-parity](visual-parity.md)).

## Flusso (verificato sul codice)

| URL | Pagina Folio | Contenuto |
|---|---|---|
| `/{locale}/events` | `[container0]/index.blade.php` (`name('container0')`) | JSON `config/local/laravelpizza/database/content/pages/events.json`: blocco `events` con view `pub_theme::components.blocks.events.list` |
| `/{locale}/events/{slug}` | `[container0]/[slug0]/index.blade.php` (`name('container0.view')`) | se esiste un `Event` visibile con quello slug: JSON `events/view.json` (view `...blocks.events.detail`) con `event`/`item` nel contesto |
| `/{locale}/events/past`, `/{locale}/events/my` | stessa pagina `[container0]/[slug0]` | niente evento con quello slug: sotto-pagina CMS `events.past` / `events.my` (`pages/events/past.json`, `pages/events/my.json`), stesso blocco `list` con `timing: past` e `events_source: user_subscribed` |

Regole del routing generico: la pagina Folio fa `middleware(PageSlugMiddleware::class)`, rende `<x-page side="content" :slug="$this->pageSlug" :data="$this->data" />` e non contiene HTML di pagina ([folio-routing](folio-routing.md), [cms-json-pages](cms-json-pages.md), [ADR](adr/public-pages-from-json-via-x-page.md)). Per `container0 = events` il modello e' cercato con `Event::query()->visibleTo($user)->where('slug', $slug0)`: sono visibili gli eventi pubblicati e, al proprietario, bozze e in attesa; evento inesistente o non visibile = 404 (PRD FR-7), senza passare dal resolver generico che ignora scope e soft delete. Un contenitore senza modello e senza pagina CMS da' 404, mai una pagina vuota con 200. Gli alias vecchi (`events-my`, `events-past`, `events-near-me`) sono in `config/local/laravelpizza/seo.php`.

`<x-page>` (`Modules/Cms/resources/views/components/page.blade.php`) include i blocchi con `@include($block->view, array_merge($block->data, $data, ['data' => ...]))`: il contesto di rotta (`slug0`, `item`, `event`) arriva quindi nei blocchi uniti ai dati del JSON. Se il blocco mostra "Nessun evento trovato" il contesto non e' stato unito.

## Blocco elenco (`blocks/events/list.blade.php`)

Le sorgenti si scelgono con la chiave `events_source` del blocco nel JSON; la logica sta nelle Action del modulo Meetup, la Blade sceglie solo quale chiamare:

- `public`: `SearchPublicEventsAction` con `timing` `upcoming|past`, filtri `city`, `from`, `until` dalla query string, `limit` (default 50), barra di ricerca con `show_search`, elenco citta' via `->cities($timing)`.
- `user_subscribed`: `GetUserRegisteredEventsAction` per l'utente autenticato ("I miei eventi"; vuoto per gli ospiti).
- nessuna: eventi passati dal contesto o `query` generica del JSON (`model`, `scope`, `order`, `limit`).
I modelli sono trasformati con `Event::toBlockArray()` (che costruisce anche l'URL SEO con lo slug).

## Blocco dettaglio (`blocks/events/detail.blade.php`)

- Risolve il modello da `$event`, poi `$item`, poi (estremo) `slug0` con lo stesso `visibleTo`; mostra data/ora tradotte (`translatedFormat`), posti (`attendees_count`/`max_attendees`, soglia "pochi posti" = max(5, 15%)), argomenti (`meta_data['topics']` + keywords), organizzatore, pubblico, fascia d'eta', apertura iscrizioni.
- Iscrizione: `@livewire(\Modules\Meetup\Http\Livewire\EventRegistration::class, ['event' => $eventModel])`; la CTA non deve promettere una registrazione inesistente (niente RSVP senza flusso reale).
- Calendario: file `.ics` generato sul momento da `BuildEventIcsAction`, come link `data:text/calendar` (nessun servizio esterno); icona `meetup-icon-calendar`.
- Dati strutturati: `<script type="application/ld+json">` da `Event::toSchemaOrg()` ([seo-structured-data](seo-structured-data.md)). L'email dell'organizzatore non va mostrata a tutti.
- Condivisione social localizzata ([social-share-and-marketing](social-share-and-marketing.md)); breadcrumb "Torna agli eventi" verso `LaravelLocalization::localizeUrl('/events')`.

## Regola critica: i blocchi inclusi sono Blade semplice

I blocchi del CMS sono inclusi con `@include` dentro il componente Volt della pagina Folio: `$this` e' il componente genitore (`container0.view`), non un componente del blocco. Usare `$this->event`, `wire:click` o `wire:model` in un blocco da' `Livewire\Exceptions\PropertyNotFoundException: Property [$event] not found on component: [container0.view]`. Quindi: niente stato Livewire nel file del blocco; per interazioni locali (modali) Alpine `x-data`, per logica con stato un componente Livewire dedicato montato con `@livewire(...)` (come `EventRegistration`). Dettagli sui pattern in [volt-components](volt-components.md) e [blocks-and-components](blocks-and-components.md).

## Errori tipici

| Sintomo | Causa | Fix |
|---|---|---|
| Dettaglio con "Nessun evento trovato" | contesto di rotta non unito ai dati del blocco | `array_merge` di dati globali e di blocco nel renderer `x-page` (gia' presente) |
| `PropertyNotFoundException ... [container0.view]` | blocco trattato come Volt/Livewire | blocco plain Blade, Alpine o `@livewire` |
| `Undefined $pageSlug` nella pagina `[container0]/[slug0]` | proprieta' non dichiarata/valorizzata nel `mount()` | `pageSlug` e' una proprieta' pubblica impostata in `mount()` |
| `/events/{slug}` 404 per un evento che esiste | evento non pubblicato o non del chiamante (`visibleTo`) | pubblicare, o accedere come proprietario |
| Metadati opzionali assenti (audience, fascia d'eta', keywords, apertura iscrizioni) | non valorizzati nel modello | mostrarli solo se presenti; empty state esplicito per i partecipanti |
| Modalita' di partecipazione mostrata come chiave `meetup::event_attendance_mode...` | chiave di traduzione sbagliata | `values.<caso>.label`, presente in tutte le lingue |

## Debito noto

`Themes\Meetup\Http\Controllers\EventBookingController::book()` (`POST /events/{slug}/book`, nome `events.book`, registrata da `ThemeServiceProvider`) e' un endpoint JSON di prenotazione con messaggi inglesi fissi: nessuna Blade del tema o del modulo Meetup lo richiama (l'iscrizione passa da `EventRegistration`). E' un controller nel tema, contro la regola Folio+JSON ([theme-rules](theme-rules.md)); candidato alla rimozione ([roadmap](roadmap.md)).

## Vedi anche

- [visual-parity](visual-parity.md) — confronto con laravelpizza.com (elenco e dettaglio)
- [dashboard-and-profile](dashboard-and-profile.md) — "I miei eventi" e profilo
- [testing](testing.md) — `EventDetailPageTest`, `PublicEventsListTest`, `EventVisibilityPageTest`
