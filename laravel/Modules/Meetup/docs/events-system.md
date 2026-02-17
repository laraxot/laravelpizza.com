# 🎉 Sistema Gestione Eventi - LaravelPizza

## 📋 Panoramica

Il Sistema di Gestione Eventi permette alla community LaravelPizza di organizzare e promuovere eventi speciali per sviluppatori Laravel come:
- 🤝 Meetup per sviluppatori
- 🎓 Workshop e corsi di formazione
- 🎤 Conferenze e presentazioni
- 👨‍💻 Hackathon e coding sessions
- 🌐 Eventi online e virtuali

## 🏗️ Architettura Front Office

Il sistema utilizza un'architettura moderna con Laravel Folio + Volt per il front office:

- **Laravel Folio**: Routing basato su file (NO controllers/routes in web.php/api.php)
- **Laravel Volt**: Componenti dichiarativi per il front office
- **Filament**: Pannello admin e componenti UI per il back office
- **Principi**: DRY, KISS, SOLID, robust, Laraxot

## 📁 Struttura File per Front Office

```
/resources/views/
├── pages/                      # Pagine gestite da Laravel Folio
│   ├── events/                 # Gestione eventi
│   │   ├── index.blade.php     # Lista eventi - /events
│   │   ├── [event].blade.php   # Dettaglio evento - /events/{event}
│   │   └── create.blade.php    # Creazione evento - /events/create
│   ├── profile/
│   │   └── [user].blade.php    # Profilo utente - /profile/{user}
│   └── dashboard.blade.php     # Dashboard utente - /dashboard
├── components/                 # Componenti riutilizzabili
│   ├── event-card.blade.php    # Card evento
│   ├── event-calendar.blade.php # Calendario eventi
│   └── registration-form.blade.php # Form registrazione
    └── layouts/                    # Layout template
    └── app.blade.php
```

## Stato Attuale `/it/events` (Gap rispetto al design target)

- **Implementation Details**: See `events-page-implementation.md` for details on the dynamic data loading and configuration.
- **Rendering corrente**:
  - La route `/it/events` carica la configurazione da `events.json`.
  - Il componente `pub_theme::components.blocks.events.list` recupera i dati dinamicamente usando il modello `Event`.
- **Design target**
  - Il design di riferimento (statico `Themes/Meetup/resources/html/events.html` / laravelpizza.com/events) mostra:
    - Header "Upcoming Events" + sottotitolo.
    - Barra filtri (All Events / Upcoming / Past).
    - Griglia di card evento (con badge Upcoming/Past, data/ora, location, attendees).
- **Conseguenza**
  - A livello UX, la pagina `/it/events` oggi si comporta come una seconda homepage e non come indice eventi.
  - La prima milestone è introdurre un blocco dedicato alla lista eventi (header + filtri + grid), mappato in `events.json` verso una view tipo `pub_theme::components.blocks.events.index`, per poi in un secondo momento collegarlo ai modelli `Event`/`EventRegistration` descritti in questo documento.

## CMS Integration

Events can be dynamically displayed in CMS pages using the `events` block type. This integration leverages the `Event` model's custom scopes and formatting methods.

### Dynamic Block Configuration

To display events in a CMS page, configure the block in the page JSON:

```json
{
    "type": "events",
    "slug": "events-list",
    "data": {
        "view": "pub_theme::components.blocks.events.list",
        "title": "Upcoming Events",
        "description": "Join us for pizza and Laravel discussions",
        "query": {
            "model": "Modules\\Meetup\\Models\\Event",
            "scope": "upcoming",
            "orderBy": "start_date",
            "direction": "asc",
            "limit": 50
        }
    }
}
```

### Query Parameters

The `query` object supports the following parameters:

