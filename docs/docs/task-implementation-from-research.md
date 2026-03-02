# Task di Implementazione da Ricerca Schema.org e Analisi Visiva

**Origine**: Studio approfondito di schema.org (Event, EventSeries, eventSchedule, JoinAction, LeaveAction, EventReservation, EducationEvent, FoodEstablishment, Offer, PriceSpecification, GeoCircle, Person, address) e confronto visivo con laravelpizza.com.

---

## Task Priorita' CRITICA (Bloccanti)

### TASK-C1: Creare componente events/list.blade.php

**Stato**: La pagina `/it/events` e' rotta ("View not found: pub_theme::components.blocks.events.list")

**File da creare**:
- `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`
- `Themes/Meetup/resources/views/components/blocks/events/card.blade.php`

**Requisiti**:
- Titolo sezione + subtitle
- Filtri pill (All / Upcoming / Past) con Alpine.js
- Grid responsive 3/2/1 colonne
- Event cards con: immagine, badge status, titolo, descrizione, data, orario, location, attendees
- Schema.org JSON-LD per ogni evento

**Riferimento**: `Themes/Meetup/docs/events-page-comparison.md`

### TASK-C2: Creare/verificare events.json per CMS

**File**: `config/local/laravelpizza/database/content/pages/events.json`

Deve definire `content_blocks` con `view: pub_theme::components.blocks.events.list`

### TASK-C4: Rifattorizzazione Icone Header (v1)

**Stato**: COMPLETATO (Rifattorizzato in `Themes/Meetup/resources/views/components/sections/header/v1.blade.php`).

**Requisiti**:
- Estrarre tutti gli SVG inline in file `.svg` dentro `Modules/Meetup/resources/svg/`. [FATTO]
- Sostituire gli SVG inline con `<x-filament::icon icon="meetup-icon-..." />`. [FATTO]
- Assicurarsi che le icone seguano il principio **Symbolic Minimalism**. [FATTO]

---

## Task Priorita' ALTA

### TASK-A1: Traduzioni multilingua

Creare file di traduzione per IT + 5 lingue EU (EN, ES, FR, DE, PT):
- `Modules/Meetup/resources/lang/{locale}/home.php` - Titoli homepage
- `Modules/Meetup/resources/lang/{locale}/events.php` - Pagina eventi
- `Modules/Meetup/resources/lang/{locale}/navigation.php` - Menu navigazione

Chiavi necessarie:
```php
// events.php
'upcoming' => 'Prossimi Eventi',
'all' => 'Tutti gli Eventi',
'past' => 'Eventi Passati',
'attendees' => 'partecipanti',
'subtitle' => 'Unisciti a noi per pizza e discussioni su Laravel',
'no_events' => 'Nessun evento in programma',
'register' => 'Registrati',
'details' => 'Dettagli',
```

### TASK-A2: Implementare Schema.org Event base

Aggiungere metodo `toSchemaOrg()` al modello Event con:
- `@type: Event`
- `name`, `description`, `startDate`, `endDate`, `url`
- `location` (Place con PostalAddress)
- `organizer` (Organization)
- `offers` (Offer con price)
- `eventAttendanceMode`, `eventStatus`
- `maximumAttendeeCapacity`, `remainingAttendeeCapacity`

### TASK-A3: Implementare Schema.org EventSeries

Per i meetup ricorrenti (es. "Laravel Pizza Meetup Milano - ogni primo giovedi"):
- Modello EventSeries con relazione hasMany Event
- Proprieta' `eventSchedule` con tipo Schedule
- `repeatFrequency` (P1M = mensile), `byDay` (Thursday), ecc.

### TASK-A4: Implementare JoinAction/LeaveAction per RSVP

Per il sistema di registrazione eventi:
- Action `JoinEventAction` che genera markup JoinAction
- Action `LeaveEventAction` che genera markup LeaveAction
- `actionStatus`: ActiveActionStatus, CompletedActionStatus, FailedActionStatus
- Integrazione con il modello EventAttendance

---

## Task Priorita' MEDIA

### TASK-M1: EventReservation per ticketing

- Modello EventReservation con: reservationId, status, totalPrice, priceCurrency
- `ReservationStatusType`: Confirmed, Pending, Cancelled, Hold
- Ticket con QR code generation

### TASK-M2: EducationEvent per workshop tecnici

Per eventi di tipo workshop/training:
- Estendere Event con `teaches` (competenze insegnate)
- `educationalLevel` (Beginner, Intermediate, Advanced)
- `assesses` (competenze valutate)

### TASK-M3: FoodEstablishment per venue partner (pizzerie)

Per le pizzerie che ospitano i meetup:
- Modello FoodEstablishment (o Venue con tipo)
- `servesCuisine`, `priceRange`, `acceptsReservations`
- Sottotipi: Restaurant, CafeOrCoffeeShop

### TASK-M4: Offer e PriceSpecification per biglietti

Per eventi a pagamento e gratuiti:
- Modello Ticket/EventOffer con: price, priceCurrency, availability
- `ItemAvailability`: InStock, SoldOut, LimitedAvailability
- Early bird pricing con `validFrom`/`validThrough`

---

## Task Priorita' BASSA

### TASK-B1: GeoCircle per aree di servizio

Per mostrare "eventi vicino a te":
- Trait HasGeoCircle su modelli con coordinate
- `geoMidpoint` + `geoRadius`
- Integrazione con modulo Geo

### TASK-B2: Person enhancement per profili utente

Migliorare il profilo utente con proprieta' Schema.org Person:
- `jobTitle`, `worksFor` (Organization)
- `knowsAbout` (competenze tecniche)
- `sameAs` (GitHub, Twitter, LinkedIn)
- `affiliation`

### TASK-B3: PostalAddress per venue

Implementare markup PostalAddress completo per venue:
- `streetAddress`, `addressLocality`, `addressRegion`
- `postalCode`, `addressCountry`
- Livelli amministrativi italiani (Regione, Provincia, Comune)

---

## Riferimenti Documentazione

- Schema.org research: `Modules/Meetup/docs/schema-org-research-comprehensive.md`
- Schema.org recommendations: `Modules/Meetup/docs/schema-org-enhancement-recommendations.md`
- Schema.org implementation tasks: `Modules/Meetup/docs/schema-org-implementation-tasks.md`
- Visual comparison: `Themes/Meetup/docs/visual-comparison-local-vs-original.md`
- Events comparison: `Themes/Meetup/docs/events-page-comparison.md`
- Footer logo: `Themes/Meetup/docs/footer-logo-confronto.md`
- SVG rules: `.cursor/rules/icon_management_standard.md`
- Database rules: `.cursor/memories/database-config-laravel-12-tenant.md`
