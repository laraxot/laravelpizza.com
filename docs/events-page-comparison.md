# Confronto Pagina Events: Locale vs Originale

**Screenshot**: `docs/screenshots/local-events/` e `docs/screenshots/original-events/`

---

## Stato Attuale

### Locale (`/it/events`) - ROTTO

La pagina mostra un errore:
```
View not found: pub_theme::components.blocks.events.list
```

Il file Blade `components/blocks/events/list.blade.php` non esiste nel tema Meetup.
Dopo l'errore viene mostrato solo il footer.

### Originale (`laravelpizza.com/events`) - FUNZIONANTE

Pagina completa con:
- Header: "Upcoming Events" + subtitle "Join us for pizza and Laravel discussions"
- Filtri: "All Events" | "Upcoming" | "Past Events" (pill buttons)
- Grid 3 colonne con event cards
- 5 eventi di esempio con:
  - Immagine placeholder
  - Badge status (Upcoming/Past, verde/grigio)
  - Titolo evento
  - Descrizione troncata
  - Data (icona calendario)
  - Orario (icona orologio)
  - Location (icona pin)
  - Attendees count (es. "5 / 30 attendees")
- Footer standard

---

## Cosa Manca per Avere Parita'

### 1. Creare il componente Blade (CRITICO)

File da creare: `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`

Deve renderizzare:
- Titolo sezione ("Upcoming Events")
- Filtri (All / Upcoming / Past)
- Grid di event cards

### 2. Creare/verificare il JSON della pagina events

File: `config/local/laravelpizza/database/content/pages/events.json`

Deve definire i content_blocks con view `pub_theme::components.blocks.events.list`

### 3. Dati eventi

L'originale ha 5 eventi di esempio. Serve:
- Modello Event con dati (title, description, start_date, end_date, location, max_attendees)
- Seed data o JSON fixtures
- Oppure: dati hardcoded nel componente come placeholder iniziale

### 4. Event Card Component

Ogni card ha:

| Elemento | Dettaglio |
|----------|-----------|
| Immagine | Placeholder con overlay |
| Badge | "Upcoming" (verde) o "Past" (grigio) |
| Titolo | Bold, bianco |
| Descrizione | Troncata a ~2 righe, grigio |
| Data | Icona calendario + data formattata |
| Orario | Icona orologio + range orario |
| Location | Icona pin + indirizzo |
| Attendees | Icona persone + "X / Y attendees" |

---

## Eventi di Esempio dall'Originale

1. **Laravel 11 Release Pizza Party** - Dec 15, 2025, 6-9 PM, Tech Hub Downtown, 5/30 att.
2. **Filament Admin Panel Workshop** - Dec 22, 2025, 5:30-8:30 PM, Innovation Center, 3/25 att.
3. **Livewire 3 Pizza Meetup** - Jan 5, 2026, 6:30-9 PM, Startup Lounge, 2/35 att.
4. **Laravel Beginner's Pizza Night** - Nov 20, 2025, 6-8:30 PM, Community Center, 2/20 att. (Past)
5. **Laravel Testing Best Practices** - Jan 12, 2026, 7-9:30 PM, Developer Hub, 2/28 att.

---

## Roadmap Implementazione

### Step 1: Creare events.json (se non esiste)

```json
{
    "slug": "events",
    "title": {"it": "Eventi Laravel Pizza", "en": "Laravel Pizza Events"},
    "content_blocks": {
        "it": [
            {
                "type": "events",
                "slug": "events-list",
                "data": {
                    "view": "pub_theme::components.blocks.events.list",
                    "title": "Prossimi Eventi",
                    "subtitle": "Unisciti a noi per pizza e discussioni su Laravel"
                }
            }
        ]
    }
}
```

### Step 2: Creare il componente Blade events/list

Il componente deve:
1. Ricevere props dal JSON (title, subtitle)
2. Caricare gli eventi dal modello Event (o da JSON fixtures)
3. Renderizzare filtri + grid di cards
4. Essere responsive (3 col desktop, 2 tablet, 1 mobile)

### Step 3: Creare event card component

File: `components/blocks/events/card.blade.php`
- Riceve un singolo evento come prop
- Renderizza immagine, badge, titolo, descrizione, metadata

### Step 4: Seed data

Creare JSON fixtures o seeder con almeno 5 eventi di esempio simili all'originale.

### Step 5: Traduzioni

Le stringhe dell'UI devono usare `trans('pub_theme::events.*')`:
- `pub_theme::events.upcoming` = "Prossimi Eventi" / "Upcoming Events"
- `pub_theme::events.all` = "Tutti gli Eventi" / "All Events"
- `pub_theme::events.past` = "Eventi Passati" / "Past Events"
- `pub_theme::events.attendees` = "partecipanti" / "attendees"
- `pub_theme::events.subtitle` = "Unisciti a noi per pizza e discussioni su Laravel"

### Step 6: Schema.org

Ogni event card dovrebbe includere markup JSON-LD con:
- `@type`: "Event"
- `name`, `description`, `startDate`, `endDate`
- `location` con `@type: Place`
- `organizer` con `@type: Organization`
- `offers` con `@type: Offer` (price: 0 per eventi gratuiti)
- `eventAttendanceMode`: "OfflineEventAttendanceMode" o "MixedEventAttendanceMode"
- `eventStatus`: "EventScheduled"

---

## Differenze Footer (conferma)

Il footer dell'originale sulla pagina events conferma:
- 3 colonne: Brand + social | Quick Links | Community
- Quick Links: Events, Community Chat, Dashboard
- Community: About Us, Code of Conduct, Contact
- Social: GitHub, Twitter (2 icone)
- "Made with heart for the Laravel community"
