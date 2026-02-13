# Schema.org Enhancement Proposal - Meetup Module

**Filosofia**: DRY + KISS + SEO + Structured Data
**Obiettivo**: Migliorare SEO e structured data seguendo schema.org

---

## 🎯 Analisi Schema.org per Modelli Esistenti

### 1. Event Model - Campi Aggiuntivi Proposti

#### Schema.org Event Properties
Basato su [schema.org/Event](https://schema.org/Event), propongo i seguenti campi aggiuntivi:

```php
// Campi da aggiungere al modello Event
protected $fillable = [
    // ... campi esistenti ...

    // Schema.org Event properties
    'event_status',              // EventStatusType: Scheduled, Postponed, Cancelled, MovedOnline
    'event_attendance_mode',     // EventAttendanceMode: OfflineEventAttendanceMode, OnlineEventAttendanceMode, MixedEventAttendanceMode
    'organizer_name',            // Text - Nome organizzatore
    'organizer_email',           // Email - Email organizzatore
    'organizer_url',             // URL - Sito organizzatore
    'event_schedule',            // JSON - Schedule con startDate, endDate, repeatFrequency
    'maximum_attendee_capacity', // Integer - già presente come max_attendees
    'remaining_attendee_capacity', // Integer - calcolato
    'previous_start_date',       // DateTime - per eventi spostati
    'super_event',               // Event ID - per eventi parte di serie
    'sub_event',                 // JSON - Array di eventi subordinati
    'about',                     // Text - Descrizione dettagliata (già presente come description)
    'audience',                  // JSON - Tipo di audience (Public, Members, etc.)
    'in_language',               // Text - Lingua evento (it, en, etc.)
    'is_accessible_for_free',   // Boolean - Evento gratuito
    'offers',                    // JSON - Offerte biglietti (price, priceCurrency, availability)
    'performer',                 // JSON - Array performer (name, type: Person/Organization)
    'location_name',            // Text - Nome location (già presente come location)
    'location_address',          // JSON - Address completo (streetAddress, addressLocality, postalCode, addressCountry)
    'location_geo',              // JSON - Coordinate geografiche (latitude, longitude)
    'image',                     // URL/JSON - Immagini evento (già presente come cover_image)
    'same_as',                   // JSON - Array URL social (Facebook, Twitter, etc.)
    'url',                       // URL - URL evento pubblico
    'typical_age_range',         // Text - Fascia età target
    'work_featured',             // JSON - Lavori/opere presentate
    'aggregate_rating',          // JSON - Rating aggregato (ratingValue, reviewCount)
    'review',                    // JSON - Array recensioni
];
```

#### Migrazione Proposta
```php
// database/migrations/XXXX_XX_XX_XXXXXX_add_schema_org_fields_to_events_table.php
public function tableUpdate(): void
{
    if (!$this->hasColumn('events', 'event_status')) {
        $this->table('events', function (Blueprint $table) {
            $table->string('event_status')->default('EventScheduled')->after('status');
            $table->string('event_attendance_mode')->nullable()->after('event_status');
            $table->string('organizer_name')->nullable()->after('event_attendance_mode');
            $table->string('organizer_email')->nullable()->after('organizer_name');
            $table->string('organizer_url')->nullable()->after('organizer_email');
            $table->json('event_schedule')->nullable()->after('organizer_url');
            $table->integer('remaining_attendee_capacity')->nullable()->after('max_attendees');
            $table->dateTime('previous_start_date')->nullable()->after('start_date');
            $table->string('super_event_id')->nullable()->after('previous_start_date');
            $table->json('sub_events')->nullable()->after('super_event_id');
            $table->json('audience')->nullable()->after('description');
            $table->string('in_language')->default('it')->after('audience');
            $table->boolean('is_accessible_for_free')->default(false)->after('in_language');
            $table->json('offers')->nullable()->after('is_accessible_for_free');
            $table->json('performer')->nullable()->after('offers');
            $table->string('location_name')->nullable()->after('location');
            $table->json('location_address')->nullable()->after('location_name');
            $table->json('location_geo')->nullable()->after('location_address');
            $table->json('same_as')->nullable()->after('cover_image');
            $table->string('url')->nullable()->after('same_as');
            $table->string('typical_age_range')->nullable()->after('url');
            $table->json('work_featured')->nullable()->after('typical_age_range');
            $table->json('aggregate_rating')->nullable()->after('work_featured');
            $table->json('review')->nullable()->after('aggregate_rating');

            $table->foreign('super_event_id')->references('id')->on('events')->onDelete('set null');
            $table->index('event_status');
            $table->index('event_attendance_mode');
            $table->index('is_accessible_for_free');
        });
    }
}
```

---

### 2. User Model (Person) - Campi Aggiuntivi Proposti

#### Schema.org Person Properties
Basato su [schema.org/Person](https://schema.org/Person):

```php
// Campi da aggiungere al modello User (Person)
protected $fillable = [
    // ... campi esistenti ...

    // Schema.org Person properties
    'additional_name',            // Text - Nome aggiuntivo
    'family_name',               // Text - Cognome (già presente come last_name)
    'given_name',                // Text - Nome (già presente come first_name)
    'honorific_prefix',          // Text - Titolo (Dr., Prof., etc.)
    'honorific_suffix',          // Text - Suffisso (Jr., Sr., etc.)
    'job_title',                 // Text - Titolo lavorativo
    'works_for',                 // JSON - Organizzazione per cui lavora
    'alumni_of',                 // JSON - Scuole/Università frequentate
    'knows_about',               // JSON - Competenze/conoscenze
    'knows_language',            // JSON - Lingue conosciute
    'nationality',               // Text - Nazionalità
    'birth_place',               // JSON - Luogo di nascita (address)
    'birth_date',                // Date - Data di nascita
    'death_date',                // Date - Data di morte (per profili storici)
    'award',                     // JSON - Array premi/riconoscimenti
    'same_as',                   // JSON - Array URL social (LinkedIn, Twitter, GitHub, etc.)
    'url',                       // URL - URL profilo pubblico
    'image',                     // URL/JSON - Immagini profilo (già presente come profile_photo_path)
    'address',                   // JSON - Indirizzo completo
    'telephone',                 // Text - Telefono
    'fax_number',                // Text - Fax
    'email',                     // Email - già presente
    'home_location',             // JSON - Luogo di residenza
    'work_location',             // JSON - Luogo di lavoro
];
```

---

## 🆕 Nuovi Modelli Proposti

### 1. Organization Model

Per gestire organizzatori di eventi, sponsor, partner:

```php
// Modules/Meetup/app/Models/Organization.php
class Organization extends BaseModel
{
    protected $fillable = [
        'name',                   // Text - Nome organizzazione
        'legal_name',             // Text - Ragione sociale
        'url',                    // URL - Sito web
        'logo',                   // URL/JSON - Logo
        'image',                  // URL/JSON - Immagini
        'description',            // Text - Descrizione
        'email',                  // Email - Email contatto
        'telephone',              // Text - Telefono
        'fax_number',             // Text - Fax
        'address',                // JSON - Indirizzo completo
        'geo',                    // JSON - Coordinate geografiche
        'founding_date',          // Date - Data fondazione
        'founders',               // JSON - Array founder (Person)
        'number_of_employees',   // Integer - Numero dipendenti
        'slogan',                 // Text - Slogan
        'same_as',                // JSON - Array URL social
        'contact_point',          // JSON - Punti di contatto
        'area_served',            // JSON - Aree servite
        'service_type',           // Text - Tipo servizio
        'brand',                  // JSON - Brand associati
        'parent_organization',    // Organization ID - Organizzazione madre
        'sub_organization',       // JSON - Array organizzazioni figlie
        'member_of',              // JSON - Membership in altre organizzazioni
        'award',                  // JSON - Premi/riconoscimenti
        'aggregate_rating',       // JSON - Rating aggregato
    ];
}
```

### 2. LocalBusiness Model

Per gestire location fisiche (ristoranti, bar, spazi eventi):

```php
// Modules/Meetup/app/Models/LocalBusiness.php
class LocalBusiness extends Organization
{
    protected $fillable = [
        // ... campi Organization ...

        // Schema.org LocalBusiness properties
        'price_range',            // Text - Fascia prezzo (€, €€, €€€, €€€€)
        'opening_hours',          // JSON - Orari apertura
        'payment_accepted',       // JSON - Metodi pagamento accettati
        'currencies_accepted',    // JSON - Valute accettate
        'payment_method',         // JSON - Metodi pagamento
        'serves_cuisine',         // Text - Tipo cucina (per ristoranti)
        'menu',                   // URL/JSON - Menu
        'accepts_reservations',   // Boolean - Accetta prenotazioni
        'smoking_allowed',        // Boolean - Fumatori ammessi
        'star_rating',            // JSON - Rating stelle
        'amenity_feature',        // JSON - Servizi disponibili (WiFi, Parcheggio, etc.)
    ];
}
```

---

## 📋 Implementazione Proposta

### Priorità Alta
1. ✅ **Event**: Aggiungere campi Schema.org essenziali (event_status, organizer, location_address, offers)
2. ✅ **User**: Aggiungere campi Person essenziali (job_title, works_for, same_as, url)

### Priorità Media
3. ✅ **Organization**: Creare modello base per organizzatori
4. ✅ **Event**: Aggiungere relazioni con Organization

### Priorità Bassa
5. ✅ **LocalBusiness**: Creare modello per location fisiche
6. ✅ **Review**: Sistema recensioni per Event e Organization

---

## 🔗 Risorse Schema.org

- [Event](https://schema.org/Event)
- [Person](https://schema.org/Person)
- [Organization](https://schema.org/Organization)
- [LocalBusiness](https://schema.org/LocalBusiness)
- [Place](https://schema.org/Place)
- [PostalAddress](https://schema.org/PostalAddress)

---

**Ultimo aggiornamento**: 2025-01-22
**Versione**: 1.0.0
**Status**: Proposta - da implementare