| Parameter | Type | Required | Description |
|-----------|------|----------|-------------|
| `model` | string | Yes | Fully qualified model class name |
| `scope` | string | No | Model scope to apply (`upcoming`, `past`, `filter`, etc.) |
| `orderBy` | string | No | Column to order by (`start_date`, `end_date`, `title`, `created_at`) |
| `direction` | string | No | Sort direction (`asc` or `desc`) |
| `limit` | integer | No | Maximum number of events to retrieve |

### Model Support

The `Event` model provides the following features for CMS integration:

- **Scopes**: `upcoming()`, `past()`, `filter()`, `orderBy()`, `limit()` for easy filtering.
- **Ordering**: `orderByStartDate()`, `orderByTitle()`, `orderByEndDate()`.
- **Retrieval**: `getBySlug()`, `getUpcomingOrderedByStartDate()`, `getWithOrderingAndLimit()`.
- **Formatting**: `toBlockArray()` transforms the model into a structure compatible with `Themes/Meetup/resources/views/components/blocks/events/list.blade.php`.
- **Dynamic Configuration**: The `events.json` file in `config/local/laravelpizza/database/content/pages/` defines the query parameters (model, scope, order, limit) which are passed to the component.

### SEO-Friendly URLs

The system uses **slugs** instead of IDs for event detail URLs:

- Event model has `getRouteKeyName()` returning `'slug'`
- Detail page at `/events/{slug}` is handled by `[slug].blade.php`
- The `toBlockArray()` method generates URLs using: `/it/events/{slug}`

Example:
```php
// In Event.php
public function toBlockArray(): array
{
    return [
        // ...
        'url' => $this->url ?? "/it/events/".(string) $this->slug,
    ];
}
```

### Customizing Display

The `toBlockArray()` method in `Modules\Meetup\Models\Event` controls what data is passed to the view. Key fields include:
- `status`: 'upcoming' or 'past' (used by Alpine.js filters).
- `date` & `time`: Pre-formatted strings for display.
- `attendees_current` & `attendees_max`: For capacity visualization.
- `url`: SEO-friendly URL with slug.

## 🛠️ Implementazione Volt per il Sistema Eventi

### Componente Registrazione Evento

```php
<?php

use Livewire\Volt\Component;
use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Event $event;
    public $registrationData = [
        'num_guests' => 1,
        'special_requests' => '',
    ];

    public function mount(Event $event)
    {
        $this->event = $event;
    }

    public function register()
    {
        if (!Auth::check()) {
            return $this->redirect(route('login', [
                'redirect' => request()->url()
            ]));
        }

        $this->validate([
            'registrationData.num_guests' => 'required|integer|min:1|max:10',
            'registrationData.special_requests' => 'nullable|string|max:500',
        ]);

        // Controllo se già registrato
        $existingRegistration = EventRegistration::where('event_id', $this->event->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingRegistration) {
            $this->addError('registration', 'Sei già registrato per questo evento.');
            return;
        }

        EventRegistration::create([
            'event_id' => $this->event->id,
            'user_id' => Auth::id(),
            'num_guests' => $this->registrationData['num_guests'],
            'special_requests' => $this->registrationData['special_requests'],
            'status' => 'confirmed',
        ]);

        $this->event->increment('current_attendees');

        $this->dispatch('registration-success',
            message: 'Registrazione completata con successo!',
            eventId: $this->event->id
        );
    }

    public function getIsRegisteredProperty()
    {
        if (!Auth::check()) {
            return false;
        }

        return EventRegistration::where('event_id', $this->event->id)
            ->where('user_id', Auth::id())
            ->exists();
    }
};
```

### Best Practices per Volt Components

- **Validazione**: Usa il metodo validate() per la validazione dei dati
- **Autorizzazione**: Controlla sempre le autorizzazioni utente
- **Gestione Errori**: Usa error bag per mostrare messaggi di errore
- **Performance**: Usa computed properties per operazioni costose
- **Sicurezza**: Sanitizza sempre i dati in input

### Warriorfolio Patterns for Event Management

