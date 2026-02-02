# Schema.org Enhancement Recommendations for LaravelPizza

**Analysis Date:** 2026-01-08
**Agent:** Schema.org Research Agent
**Priority:** HIGH - Critical for 2026 SEO & AI Discovery

---

## Executive Summary

Comprehensive Schema.org analysis across 6 model categories with implementation priorities for enhanced SEO, rich snippets, and AI system compatibility (Google AI Overviews, ChatGPT, Perplexity).

**Key Insight for 2026:** AI systems cannot rank or cite content they can't understand. Schema.org structured data is now essential for visibility in AI-powered search.

---

## Priority Summary

### Phase 1 (HIGH PRIORITY - SEO CRITICAL)

1. **Event Model** → [Event](https://schema.org/Event)
   - Add: `event_status`, `attendance_mode`, `price`, `place_id`, `performers`
   - Impact: Rich event snippets, event carousels, Google Calendar integration

2. **Page Model** (Cms) → [WebPage](https://schema.org/WebPage)/[Article](https://schema.org/Article)
   - Add: `language`, `keywords`, `page_type`, `featured_image`
   - Impact: AI understanding, rich snippets, voice search optimization

3. **User/Profile Model** → [Person](https://schema.org/Person)
   - Add: `job_title`, `expertise`, `social_links`, `website_url`
   - Impact: Knowledge graph, author attribution, social linking

### Phase 2 (MEDIUM PRIORITY)

4. **Place Model** (Geo) → [Place](https://schema.org/Place) - Already good!
   - Add: `name`, `amenities`, `opening_hours`, `max_capacity`
   - Impact: Local SEO boost, Google Maps integration

5. **Team Model** → [Organization](https://schema.org/Organization)
   - Add: `description`, `logo_url`, `website_url`, `social_links`
   - Impact: Organization knowledge panels

6. **NEW: Venue Model** → [LocalBusiness](https://schema.org/LocalBusiness)
   - Purpose: Dedicated meetup venues with details
   - Impact: Rich venue listings, local SEO

### Phase 3 (LOW PRIORITY)

7. **Notification Model** → [Message](https://schema.org/Message)
8. **Activity Model** → [Action](https://schema.org/Action)
9. **NEW: Speaker, Review, EventSeries, Ticket Models**

---

## Detailed Recommendations by Model

### 1. Event Model (Meetup/Event.php)

**Schema.org Type:** [Event](https://schema.org/Event)

**Critical Fields to Add:**

```php
// Migration: add_schema_org_fields_to_events_table.php
Schema::table('events', function (Blueprint $table) {
    // Status & Mode
    $table->string('event_status')->default('EventScheduled');
    $table->string('attendance_mode')->default('OfflineEventAttendanceMode');

    // Ticketing
    $table->decimal('price', 10, 2)->nullable();
    $table->string('price_currency', 3)->default('EUR');
    $table->string('availability')->default('InStock');
    $table->timestamp('registration_opens_at')->nullable();
    $table->string('registration_url')->nullable();

    // Location (relation instead of string)
    $table->foreignId('place_id')->nullable()->constrained('places');

    // Additional
    $table->string('language', 10)->default('it');
    $table->json('topics')->nullable();
    $table->string('target_audience')->nullable();
    $table->boolean('is_free')->default(true);

    // Series (for recurring events)
    $table->json('schedule')->nullable();
    $table->foreignId('parent_event_id')->nullable()->constrained('events');

    // Performers/Speakers
    $table->json('performers')->nullable();
});
```

**Model Method:**

```php
// Event.php
public function toSchemaOrg(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Event',
        'name' => $this->title,
        'description' => $this->description,
        'startDate' => $this->start_date->toIso8601String(),
        'endDate' => $this->end_date->toIso8601String(),
        'eventStatus' => "https://schema.org/{$this->event_status}",
        'eventAttendanceMode' => "https://schema.org/{$this->attendance_mode}",
        'location' => $this->place?->toSchemaOrg(),
        'image' => $this->cover_image ? asset($this->cover_image) : null,
        'organizer' => [
            '@type' => 'Organization',
            'name' => 'Laravel Pizza Meetups',
            'url' => route('home'),
        ],
        'offers' => [
            '@type' => 'Offer',
            'price' => $this->price ?? 0,
            'priceCurrency' => $this->price_currency,
            'availability' => "https://schema.org/{$this->availability}",
            'url' => route('events.show', $this->id),
            'validFrom' => $this->registration_opens_at?->toIso8601String(),
        ],
        'performer' => $this->performers,
        'isAccessibleForFree' => $this->is_free,
        'maximumAttendeeCapacity' => $this->max_attendees,
    ];
}
```

**SEO Benefits:**
- Rich event snippets with date, location, price
- Event carousels for related events
- Google Calendar integration
- Voice search optimization ("Laravel meetups near me")

---

### 2. User/Profile Model (Person Schema)

**Schema.org Type:** [Person](https://schema.org/Person)

**Fields to Add:**

```php
// Migration: add_schema_org_fields_to_profiles_table.php
Schema::table('profiles', function (Blueprint $table) {
    // Professional
    $table->string('job_title')->nullable();
    $table->string('company_name')->nullable();
    $table->string('website_url')->nullable();
    $table->json('expertise')->nullable(); // ["Laravel", "Vue.js", "DevOps"]
    $table->json('education')->nullable();
    $table->json('awards')->nullable();

    // Social
    $table->json('social_links')->nullable(); // {twitter, github, linkedin}

    // Location
    $table->foreignId('home_place_id')->nullable()->constrained('places');
    $table->foreignId('work_place_id')->nullable()->constrained('places');
});
```

**SEO Benefits:**
- Google Knowledge Graph presence
- Author attribution for content
- Social profile linking
- Better profile discovery

---

### 3. Team Model (Organization Schema)

**Schema.org Type:** [Organization](https://schema.org/Organization)

**Fields to Add:**

```php
// Migration: add_schema_org_fields_to_teams_table.php
Schema::table('teams', function (Blueprint $table) {
    $table->string('legal_name')->nullable();
    $table->string('alternate_name')->nullable();
    $table->text('description')->nullable();
    $table->string('website_url')->nullable();
    $table->string('logo_url')->nullable();
    $table->string('cover_image')->nullable();
    $table->string('email')->nullable();
    $table->string('phone')->nullable();
    $table->string('organization_type')->default('Organization');

    // Location
    $table->foreignId('address_id')->nullable()->constrained('addresses');
    $table->foreignId('place_id')->nullable()->constrained('places');
    $table->string('service_area')->nullable();

    // Relationships
    $table->foreignId('parent_organization_id')->nullable()->constrained('teams');

    // Social
    $table->json('social_links')->nullable();
});
```

**SEO Benefits:**
- Organization knowledge panels
- Local business listings
- Better team discovery

---

### 4. Place Model (Already Good! Enhancements)

**Schema.org Type:** [Place](https://schema.org/Place)
**Current:** Already has `toSchemaOrg()` method ✅

**Enhancements:**

```php
// Migration: enhance_places_table_with_schema_org.php
Schema::table('places', function (Blueprint $table) {
    $table->string('name')->nullable();
    $table->text('description')->nullable();
    $table->string('phone')->nullable();
    $table->string('website_url')->nullable();
    $table->string('virtual_url')->nullable(); // For online meetups
    $table->json('opening_hours')->nullable();
    $table->json('photos')->nullable();
    $table->json('amenities')->nullable(); // ["WiFi", "Parking", "Accessible"]
    $table->integer('max_capacity')->nullable();
    $table->boolean('smoking_allowed')->default(false);
    $table->boolean('is_public')->default(true);
    $table->boolean('is_free_access')->default(true);
});
```

**SEO Benefits:**
- Local SEO boost
- Google Maps integration
- Rich location snippets
- Voice search optimization

---

### 5. Page Model (Cms - CRITICAL FOR 2026!)

**Schema.org Types:** [WebPage](https://schema.org/WebPage), [Article](https://schema.org/Article)

**Fields to Add:**

```php
// Migration: add_schema_org_fields_to_pages_table.php
Schema::table('pages', function (Blueprint $table) {
    $table->string('language', 10)->default('it');
    $table->string('featured_image')->nullable();
    $table->string('page_type')->default('WebPage'); // WebPage, Article, BlogPosting
    $table->string('section')->nullable();
    $table->json('keywords')->nullable();
    $table->json('images')->nullable();
    $table->json('speakable_sections')->nullable();
    $table->timestamp('published_at')->nullable();

    // For breadcrumbs
    $table->foreignId('parent_page_id')->nullable()->constrained('pages');
});
```

**SEO Benefits (CRITICAL FOR 2026!):**
- **AI Systems reliance** - Google AI Overviews, ChatGPT, Perplexity
- **Rich snippets** - Better display with images, dates, authors
- **Higher CTR** - Improved click-through rates
- **Content understanding** - AI can rank and cite content
- **Voice search** - Better voice query optimization

**Research shows:** If AI can't understand your content via structured data, it won't rank or cite it in 2026!

---

### 6. Notification Model (Message Schema)

**Schema.org Type:** [Message](https://schema.org/Message)

**Fields to Add:**

```php
// Migration: add_schema_org_fields_to_notifications_table.php
Schema::table('notifications', function (Blueprint $table) {
    // Sender/Recipient
    $table->string('sender_type')->nullable();
    $table->unsignedBigInteger('sender_id')->nullable();
    $table->timestamp('received_at')->nullable();

    // Email specific
    $table->string('email_address')->nullable();

    // SMS specific
    $table->string('phone_number')->nullable();

    // Message details
    $table->json('attachments')->nullable();
    $table->json('cc_recipients')->nullable();
    $table->json('bcc_recipients')->nullable();

    $table->index(['sender_type', 'sender_id']);
});
```

**Use Cases:**
- Communication tracking
- Email client integration
- Audit trails with structured data

---

### 7. Activity Model (Action Schema)

**Schema.org Type:** [Action](https://schema.org/Action) and subtypes

**Fields to Add:**

```php
// Migration: add_schema_org_fields_to_activities_table.php
Schema::table('activity_log', function (Blueprint $table) {
    $table->string('action_status')->default('CompletedActionStatus');
    $table->timestamp('completed_at')->nullable();
    $table->foreignId('place_id')->nullable()->constrained('places');
    $table->string('action_type')->nullable(); // CreateAction, UpdateAction, etc.
});
```

**Action Type Mapping:**
- created → CreateAction
- updated → UpdateAction
- deleted → DeleteAction
- viewed → ViewAction
- registered → RegisterAction
- joined → JoinAction

---

## NEW Model Recommendations

### 1. EventSeries Model

**Schema.org:** [EventSeries](https://schema.org/EventSeries)
**Purpose:** Group recurring meetups (e.g., "Monthly Laravel Pizza Milan")
**Benefits:** Show recurring patterns, better Calendar integration

### 2. Venue Model

**Schema.org:** [LocalBusiness](https://schema.org/LocalBusiness)
**Purpose:** Dedicated meetup venues with amenities, hours, capacity
**Benefits:** Rich venue listings, local SEO, map integration

### 3. Speaker Model

**Schema.org:** [Person](https://schema.org/Person) with performer role
**Purpose:** Track event speakers/presenters
**Benefits:** Speaker discovery, expertise tracking

### 4. Review/Rating Model

**Schema.org:** [Review](https://schema.org/Review)
**Purpose:** User reviews for events, venues, speakers
**Benefits:** Star ratings in search, social proof, trust signals

### 5. Ticket/Offer Model

**Schema.org:** [Offer](https://schema.org/Offer)
**Purpose:** Ticketing/registration system
**Benefits:** Show pricing in search, availability tracking

---

## Global Implementation Pattern

### Reusable Trait

```php
// Modules/Xot/app/Traits/HasSchemaOrg.php

namespace Modules\Xot\Traits;

trait HasSchemaOrg
{
    /**
     * Convert model to Schema.org structured data
     */
    abstract public function toSchemaOrg(): array;

    /**
     * Get JSON-LD script tag
     */
    public function getSchemaOrgScriptAttribute(): string
    {
        $data = $this->toSchemaOrg();
        return '<script type="application/ld+json">'
            . json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
            . '</script>';
    }

    /**
     * Render Schema.org in Blade
     */
    public function renderSchemaOrg(): string
    {
        return $this->schema_org_script;
    }
}
```

### Blade Component

```blade
{{-- resources/views/components/schema-org.blade.php --}}
@props(['model'])

@if($model && method_exists($model, 'toSchemaOrg'))
    <script type="application/ld+json">
        {!! json_encode($model->toSchemaOrg(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) !!}
    </script>
@endif
```

**Usage in Blade:**
```blade
{{-- In event detail page --}}
<x-schema-org :model="$event" />

{{-- Or directly --}}
{!! $event->renderSchemaOrg() !!}
```

---

## Testing Schema.org Implementation

### Tools

1. **Google Rich Results Test**
   URL: https://search.google.com/test/rich-results
   Purpose: Validate Schema.org markup
   Check: Event, Article, Organization, Person markup

2. **Schema.org Validator**
   URL: https://validator.schema.org/
   Purpose: Validate syntax and structure
   Format: Paste JSON-LD output

3. **Unit Tests**

```php
// tests/Unit/EventSchemaOrgTest.php

class EventSchemaOrgTest extends TestCase
{
    public function test_event_generates_valid_schema_org()
    {
        $event = Event::factory()->create([
            'title' => 'Laravel Meetup',
            'start_date' => now()->addDays(7),
            'end_date' => now()->addDays(7)->addHours(2),
        ]);

        $schema = $event->toSchemaOrg();

        $this->assertEquals('https://schema.org', $schema['@context']);
        $this->assertEquals('Event', $schema['@type']);
        $this->assertEquals('Laravel Meetup', $schema['name']);
        $this->assertArrayHasKey('startDate', $schema);
        $this->assertArrayHasKey('endDate', $schema);
    }
}
```

---

## Expected SEO Benefits

### Immediate (Phase 1)
- Rich event snippets in Google search
- Event carousels for related meetups
- Better AI understanding - Content becomes citable by AI systems
- Knowledge graph entries for people/organizations

### Medium-term (Phase 2-3)
- Local SEO improvement - "Laravel meetups near me"
- Voice search optimization
- Higher CTR from rich snippets
- Google Calendar integration
- Star ratings in search results

### Critical for 2026
Research shows that AI systems (Google AI Overviews, ChatGPT, Perplexity) **cannot rank or cite content they can't understand**. Schema.org structured data is now essential for visibility in AI-powered search.

---

## Monitoring & Analytics

### Track Rich Results Performance

Use Google Search Console to monitor:
- **Rich result impressions** - How often rich results appear
- **Click-through rate** - CTR improvement from rich results
- **Errors** - Schema.org markup errors
- **Enhancements** - Available enhancements

### Key Metrics to Track

1. **Organic traffic increase** - From improved SEO
2. **Event registrations** - From better event visibility
3. **Click-through rate** - From rich snippets
4. **Time on page** - Better content understanding
5. **Bounce rate** - Improved user experience

---

## Implementation Roadmap

### Week 1-2: Phase 1 (High Priority)
- Event Model enhancements
- Page Model Schema.org
- User/Profile Schema.org
- Testing & validation

### Week 3-4: Phase 2 (Medium Priority)
- Place Model enhancements
- Team Model Schema.org
- Create Venue Model
- Testing & validation

### Week 5+: Phase 3 (Low Priority)
- Notification Model Schema.org
- Activity Model Schema.org
- Create Speaker, Review, EventSeries, Ticket Models
- Testing & validation

---

## Reference: Schema.org types studiati (uso nel progetto)

Sintesi dei tipi e proprietà Schema.org rilevanti per meetup, eventi, prenotazioni e luoghi. Usare per implementazioni JSON-LD e per allineare modelli e API.

### Eventi e programmazione

- **Event** – Tipo base: `name`, `startDate`, `endDate`, `eventStatus`, `eventAttendanceMode`, `location` (Place o VirtualLocation), `organizer`, `offers`, `performer`, `attendee`/`attendees`, `maximumAttendeeCapacity`, `isAccessibleForFree`, `inLanguage`.
- **EventSchedule** – Programma ricorrente: `repeatFrequency`, `byDay`, `byMonth`, `duration`, `scheduleTimezone`; usare in `Event` o in **EventSeries** per eventi ricorrenti (es. "Laravel Pizza Milano mensile").
- **EventSeries** – Serie di eventi: `superEvent` (serie), `subEvent` (singoli eventi), estende Event; ideale per meetup ricorrenti con stesso titolo/location pattern.
- **EducationEvent** – Sottotipo di Event per eventi formativi; aggiungere quando l’evento è esplicitamente didattico/workshop.

### Azioni di partecipazione

- **JoinAction** – Iscrizione a un evento: `target` = Event, `participant` = Person; modellare la registrazione (RSVP) come JoinAction in JSON-LD o in Activity.
- **LeaveAction** – Disiscrizione: stesso pattern; utile per audit e per "ha cancellato la partecipazione".
- **EventReservation** – Prenotazione/registrazione: `reservationFor` = Event, `reservationStatus`, `underName` (Person), `reservationId`; collegare a biglietto/offerta se presente.

### Partecipanti e relazioni

- **attendee** / **attendees** – Person o Organization che partecipa; in Event usare per lista partecipanti (anche anonimizzata per privacy).
- **participant** – In JoinAction/LeaveAction indica chi compie l’azione; in Event può indicare speaker/relatore oltre a `performer`.

### Offerte e prezzi

- **Offer** – Prezzo e disponibilità: `price`, `priceCurrency`, `availability`, `url`, `validFrom`/`validUntil`, `eligibleQuantity`; in Event.offers per biglietti/registrazione.
- **PriceSpecification** – Dettaglio prezzo: `price`, `priceCurrency`, `valueAddedTaxIncluded`; per prezzi complessi (es. early bird + standard).
- **DeliveryChargeSpecification** – Sottotipo per costi di consegna; rilevante solo se si modellano delivery (es. pizza/merchandise); altrimenti usare solo Offer/PriceSpecification.

### Luoghi e geografia

- **Place** – `name`, `address` (PostalAddress), `geo` (GeoCoordinates), `openingHours`, `maximumAttendeeCapacity`; per location fisica dell’evento.
- **address** (PostalAddress) – `streetAddress`, `addressLocality`, `addressRegion`, `addressProvince` (custom IT), `postalCode`, `addressCountry`; vedi [place-address-schemaorg](../../Geo/docs/place-address-schemaorg.md) nel modulo Geo.
- **GeoCircle** – Area geografica: `geoMidpoint` (GeoCoordinates), `geoRadius` (Distance o Number); utile per "eventi nel raggio di X km" e per service area.

### Persona e organizzazione

- **Person** – Per profili utente, speaker, attendee: `name`, `jobTitle`, `url`, `image`, `sameAs` (social); vedi [schema-org-enhancements](../../User/docs/schema-org-enhancements.md) nel modulo User.
- **FoodEstablishment** – Sottotipo di LocalBusiness per venue tipo pizzeria/ristorante; usare se il luogo è esplicitamente un locale food (es. "Laravel Pizza presso Pizzeria X").

### Collegamenti esterni (reference)

- [Event](https://schema.org/Event) · [EventSchedule](https://schema.org/eventSchedule) · [EventSeries](https://schema.org/EventSeries)
- [JoinAction](https://schema.org/JoinAction) · [LeaveAction](https://schema.org/LeaveAction) · [EventReservation](https://schema.org/EventReservation)
- [EducationEvent](https://schema.org/EducationEvent) · [attendees](https://schema.org/attendees) · [attendee](https://schema.org/attendee) · [participant](https://schema.org/participant)
- [Offer](https://schema.org/Offer) · [PriceSpecification](https://schema.org/PriceSpecification) · [DeliveryChargeSpecification](https://schema.org/DeliveryChargeSpecification)
- [Place](https://schema.org/Place) · [address](https://schema.org/address) · [GeoCircle](https://schema.org/GeoCircle)
- [Person](https://schema.org/Person) · [FoodEstablishment](https://schema.org/FoodEstablishment)

---

## Resources & References

- [Event - Schema.org Type](https://schema.org/Event)
- [Person - Schema.org Type](https://schema.org/Person)
- [Organization - Schema.org Type](https://schema.org/Organization)
- [Place - Schema.org Type](https://schema.org/Place)
- [PostalAddress - Schema.org Type](https://schema.org/PostalAddress)
- [WebPage - Schema.org Type](https://schema.org/WebPage)
- [Article - Google Search Central](https://developers.google.com/search/docs/appearance/structured-data/article)
- [Google Event Markup Documentation](https://developers.google.com/search/docs/appearance/structured-data/event)
- [Schema Markup Guide for 2026](https://www.clickrank.ai/schema-markup/)
- [Schema Markup & SEO](https://www.searchenginejournal.com/technical-seo/schema/)

---

## Summary Table: All Recommendations

| Model | Schema.org Type | Priority | Key Fields | SEO Impact |
|-------|----------------|----------|------------|------------|
| **Event** | Event | HIGH | eventStatus, offers, place_id | Rich snippets, carousels |
| **User/Profile** | Person | HIGH | jobTitle, expertise, social_links | Knowledge graph, author attribution |
| **Page** | WebPage/Article | HIGH | language, keywords, page_type | AI understanding, rich snippets |
| **Team** | Organization | MEDIUM | description, logo, website | Organization panels |
| **Place** | Place | MEDIUM | amenities, opening_hours | Local SEO, maps |
| **Notification** | Message | LOW | sender, recipients | Communication tracking |
| **Activity** | Action | LOW | action_status, action_type | Activity feeds |
| **NEW: EventSeries** | EventSeries | MEDIUM | schedule, frequency | Recurring events |
| **NEW: Venue** | LocalBusiness | MEDIUM | opening_hours, amenities | Venue listings |
| **NEW: Speaker** | Person | MEDIUM | expertise, topics | Speaker discovery |
| **NEW: Review** | Review | LOW | rating, body | Social proof |
| **NEW: Ticket** | Offer | MEDIUM | price, availability | Pricing in results |

---

**Document Status:** Ready for Implementation
**Next Steps:** Begin Phase 1 implementation with Event, Page, and User/Profile models
**Expected Timeline:** 5-6 weeks for full implementation

---

**Generated by:** Schema.org Research Agent
**Date:** 2026-01-08
**For:** Laravel Pizza Meetups Project
