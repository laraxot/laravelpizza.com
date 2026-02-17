# Event Detail Page - Pixel Parity Analysis

## Overview
Comparazione tra la pagina evento locale e la pagina di riferimento su laravelpizza.com.

## Screenshots

### Pagina Locale (http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party)
- **Stato**: Placeholder/Template base
- **Badge**: "Past Event" (data odierna 17 Feb 2026)
- **Contenuto**: Minimale, dati statici/placeholder

### Pagina di Riferimento (https://laravelpizza.com/events/1)
- **Stato**: Completa, dati reali
- **Badge**: "Upcoming" (15 Dic 2025)
- **Contenuto**: Ricco, interattivo

## Differenze Strutturali

| Elemento | Locale | Riferimento | Priorità |
|----------|--------|-------------|----------|
| **Titolo H1** | "Event Title" | "Laravel 11 Release Pizza Party" | Alta |
| **Badge Stato** | "Past Event" (hardcoded?) | "Upcoming" (dinamico) | Alta |
| **Data** | Data odierna statica | "December 15, 2025" | Alta |
| **Orario** | Ora corrente | "6:00 PM - 9:00 PM" | Media |
| **Location** | "Location TBA" | "Tech Hub Downtown, 123 Main St" | Alta |
| **Mappa** | Assente | Interattiva (click to view) | Media |
| **Descrizione** | Assente | "Celebrate the release of Laravel 11..." | Alta |
| **Sezione Attendees** | Solo numero (0/100) | Lista nomi (5/30) + avatar | Bassa |
| **Immagini** | 0 | 6 immagini | Media |
| **CTA** | Link semplice | "Book Your Spot" button | Alta |
| **Breadcrumb** | Events / Event | Back to Events | Bassa |

## Requisiti per Raggiungere Parity

### 1. Dati Reali (Alta Priorità)
- Popolare il modello Event con dati reali
- Titolo: "Laravel 11 Release Pizza Party"
- Data: 15 Dicembre 2025
- Orario: 18:00 - 21:00
- Location: Tech Hub Downtown, 123 Main St
- Descrizione completa
- Capacità: 30 posti, 5 prenotati

### 2. Componenti Mancanti (Alta Priorità)
- [ ] Sezione "About This Event" con descrizione
- [ ] Sezione "Event Location" con indirizzo e mappa
- [ ] Sezione "Attendees" con lista partecipanti
- [ ] Badge stato dinamico (Upcoming/Past)
- [ ] Pulsante "Book Your Spot"

### 3. Visual Design (Media Priorità)
- [ ] Layout a due colonne (content + sidebar)
- [ ] Card per dettagli evento
- [ ] Avatar partecipanti
- [ ] Immagini evento
- [ ] Mappa interattiva

### 4. Interattività (Media Priorità)
- [ ] Form prenotazione spot
- [ ] Toggle mappa
- [ ] Carosello immagini

## Analisi Tecnica

### Modello Event
Il modello `Modules\Meetup\Models\Event` ha già:
- `toBlockArray()` per CMS compatibility
- Scope `upcoming()`, `past()`
- Attributo `slug` per SEO

Mancano probabilmente:
- Relazione `attendees()` (users)
- Campo `description` (testo lungo)
- Campo `location_address` (stringa)
- Campo `location_coordinates` (per mappa)
- Campo `max_attendees`

### Componente Blade
File: `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`

Deve supportare:
- Props: `event` (modello), `showMap` (bool), `showAttendees` (bool)
- Layout: header con immagine, content principale, sidebar
- Sezioni: About, Location, Attendees

### Folio Page
File: `Themes/Meetup/resources/views/pages/events/[slug].blade.php`

Deve:
- Risolvere l'evento via slug
- Passare dati al componente detail
- Gestire 404 se evento non trovato

## File Coinvolti

### Modulo Meetup
- `Modules/Meetup/app/Models/Event.php` - Aggiungere campi e relazioni
- `Modules/Meetup/database/migrations/` - Aggiungere colonne mancanti
- `Modules/Meetup/docs/events-dynamic-architecture.md` - Architettura

### Tema Meetup  
- `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php` - Layout
- `Themes/Meetup/resources/views/pages/events/[slug].blade.php` - Folio
- `Themes/Meetup/docs/replikate/event-detail-parity.md` - Questo file

## Prossimi Passi

1. Aggiornare migration Event con campi mancanti
2. Popolare dati reali dell'evento
3. Creare componente detail.blade.php completo
4. Aggiungere sezione Location con mappa
5. Aggiungere sezione Attendees
6. Implementare CTA "Book Your Spot"
7. Verificare responsive design
8. Test con PHPStan Level 10

## Collegamenti

- [Architettura Eventi](events-dynamic-architecture.md)
- [Folio Pages Rule](folio-pages-json-only-rule.md)
- Modulo: `Modules/Meetup/`
- Tema: `Themes/Meetup/`