**Modular Component Architecture:**
- Componenti riutilizzabili seguendo il sistema Saturn UI
- Architettura modulare per gestione flessibile degli eventi
- Page builder per layout personalizzabili degli eventi

**Advanced Features:**
- Ricerca avanzata con debouncing e filtraggio real-time
- Sistema di notifiche real-time per aggiornamenti eventi
- Integrazione con analytics (Google Analytics)
- Ottimizzazione query per performance

**SEO Optimization:**
- URL SEO-friendly per ogni evento
- Meta tags dinamici per miglior posizionamento
- Ottimizzazione immagini e lazy loading
- Query ottimizzate per velocità di caricamento

**Example: Event Search Component with Warriorfolio Patterns**
```php
<?php

use Livewire\Volt\Component;
use function Laravel\Volt\{state, computed};

new class extends Component {
    public $searchTerm = '';
    public $filters = [
        'category' => null,
        'location' => null,
        'dateRange' => null,
        'attendeeCount' => null
    ];

    public function mount()
    {
        $this->searchTerm = request('q', '');
        $this->filters = [
            'category' => request('category', null),
            'location' => request('location', null),
            'dateRange' => request('date_range', null),
            'attendeeCount' => request('attendees', null)
        ];
    }

    public function getEventsProperty()
    {
        return \App\Models\Event::with(['category', 'organizer', 'attendees'])
            ->where('status', 'published')
            ->when($this->searchTerm, function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('title', 'like', '%' . $this->searchTerm . '%')
                             ->orWhere('description', 'like', '%' . $this->searchTerm . '%')
                             ->orWhereHas('organizer', function ($q) {
                                 $q->where('name', 'like', '%' . $this->searchTerm . '%');
                             });
                });
            })
            ->when($this->filters['category'], function ($query) {
                $query->where('category_id', $this->filters['category']);
            })
            ->when($this->filters['location'], function ($query) {
                $query->where('venue_city', 'like', '%' . $this->filters['location'] . '%');
            })
            ->orderBy('start_datetime', 'asc')
            ->paginate(12);
    }

    public function searchUpdated()
    {
        $this->dispatch('events-search-updated');
    }
};
```

## 🎯 Obiettivi

1. **Aumentare il coinvolgimento della community di sviluppatori** attraverso eventi tecnici
2. **Favorire l'apprendimento e la crescita professionale** con workshop e conferenze
3. **Creare connessioni tra sviluppatori Laravel** per favorire lo scambio di conoscenze
4. **Promuovere la community** come punto di riferimento per sviluppatori PHP/Laravel

## 📊 Database Schema

### Tabella: `meetup_events`

```sql
CREATE TABLE meetup_events (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,

    -- Basic Info
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) UNIQUE NOT NULL,
    description TEXT,
    short_description VARCHAR(500),

    -- Scheduling
    start_datetime DATETIME NOT NULL,
    end_datetime DATETIME NOT NULL,
    timezone VARCHAR(50) DEFAULT 'Europe/Rome',

    -- Location
    location_type ENUM('in_person', 'online', 'hybrid') DEFAULT 'in_person',
    venue_name VARCHAR(255),
    venue_address TEXT,
    venue_city VARCHAR(100),
    venue_postal_code VARCHAR(20),
    venue_lat DECIMAL(10, 8),
    venue_lng DECIMAL(11, 8),
    online_meeting_url VARCHAR(500),

    -- Capacity & Registration
    capacity INT UNSIGNED,
    min_attendees INT UNSIGNED DEFAULT 1,
    current_attendees INT UNSIGNED DEFAULT 0,
    allow_waitlist BOOLEAN DEFAULT TRUE,
    registration_deadline DATETIME,

    -- Pricing
    is_paid BOOLEAN DEFAULT FALSE,
    price DECIMAL(10, 2) DEFAULT 0.00,
    currency VARCHAR(3) DEFAULT 'EUR',

    -- Status & Visibility
    status ENUM('draft', 'published', 'cancelled', 'completed', 'full') DEFAULT 'draft',
    is_featured BOOLEAN DEFAULT FALSE,
    is_recurring BOOLEAN DEFAULT FALSE,
    recurring_pattern JSON,

    -- Content
    image_url VARCHAR(500),
    gallery_images JSON,
    video_url VARCHAR(500),

    -- SEO
    meta_title VARCHAR(255),
    meta_description VARCHAR(500),
    meta_keywords VARCHAR(255),

    -- Relations
    category_id BIGINT UNSIGNED,
    organizer_id BIGINT UNSIGNED NOT NULL,

    -- Timestamps
    published_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    deleted_at TIMESTAMP NULL,

    INDEX idx_start_datetime (start_datetime),
    INDEX idx_status (status),
    INDEX idx_slug (slug),
    INDEX idx_category (category_id),
    INDEX idx_featured (is_featured),

    FOREIGN KEY (category_id) REFERENCES meetup_event_categories(id) ON DELETE SET NULL,
    FOREIGN KEY (organizer_id) REFERENCES users(id) ON DELETE CASCADE
);
```

