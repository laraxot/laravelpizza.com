# Pixel Parity Analysis - Events Pages

## Screenshots Captured

### Events List Page
| Versione | URL | Stato |
|----------|-----|-------|
| Locale | http://127.0.0.1:8000/it/events | Eventi caricati dinamicamente dal modello |
| Riferimento | https://laravelpizza.com/events | Eventi con dati completi e design ricco |

### Event Detail Page
| Versione | URL | Stato |
|----------|-----|-------|
| Locale | http://127.0.0.1:8000/it/events/laravel-11-release-pizza-party | Struttura base presente, contenuti placeholder |
| Riferimento | https://laravelpizza.com/events/1 | Design completo con tutte le sezioni |

## Analisi Comparativa Dettagliata

### Events List Page - Gap Analysis

| Elemento | Locale | Riferimento | Gap |
|----------|--------|-------------|-----|
| **Header** | Titolo "Upcoming Events" + descrizione | Stesso, ma con styling più ricco | Minimo |
| **Filtri** | 3 pulsanti (All, Upcoming, Past) con Alpine.js | Identici | Nessuno |
| **Grid Eventi** | Card base con placeholder immagine | Card con immagini reali | Medio |
| **Card Content** | Titolo, data, ora, location, attendees | Stessi campi, più styling | Minimo |
| **Badge Stato** | "Upcoming"/"Past" colorati | Identici | Nessuno |
| **URL Detail** | `/events/{slug}` - corretto | `/events/{id}` - usa ID | Locale migliore per SEO |
| **Empty State** | Presente con icona | Non visibile (ci sono eventi) | - |

### Event Detail Page - Gap Analysis Critica

#### Header/Hero Section
| Elemento | Locale | Riferimento | Priorità |
|----------|--------|-------------|----------|
| **Cover Image** | Placeholder icona generica | Immagine evento reale o gradiente | Alta |
| **Titolo H1** | "Event Title" (placeholder) | "Laravel 11 Release Pizza Party" | Alta |
| **Badge Stato** | "Upcoming"/"Past" | Identico ma posizionato meglio | Media |
| **Back Link** | "Back to all events" | "Back to Events" | Minima |

#### Info Bar (Locale Presente, Riferimento Simile)
| Elemento | Locale | Riferimento | Stato |
|----------|--------|-------------|-------|
| **Data** | Formato: "February 17, 2026" | "Tuesday, February 17, 2026" | OK |
| **Orario** | "9:11 PM - 9:11 PM" | "6:00 PM - 9:00 PM" | Dati da popolare |
| **Location** | "Location TBA" | "Tech Hub Downtown, 123 Main St" | Dati da popolare |

#### Sezioni Mancanti nel Locale

| Sezione | Riferimento | Priorità | Implementazione |
|---------|-------------|----------|-----------------|
| **About This Event** | Blocco con descrizione dettagliata | Alta | Aggiungere in detail.blade.php |
| **Event Location** | Indirizzo + mappa interattiva | Alta | Aggiungere sezione con mappa |
| **Attendees** | Lista avatar + nomi (5/30) | Media | Aggiungere relazione attendees |
| **Sidebar CTA** | Card "25 Available Spots" + "Book Your Spot" | Alta | Aggiungere layout 2 colonne |
| **Share Event** | Pulsanti Twitter/LinkedIn | Bassa | Aggiungere sezione share |

## Implementazione Necessaria

### 1. Popolamento Dati Reali

Il database ha già 10 eventi. Verificare che abbiano:
- [ ] `title` reale (non "Event Title")
- [ ] `description` completa
- [ ] `start_date` e `end_date` corretti
- [ ] `location` con indirizzo completo
- [ ] `cover_image` opzionale
- [ ] `attendees_count` e `max_attendees`

### 2. Modifiche Componente detail.blade.php

```php
// Aggiungere in Themes/Meetup/resources/views/components/blocks/events/detail.blade.php

// 1. Layout a 2 colonne (lg:grid-cols-3)
// 2. Sidebar sticky con CTA card
// 3. Sezione "About This Event" prominente
// 4. Sezione "Event Location" con placeholder mappa
// 5. Sezione "Attendees" con avatar griglia
// 6. Sezione "Share Event" con social buttons
```

### 3. Relazione Attendees (Modello)

Aggiungere in `Modules/Meetup/Models/Event.php`:
```php
public function attendees(): BelongsToMany
{
    return $this->belongsToManyX(User::class, 'event_attendee')
        ->withTimestamps();
}
```

### 4. Migration Event Attendee

```php
Schema::create('event_attendee', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained()->onDelete('cascade');
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('status')->default('registered'); // registered, attended, cancelled
    $table->timestamp('registered_at');
    $table->timestamps();
});
```

## Stato Attuale Sistema

### Architettura - Completa
- [x] Modello Event con toBlockArray()
- [x] Scope upcoming(), past(), bySlug()
- [x] Pagina Folio [slug].blade.php con Volt
- [x] Componente list.blade.php con Alpine.js
- [x] Componente detail.blade.php base
- [x] Query dinamica in events.json
- [x] 10 eventi nel database

### Contenuti - Da Arricchire
- [ ] Dati reali eventi popolati
- [ ] Sezione About dettagliata
- [ ] Sezione Location con mappa
- [ ] Sezione Attendees con relazione
- [ ] Sidebar CTA Book Your Spot
- [ ] Immagini evento

## Prossimi Passi

1. **Verificare dati eventi nel database**
2. **Aggiornare detail.blade.php con layout 2 colonne**
3. **Aggiungere sezioni mancanti (About, Location, Attendees)**
4. **Implementare sidebar CTA**
5. **Aggiungere relazione attendees se necessario**
6. **Testare responsive e PHPStan Level 10**

## File Coinvolti

- `Themes/Meetup/resources/views/components/blocks/events/detail.blade.php`
- `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`
- `Themes/Meetup/resources/views/pages/events/[slug].blade.php`
- `Modules/Meetup/Models/Event.php`
- `Modules/Meetup/database/migrations/` (eventuale nuova migration)

## Collegamenti

- [Documentazione Tecnica](../../Modules/Meetup/docs/event-detail-technical.md)
- [Prompt Originale](../../Modules/Meetup/docs/prompts/events.txt)
- Modulo: `Modules/Meetup/`
- Tema: `Themes/Meetup/`