### Tabella: `meetup_event_categories`

```sql
CREATE TABLE meetup_event_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    color VARCHAR(7) DEFAULT '#3B82F6', -- Hex color
    icon VARCHAR(50), -- Font Awesome icon class
    order_column INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_slug (slug),
    INDEX idx_order (order_column)
);
```

### Tabella: `meetup_event_registrations`

```sql
CREATE TABLE meetup_event_registrations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    event_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED,

    -- Guest Info (for non-registered users)
    guest_name VARCHAR(255),
    guest_email VARCHAR(255),
    guest_phone VARCHAR(50),

    -- Registration Details
    status ENUM('pending', 'confirmed', 'cancelled', 'attended', 'no_show', 'waitlist') DEFAULT 'pending',
    num_guests INT UNSIGNED DEFAULT 1,
    special_requests TEXT,

    -- Payment (if event is paid)
    payment_status ENUM('unpaid', 'paid', 'refunded') DEFAULT 'unpaid',
    payment_amount DECIMAL(10, 2),
    payment_method VARCHAR(50),
    payment_transaction_id VARCHAR(255),

    -- Check-in
    checked_in_at DATETIME,
    checked_in_by BIGINT UNSIGNED,

    -- Notifications
    confirmation_sent_at DATETIME,
    reminder_sent_at DATETIME,

    -- Timestamps
    registered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    cancelled_at DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_event (event_id),
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_guest_email (guest_email),

    FOREIGN KEY (event_id) REFERENCES meetup_events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (checked_in_by) REFERENCES users(id) ON DELETE SET NULL,

    UNIQUE KEY unique_user_event (event_id, user_id),
    UNIQUE KEY unique_guest_event (event_id, guest_email)
);
```

### Tabella: `meetup_event_reviews`

```sql
CREATE TABLE meetup_event_reviews (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    event_id BIGINT UNSIGNED NOT NULL,
    user_id BIGINT UNSIGNED NOT NULL,
    registration_id BIGINT UNSIGNED,

    rating INT UNSIGNED NOT NULL CHECK (rating BETWEEN 1 AND 5),
    title VARCHAR(255),
    comment TEXT,

    -- Photos
    photos JSON,

    -- Moderation
    is_approved BOOLEAN DEFAULT FALSE,
    approved_at DATETIME,
    approved_by BIGINT UNSIGNED,

    -- Helpful votes
    helpful_count INT UNSIGNED DEFAULT 0,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    INDEX idx_event (event_id),
    INDEX idx_user (user_id),
    INDEX idx_approved (is_approved),

    FOREIGN KEY (event_id) REFERENCES meetup_events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (registration_id) REFERENCES meetup_event_registrations(id) ON DELETE SET NULL,

    UNIQUE KEY unique_user_event_review (event_id, user_id)
);
```

## 🎨 Categorie Eventi Predefinite

### 1. 🤝 Laravel Meetups
- **Nome**: Laravel Meetups
- **Slug**: `laravel-meetups`
- **Color**: `#DC2626` (rosso Laravel)
- **Descrizione**: Incontri settimanali per sviluppatori Laravel
- **Esempi**: "Laravel Best Practices", "Code Review Session"

### 2. 🎓 Workshop
- **Nome**: Workshop
- **Slug**: `workshops`
- **Color**: `#F59E0B` (giallo formazione)
- **Descrizione**: Corsi pratici e formativi per sviluppatori
- **Esempi**: "Laravel Testing Workshop", "Advanced Eloquent"

### 3. 🎤 Conferences
- **Nome**: Conferences
- **Slug**: `conferences`
- **Color**: `#8B5CF6` (viola)
- **Descrizione**: Eventi principali con speaker esperti
- **Esempi**: "Laravel Innovation Summit", "Annual Conference"

### 4. 👨‍💻 Hackathons
- **Nome**: Hackathons
- **Slug**: `hackathons`
- **Color**: `#10B981` (verde coding)
- **Descrizione**: Eventi di coding intensivi e collaborativi
- **Esempi**: "24h Laravel Challenge", "Open Source Sprint"

### 5. 🌐 Virtual Events
- **Nome**: Virtual Events
- **Slug**: `virtual-events`
- **Color**: `#EC4899` (rosa online)
- **Descrizione**: Eventi online e webinar
- **Esempi**: "Remote Laravel Meetup", "Online Workshop"

### 6. 🏢 Corporate Events
- **Nome**: Corporate Events
- **Slug**: `corporate-events`
- **Color**: `#7C3AED` (viola scuro)
- **Descrizione**: Eventi aziendali e training
- **Esempi**: "Team Building Tech", "Company Workshop"

## 📱 Funzionalità Frontend

### Pagina Lista Eventi (`/events`)

**Layout:**
- Header con titolo e filtri
- Filtri per:
  - Categoria
  - Data (Oggi, Questo weekend, Questa settimana, Questo mese, Personalizzato)
  - Tipo (In presenza, Online, Ibrido)
  - Prezzo (Gratuiti, A pagamento)
  - Status (Posti disponibili, Sold out)
- Grid di card eventi (responsive 1-2-3 colonne)
- Paginazione

**Event Card:**
```html
- Immagine evento (16:9)
- Badge categoria (colored)
- Badge status (Featured, Sold Out, Last Seats, etc.)
- Titolo evento
- Data e ora (icona calendario)
- Location (icona pin)
- Prezzo (se a pagamento)
- Numero posti disponibili
- Pulsante "Maggiori Info" / "Registrati"
```

### Pagina Dettaglio Evento (`/events/{slug}`)

**Sezioni:**

1. **Hero Section**
   - Immagine grande
   - Titolo evento
   - Data/ora completa
   - Location con mappa
   - Badge categoria e status
   - Pulsante CTA grande "Registrati Ora"

2. **Info Event**
   - Descrizione completa
   - Cosa include
   - Cosa portare
   - Durata
   - Capacità (X posti rimanenti su Y totali)

3. **Dettagli Pratici**
   - 📅 Data e orario
   - 📍 Luogo (indirizzo completo)
   - 🎫 Prezzo e cosa include
   - 👥 Posti disponibili
   - ⏰ Deadline registrazione

4. **Organizzatore**
   - Nome
   - Foto
   - Bio breve
   - Altri eventi organizzati

5. **Form Registrazione** (sidebar o sezione)
   - Nome e cognome
   - Email
   - Telefono
   - Numero ospiti
   - Note/Richieste speciali
   - Checkbox privacy
   - Pulsante "Conferma Registrazione"

6. **Gallery** (se disponibile)
   - Foto dell'evento o eventi simili passati

7. **Recensioni** (eventi passati)
   - Rating medio
   - Commenti partecipanti
   - Foto caricate da utenti

8. **Eventi Simili**
   - 3 card di eventi correlati

### Pagina Calendario (`/events/calendar`)

**Features:**
- Vista mensile/settimanale/giornaliera
- Eventi colorati per categoria
- Click su evento → modal con dettagli
- Filtri categoria nella sidebar
- Legenda colori categorie

### Dashboard Utente - Sezione Eventi

**I Miei Eventi:**
- Tab "In Arrivo"
- Tab "Passati"
- Tab "Cancellati"

**Card Registrazione:**
- Nome evento
- Data
- Status registrazione (Confermata, In Attesa, Waitlist)
- QR Code per check-in
- Pulsanti: "Dettagli", "Cancella", "Aggiungi al Calendario"

## ⚙️ Funzionalità Backend (Admin)

### Filament Resources

#### EventResource

**Lista Eventi:**
- Colonne: Titolo, Categoria, Data, Status, Posti (X/Y), Azioni
- Filtri: Categoria, Status, Data, Featured
- Bulk Actions: Pubblica, Cancella, Duplica
- Stats widgets:
  - Eventi questo mese
  - Partecipanti totali
  - Revenue eventi
  - Tasso riempimento medio

**Form Creazione/Edit Evento:**

**Tab 1: Informazioni Base**
- Titolo
- Slug (auto-generated)
- Categoria
- Descrizione breve (max 500 char)
- Descrizione completa (WYSIWYG)
- Immagine principale
- Gallery immagini

**Tab 2: Data e Luogo**
- Data inizio (datetime picker)
- Data fine (datetime picker)
- Timezone
- Tipo evento (In persona/Online/Ibrido)
- Nome venue
- Indirizzo completo
- Città, CAP
- Coordinate (map picker)
- URL meeting online

**Tab 3: Registrazione**
- Capacità massima
- Min partecipanti
- Allow waitlist
- Deadline registrazione
- È a pagamento?
- Prezzo
- Valuta

**Tab 4: Visibilità & SEO**
- Status (Draft/Published/Cancelled/Completed)
- Featured
- Data pubblicazione
- Ricorrente (con pattern)
- Meta title
- Meta description
- Keywords

#### EventRegistrationResource

**Lista Registrazioni:**
- Filtri: Evento, Status, Data registrazione
- Colonne: Nome, Email, Evento, Status, N° ospiti, Data registrazione
- Azioni: Conferma, Cancella, Check-in, Invia reminder

**Dettaglio Registrazione:**
- Info partecipante
- Info evento
- Status pagamento
- Note speciali
- Timeline (registrato, confermato, checked-in)
- Azioni admin

#### EventCategoryResource

**CRUD Categorie:**
- Nome
- Slug
- Descrizione
- Colore
- Icona
- Ordine
- Attiva/Disattiva

### Widget Dashboard Admin

1. **Upcoming Events Widget**
   - Lista prossimi 5 eventi
   - Quick actions

2. **Registrations Overview**
   - Grafico registrazioni ultimi 30 giorni
   - By category

3. **Revenue Widget**
   - Total revenue eventi a pagamento
   - Trend

4. **Capacity Tracker**
   - Eventi vicini al sold out
   - Alert eventi sotto min capacity

## 🔔 Sistema Notifiche

### Email Notifications

1. **EventRegistrationConfirmation**
   - Trigger: Dopo registrazione completata
   - Contenuto:
     - Conferma registrazione
     - Dettagli evento (data, ora, luogo)
     - QR code ticket
     - Aggiungi al calendario (iCal link)
     - Istruzioni partecipazione

2. **EventReminder**
   - Trigger: 24h prima evento
   - Contenuto:
     - Reminder evento domani
     - Dettagli pratici
     - Indicazioni stradali
     - Contatti organizzatore

3. **EventCancellationNotification**
   - Trigger: Admin cancella evento
   - Contenuto:
     - Avviso cancellazione
     - Motivo (se fornito)
     - Info rimborso se pagato
     - Eventi simili suggeriti

4. **EventUpdateNotification**
   - Trigger: Modifiche importanti (data, luogo)
   - Contenuto:
     - Cosa è cambiato
     - Nuovi dettagli
     - Opzione cancellazione se non va più bene

5. **WaitlistPromotionNotification**
   - Trigger: Posto liberato, utente promosso da waitlist
   - Contenuto:
     - Buona notizia! Posto disponibile
     - Deadline conferma
     - Link conferma registrazione

### Admin Notifications

1. **NewRegistrationNotification**
   - Trigger: Nuova registrazione
   - Recipient: Organizzatore evento
   - Contenuto: Info partecipante, posti rimanenti

2. **EventFullNotification**
   - Trigger: Evento sold out
   - Recipient: Organizzatore + admin
   - Contenuto: Evento completo, X persone in waitlist

3. **LowAttendanceAlert**
   - Trigger: 7 giorni prima, se sotto min capacity
   - Recipient: Organizzatore
   - Contenuto: Alert pochi iscritti, suggerimenti promozione

## 📈 Analytics & Reporting

### Metriche Chiave

**Event Performance:**
- Tasso di riempimento (% capacity)
- Tempo medio registrazione (da pubblicazione a sold out)
- Cancellation rate
- No-show rate
- Revenue per evento
- Partecipanti medi per evento

**Category Performance:**
- Eventi per categoria
- Popolarità categorie (registrazioni)
- Revenue per categoria

**User Engagement:**
- Utenti con più registrazioni
- Retention rate (% utenti che partecipano a 2+ eventi)
- Review rate (% partecipanti che lasciano recensione)
- Average rating per evento

### Reports Disponibili

1. **Monthly Events Report**
   - Eventi organizzati
   - Partecipanti totali
   - Revenue
   - Trend vs mese precedente

2. **Category Analysis**
   - Performance per categoria
   - Crescita/Declino

3. **Attendee Report**
   - Lista partecipanti per evento
   - Export CSV
   - Info contatto

## 🎨 Design Guidelines

### Colori Eventi

Usa i colori delle categorie per i badge e accenti, ma mantieni:
- **Primary Action**: Rosso Laravel (#DC2626)
- **Background**: Grigio chiaro (#F9FAFB)
- **Text**: Grigio scuro (#111827)

### Typography

- **Event Titles**: Poppins Bold, 2xl-4xl
- **Date/Time**: Inter Medium, con icone
- **Descriptions**: Inter Regular, leading-relaxed

### Spacing

- **Cards**: p-6, rounded-2xl
- **Sections**: py-12 md:py-20
- **Grid Gap**: gap-6 md:gap-8

### Componenti Riutilizzabili

```html
<!-- Event Card Component -->
<div class="event-card bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-shadow">
    <!-- Image -->
    <!-- Category Badge -->
    <!-- Content -->
    <!-- Footer with CTA -->
</div>

<!-- Event Date Badge -->
<div class="event-date-badge inline-flex items-center gap-2 px-4 py-2 bg-primary-50 rounded-full">
    <svg class="w-5 h-5 text-primary-600"><!-- Calendar icon --></svg>
    <span class="text-sm font-medium text-primary-700">Sab 15 Dic, 19:00</span>
</div>

<!-- Capacity Indicator -->
<div class="capacity-indicator flex items-center gap-2">
    <div class="flex-1 bg-gray-200 rounded-full h-2">
        <div class="bg-primary-500 h-2 rounded-full" style="width: 75%"></div>
    </div>
    <span class="text-sm text-gray-600">15/20 posti</span>
</div>
```

## 🔐 Permissions & Policies

### Permissions

- `view_events` - Vedere eventi pubblicati
- `view_any_event` - Vedere tutti gli eventi (admin)
- `create_event` - Creare eventi
- `update_event` - Modificare propri eventi
- `update_any_event` - Modificare qualsiasi evento (admin)
- `delete_event` - Eliminare propri eventi
- `delete_any_event` - Eliminare qualsiasi evento (admin)
- `manage_registrations` - Gestire registrazioni propri eventi
- `manage_any_registrations` - Gestire tutte le registrazioni (admin)

### Ruoli

**Guest (Non autenticato):**
- Vedere eventi pubblicati
- Registrarsi come guest (fornendo email)

**User (Autenticato):**
- Tutto quanto Guest
- Registrarsi con account
- Vedere proprie registrazioni
- Cancellare proprie registrazioni
- Lasciare recensioni eventi a cui ha partecipato

**Organizer:**
- Tutto quanto User
- Creare eventi
- Modificare propri eventi
- Vedere registrazioni propri eventi
- Check-in partecipanti
- Inviare comunicazioni ai partecipanti

**Admin:**
- Accesso completo a tutto
- Gestione categorie
- Moderazione recensioni
- Analytics complete

## 🚀 Implementation Roadmap

### Phase 1: Foundation (Sprint 1-2)
- ✅ Database migrations
- ✅ Models & relationships
- ✅ Seeders con dati esempio
- ✅ Basic CRUD admin (Filament)

### Phase 2: Frontend Public (Sprint 3-4)
- ✅ Lista eventi page
- ✅ Dettaglio evento page
- ✅ Form registrazione
- ✅ Email confirmations

### Phase 3: Calendar & Advanced (Sprint 5-6)
- ✅ Calendar view
- ✅ Filtri avanzati
- ✅ Recurring events
- ✅ Waitlist management

### Phase 4: Payments & Reviews (Sprint 7-8)
- ✅ Stripe integration per eventi a pagamento
- ✅ Sistema recensioni
- ✅ Photo upload reviews
- ✅ Rating system

### Phase 5: Optimization (Sprint 9-10)
- ✅ SEO optimization
- ✅ Analytics dashboard
- ✅ Performance tuning
- ✅ User dashboard enhancements

## 📋 Checklist Implementazione

- [ ] Migrations create
- [ ] Models create
- [ ] Factories & Seeders
- [ ] Filament Resources (Event, Registration, Category)
- [ ] Actions (Create, Update, Register, Cancel)
- [ ] Policies
- [ ] Web routes
- [ ] Controllers
- [ ] Frontend views (list, detail, calendar)
- [ ] Email notifications
- [ ] Tests (Unit, Feature)
- [ ] Documentation

## 🔗 Integration Points

### Existing Modules

- **User Module**: Authentication, user profiles
- **Notify Module**: Email/SMS notifications
- **Media Module**: Image uploads
- **Payment Module**: Stripe integration for paid events
- **Geo Module**: Maps and location
- **Cms Module**: Content pages
- **Seo Module**: Meta tags, sitemap

### External Services

- **Google Calendar API**: Add to calendar functionality
- **Google Maps API**: Venue location display
- **Zoom API** (optional): Auto-create meetings for online events
- **MailChimp** (optional): Sync attendees to email lists

## 📖 User Stories

### As a Customer
1. Voglio vedere tutti gli eventi disponibili
2. Voglio filtrare eventi per categoria e data
3. Voglio registrarmi ad un evento
4. Voglio ricevere conferma via email
5. Voglio vedere i miei eventi nel mio profilo
6. Voglio cancellare la mia registrazione
7. Voglio lasciare una recensione dopo l'evento

### As an Organizer
1. Voglio creare un nuovo evento
2. Voglio vedere chi si è registrato
3. Voglio inviare comunicazioni ai partecipanti
4. Voglio fare check-in dei partecipanti
5. Voglio vedere statistiche del mio evento

### As an Admin
1. Voglio moderare tutti gli eventi
2. Voglio vedere analytics complete
3. Voglio gestire le categorie
4. Voglio moderare le recensioni
5. Voglio vedere il revenue totale

---

**Versione:** 1.0
**Data:** 27 Novembre 2025
**Status:** 📝 Planning - Ready for Implementation
