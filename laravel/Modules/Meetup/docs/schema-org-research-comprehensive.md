# Schema.org Comprehensive Research Guide

**Status**: Reference document  
**Purpose**: Deep research on Schema.org types for Meetup module enhancement

---

## Table of Contents

1. [Event Scheduling & Recurrence](#event-scheduling--recurrence)
2. [Event Series & Super Events](#event-series--super-events)
3. [Participant Actions](#participant-actions)
4. [Event Reservations](#event-reservations)
5. [Education Events](#education-events)
6. [Food Establishments](#food-establishments)
7. [Pricing & Offers](#pricing--offers)
8. [Geographic Areas](#geographic-areas)
9. [Person & Address](#person--address)
10. [Hotel Accommodations](#hotel-accommodations)
11. [Implementation Tasks](#implementation-tasks)

---

## Event Scheduling & Recurrence

### Schema.org URL: [eventSchedule](https://schema.org/eventSchedule)

The `eventSchedule` property allows specifying when an event occurs, particularly for recurring events.

### Key Concepts

| Property | Type | Description |
|----------|------|-------------|
| `eventSchedule` | Schedule | Associates a Schedule to an Event |
| `repeatFrequency` | Duration/Text | ISO 8601 duration (P1W = weekly) |
| `byDay` | DayOfWeek/Text | Days when event repeats |
| `startTime` | Time | Time event starts (HH:MM:SS format) |
| `endTime` | Time | Time event ends |
| `repeatCount` | Integer | Number of occurrences |
| `exceptDate` | Date/DateTime | Dates to exclude |

### Implementation Example

```php
// Event model with schedule support
public function getScheduleSchemaOrg(): array
{
    return [
        '@type' => 'Schedule',
        'startDate' => $this->start_date->toDateString(),
        'endDate' => $this->end_date?->toDateString(),
        'startTime' => $this->start_date->format('H:i:s'),
        'endTime' => $this->end_date?->format('H:i:s'),
        'repeatFrequency' => $this->repeat_frequency, // e.g., 'P1W' for weekly
        'byDay' => $this->repeat_days, // e.g., ['https://schema.org/Wednesday']
        'scheduleTimezone' => config('app.timezone'),
    ];
}
```

### JSON-LD Example for Recurring Event

```json
{
  "@context": "https://schema.org",
  "@type": "Event",
  "name": "Laravel Pizza Monthly Meetup",
  "eventSchedule": {
    "@type": "Schedule",
    "startDate": "2026-01-01",
    "endDate": "2026-12-31",
    "startTime": "19:00:00",
    "endTime": "22:00:00",
    "repeatFrequency": "P1M",
    "byDay": "https://schema.org/Wednesday",
    "byMonthDay": 15,
    "scheduleTimezone": "Europe/Rome"
  }
}
```

### Database Fields Needed

```php
// Migration: add_schedule_fields_to_events_table.php
$table->string('repeat_frequency')->nullable()->comment('ISO 8601: P1D, P1W, P1M');
$table->json('repeat_days')->nullable()->comment('DayOfWeek array');
$table->integer('repeat_count')->nullable()->comment('Number of occurrences');
$table->date('schedule_end_date')->nullable()->comment('When recurrence ends');
$table->json('except_dates')->nullable()->comment('Excluded dates array');
$table->string('schedule_timezone')->default('Europe/Rome');
```

---

## Event Series & Super Events

### Schema.org URLs: [EventSeries](https://schema.org/EventSeries), [superEvent](https://schema.org/superEvent)

### Key Concepts

| Property | Type | Description |
|----------|------|-------------|
| `superEvent` | Event | Parent event/series this event belongs to |
| `subEvent` | Event | Child events within this series |
| `previousEvent` | Event/EventSeries | Previous in sequence |
| `nextEvent` | Event/EventSeries | Next in sequence |

### EventSeries Types

- **Recurring Meetups**: Monthly Laravel Pizza events
- **Conference Tracks**: Multi-day conference sessions
- **Workshop Series**: Progressive learning tracks

### Implementation Pattern

```php
// Models/EventSeries.php
class EventSeries extends BaseModel implements HasSchemaOrg
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'frequency',
        'status',
    ];
    
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'series_id');
    }
    
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'EventSeries',
            'name' => $this->name,
            'description' => $this->description,
            'startDate' => $this->start_date->toIso8601String(),
            'endDate' => $this->end_date?->toIso8601String(),
            'subEvent' => $this->events->map->toSchemaOrg()->toArray(),
        ];
    }
}
```

### Event Model Enhancement

```php
// Event.php additions
public function series(): BelongsTo
{
    return $this->belongsTo(EventSeries::class, 'series_id');
}

public function previousEvent(): BelongsTo
{
    return $this->belongsTo(Event::class, 'previous_event_id');
}

public function nextEvent(): BelongsTo
{
    return $this->belongsTo(Event::class, 'next_event_id');
}

// In toSchemaOrg()
'superEvent' => $this->series?->toSchemaOrg(),
```

---

## Participant Actions

### Schema.org URLs: [JoinAction](https://schema.org/JoinAction), [LeaveAction](https://schema.org/LeaveAction)

### JoinAction Properties

| Property | Type | Description |
|----------|------|-------------|
| `agent` | Person/Organization | Who is joining |
| `object` | Event/Organization | What is being joined |
| `startTime` | DateTime | When action starts |
| `endTime` | DateTime | When action completes |
| `actionStatus` | ActionStatusType | Current status |

### LeaveAction Properties

Same structure, but represents leaving/unsubscribing.

### ActionStatusType Values

- `ActiveActionStatus` - In progress
- `CompletedActionStatus` - Completed
- `FailedActionStatus` - Failed
- `PotentialActionStatus` - Possible future action

### Implementation for RSVP System

```php
// Models/EventAttendance.php
class EventAttendance extends BaseModel
{
    protected $fillable = [
        'user_id',
        'event_id',
        'action_type', // 'join' or 'leave'
        'action_status',
        'joined_at',
        'left_at',
    ];
    
    public function toJoinActionSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'JoinAction',
            'agent' => [
                '@type' => 'Person',
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'object' => $this->event->toSchemaOrg(),
            'startTime' => $this->joined_at->toIso8601String(),
            'actionStatus' => 'https://schema.org/' . $this->action_status,
        ];
    }
    
    public function toLeaveActionSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LeaveAction',
            'agent' => [
                '@type' => 'Person',
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'object' => $this->event->toSchemaOrg(),
            'startTime' => $this->joined_at->toIso8601String(),
            'endTime' => $this->left_at->toIso8601String(),
            'actionStatus' => 'https://schema.org/' . $this->action_status,
        ];
    }
}
```

### Attendee Properties

| Property | Used On | Type | Description |
|----------|---------|------|-------------|
| `attendee` | Event | Person/Organization | Single attendee |
| `attendees` | Event | Person/Organization (array) | Multiple attendees (deprecated) |
| `participant` | Event | Person/Organization | Generic participant |

> **Note**: `attendees` is deprecated in favor of `attendee` with multiple values.

```php
// Event.php
public function getAttendeesSchemaOrg(): array
{
    return $this->attendees->map(fn($att) => [
        '@type' => 'Person',
        'name' => $att->user->name,
        'email' => $att->user->email,
    ])->toArray();
}

// In toSchemaOrg(), use array for multiple:
'attendee' => $this->getAttendeesSchemaOrg(),
```

### Participant Property

| Property | Used On | Type | Description |
|----------|---------|------|-------------|
| `participant` | Action | Person/Organization | Other co-agents that participated in the action indirectly |

This is used in the context of RSVP actions to indicate who participated in the action.

```php
// In RSVP/JoinAction implementation
'participant' => [
    '@type' => 'Person',
    'name' => $this->participant->name,
    'email' => $this->participant->email,
],
```

---

## Event Reservations

### Schema.org URL: [EventReservation](https://schema.org/EventReservation)

### EventReservation Subtypes

- `FoodEstablishmentReservation` - For restaurants
- `TaxiReservation` - For ride services
- `LodgingReservation` - For hotels
- `FlightReservation` - For flights
- `BusReservation` - For buses
- `TrainReservation` - For trains
- `BoatReservation` - For boats
- `RentalCarReservation` - For car rentals
- `EventReservation` - For events (our use case)

### Key Properties

| Property | Type | Description |
|----------|------|-------------|
| `reservationId` | Text | Unique reservation identifier |
| `reservationStatus` | ReservationStatusType | Current status |
| `reservationFor` | Event | The reserved event |
| `underName` | Person/Organization | Person reservation is for |
| `totalPrice` | Number/PriceSpecification | Total price |
| `priceCurrency` | Text | ISO 4217 currency code |
| `reservedTicket` | Ticket | Associated ticket |
| `modifiedTime` | DateTime | Last modification time |
| `programMembershipUsed` | ProgramMembership | Membership used |
| `provider` | Person/Organization | Reservation provider |

### ReservationStatusType Values

- `ReservationConfirmed`
- `ReservationPending`
- `ReservationCancelled`
- `ReservationHold`

### Implementation

```php
// Models/EventReservation.php
class EventReservation extends BaseModel
{
    protected $fillable = [
        'reservation_id',
        'user_id',
        'event_id',
        'ticket_id',
        'status',
        'total_price',
        'price_currency',
        'booking_time',
        'modified_time',
    ];
    
    protected $casts = [
        'total_price' => 'decimal:2',
        'booking_time' => 'datetime',
        'modified_time' => 'datetime',
    ];
    
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'EventReservation',
            'reservationId' => $this->reservation_id,
            'reservationStatus' => 'https://schema.org/Reservation' . $this->status,
            'reservationFor' => $this->event->toSchemaOrg(),
            'underName' => [
                '@type' => 'Person',
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'totalPrice' => $this->total_price,
            'priceCurrency' => $this->price_currency,
            'reservedTicket' => $this->ticket?->toSchemaOrg(),
            'modifiedTime' => $this->modified_time?->toIso8601String(),
            'bookingTime' => $this->booking_time->toIso8601String(),
        ];
    }
}
```

---

## Education Events

### Schema.org URL: [EducationEvent](https://schema.org/EducationEvent)

### Key Properties Beyond Event

| Property | Type | Description |
|----------|------|-------------|
| `assesses` | DefinedTerm/Text | Competencies assessed |
| `educationalLevel` | DefinedTerm/Text | Difficulty level |
| `teaches` | DefinedTerm/Text | Competencies taught |

### EducationEvent Subtypes

- `Course` - Series of lessons
- `ExhibitionEvent` - Art/science exhibitions
- `Hackathon` - Coding competitions

### Implementation for Workshops

```php
// Use for technical workshops and training
public function toEducationEventSchema(): array
{
    return array_merge($this->toSchemaOrg(), [
        '@type' => 'EducationEvent',
        'teaches' => $this->topics, // ['Laravel', 'PHP 8', 'Testing']
        'educationalLevel' => $this->skill_level, // 'Beginner', 'Intermediate', 'Advanced'
        'assesses' => $this->assessment_topics,
    ]);
}
```

---

## Food Establishments

### Schema.org URL: [FoodEstablishment](https://schema.org/FoodEstablishment)

### Key Properties

| Property | Type | Description |
|----------|------|-------------|
| `servesCuisine` | Text | Types of cuisine served |
| `acceptsReservations` | Boolean/Text/URL | Reservation capability |
| `openingHours` | Text | Opening hours specification |
| `priceRange` | Text | Price range indicator |
| `menu` | Menu/Text/URL | Restaurant menu |
| `starRating` | Rating | Star rating |
| `hasMenu` | Menu | Structured menu |

### FoodEstablishment Subtypes

- `Restaurant` - Full-service dining
- `BarOrPub` - Bar establishments
- `CafeOrCoffeeShop` - Coffee shops
- `FastFoodRestaurant` - Quick service
- `Bakery` - Bakery establishments
- `IceCreamShop` - Ice cream shops
- `Winery` - Wine establishments

### Implementation for Venue Partners

```php
// Models/FoodEstablishment.php
class FoodEstablishment extends BaseModel
{
    protected $fillable = [
        'name',
        'description',
        'serves_cuisine',
        'price_range',
        'accepts_reservations',
        'opening_hours',
        'menu_url',
        'address_id',
        'telephone',
        'email',
        'url',
    ];
    
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => $this->establishment_type ?? 'FoodEstablishment',
            'name' => $this->name,
            'description' => $this->description,
            'servesCuisine' => $this->serves_cuisine,
            'priceRange' => $this->price_range,
            'acceptsReservations' => $this->accepts_reservations,
            'openingHours' => $this->opening_hours,
            'menu' => $this->menu_url,
            'address' => $this->address?->toSchemaOrg(),
            'telephone' => $this->telephone,
            'email' => $this->email,
            'url' => $this->url,
        ];
    }
}
```

### Use Case: Pizza Venues

```json
{
  "@context": "https://schema.org",
  "@type": "Restaurant",
  "name": "Pizzeria Aurora",
  "servesCuisine": ["Italian", "Pizza", "Neapolitan"],
  "priceRange": "€€",
  "acceptsReservations": true,
  "openingHours": "Tu-Su 12:00-23:00",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Via Roma 123",
    "addressLocality": "Milano",
    "postalCode": "20100",
    "addressCountry": "IT"
  }
}
```

---

## Pricing & Offers

### Schema.org URLs: [Offer](https://schema.org/Offer), [PriceSpecification](https://schema.org/PriceSpecification)

### Offer Properties

| Property | Type | Description |
|----------|------|-------------|
| `price` | Number/Text | The price |
| `priceCurrency` | Text | ISO 4217 currency |
| `priceValidUntil` | Date | Price expiration |
| `availability` | ItemAvailability | Stock status |
| `validFrom` | Date/DateTime | When offer starts |
| `validThrough` | Date/DateTime | When offer ends |
| `itemOffered` | Product/Service/Event | What's offered |
| `seller` | Person/Organization | The seller |
| `eligibleQuantity` | QuantitativeValue | Quantity limits |

### ItemAvailability Values

- `InStock` - Available
- `OutOfStock` - Sold out
- `PreOrder` - Pre-order available
- `LimitedAvailability` - Almost sold out
- `SoldOut` - No longer available
- `OnlineOnly` - Online only
- `InStoreOnly` - In-person only

### PriceSpecification Types

- **UnitPriceSpecification** - Price per unit
- **DeliveryChargeSpecification** - Delivery costs
- **PaymentChargeSpecification** - Payment processing fees
- **CompoundPriceSpecification** - Combined pricing

### Implementation for Event Tickets

```php
// Models/Ticket.php (or EventOffer.php)
class Ticket extends BaseModel
{
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'price_currency',
        'availability',
        'valid_from',
        'valid_through',
        'max_quantity',
        'sold_count',
    ];
    
    public function toSchemaOrg(): array
    {
        return [
            '@type' => 'Offer',
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'priceCurrency' => $this->price_currency,
            'availability' => 'https://schema.org/' . $this->availability,
            'validFrom' => $this->valid_from?->toIso8601String(),
            'validThrough' => $this->valid_through?->toIso8601String(),
            'url' => route('events.tickets', [$this->event_id, $this->id]),
            'eligibleQuantity' => [
                '@type' => 'QuantitativeValue',
                'maxValue' => $this->max_quantity,
                'value' => $this->remaining,
            ],
        ];
    }
    
    public function getRemainingAttribute(): int
    {
        return $this->max_quantity - $this->sold_count;
    }
}
```

### Delivery Charge for Food Orders

```php
// DeliveryChargeSpecification implementation
public function toDeliveryChargeSchema(): array
{
    return [
        '@type' => 'DeliveryChargeSpecification',
        'appliesToDeliveryMethod' => 'http://purl.org/goodrelations/v1#DeliveryModeDirectDownload',
        'eligibleRegion' => [
            '@type' => 'GeoCircle',
            'geoMidpoint' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->center_lat,
                'longitude' => $this->center_lng,
            ],
            'geoRadius' => $this->delivery_radius_km * 1000, // meters
        ],
        'price' => $this->delivery_fee,
        'priceCurrency' => 'EUR',
    ];
}
```

### DeliveryChargeSpecification Properties

| Property | Type | Description |
|----------|------|-------------|
| `appliesToDeliveryMethod` | DeliveryMethod | The delivery method this applies to |
| `deliveryTime` | ShippingTime | Expected delivery time |
| `price` | Number/Text | Price for delivery |
| `priceCurrency` | Text | ISO 4217 currency code |
| `eligibleRegion` | GeoShape | Geographic area where delivery applies |
| `eligibleTransactionVolume` | PriceSpecification | Minimum order volume for free delivery |
| `validFrom` | Date/DateTime | When this specification is valid |
| `validThrough` | Date/DateTime | When this specification expires |

### PaymentChargeSpecification

For payment processing fees:

```php
public function toPaymentChargeSchema(): array
{
    return [
        '@type' => 'PaymentChargeSpecification',
        'appliesToDeliveryMethod' => 'http://purl.org/goodrelations/v1#DeliveryModeDirectDownload',
        'price' => $this->payment_fee,
        'priceCurrency' => 'EUR',
    ];
}
```

### CompoundPriceSpecification

For combined pricing:

```php
public function toCompoundPriceSchema(): array
{
    return [
        '@type' => 'CompoundPriceSpecification',
        'priceComponent' => [
            $this->toUnitPriceSchema(),
            $this->toDeliveryChargeSchema(),
            $this->toPaymentChargeSchema(),
        ],
    ];
}
```

---

## Geographic Areas

### Schema.org URLs: [GeoCircle](https://schema.org/GeoCircle), [GeoShape](https://schema.org/GeoShape)

### GeoCircle Properties

| Property | Type | Description |
|----------|------|-------------|
| `geoMidpoint` | GeoCoordinates | Center of circle |
| `geoRadius` | Distance/Number/Text | Radius in meters |

### Use Cases

1. **Delivery Zones** - Food delivery areas
2. **Service Areas** - Business coverage
3. **Event Catchment** - Target audience area
4. **Nearby Events** - Location-based discovery

### Implementation

```php
// Models/ServiceArea.php or Traits/HasGeoCircle.php
trait HasGeoCircle
{
    public function toGeoCircleSchema(): array
    {
        return [
            '@type' => 'GeoCircle',
            'geoMidpoint' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
            ],
            'geoRadius' => [
                '@type' => 'Distance',
                'value' => $this->radius_km,
                'unitCode' => 'KM',
            ],
        ];
    }
}
```

### Geo Module Enhancement

```php
// Modules/Geo/app/Models/Place.php additions
public function toSchemaOrg(): array
{
    $schema = [
        '@context' => 'https://schema.org',
        '@type' => 'Place',
        'name' => $this->name,
        'address' => $this->getAddressSchemaOrg(),
        'geo' => [
            '@type' => 'GeoCoordinates',
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ],
    ];
    
    if ($this->service_radius) {
        $schema['areaServed'] = $this->toGeoCircleSchema();
    }
    
    return $schema;
}
```

---

## Person & Address

### Schema.org URLs: [Person](https://schema.org/Person), [address](https://schema.org/address)

### Person Key Properties

| Property | Type | Description |
|----------|------|-------------|
| `givenName` | Text | First name |
| `familyName` | Text | Last name |
| `additionalName` | Text | Middle name |
| `honorificPrefix` | Text | Title (Dr., Prof.) |
| `jobTitle` | Text | Job title |
| `worksFor` | Organization | Employer |
| `affiliation` | Organization | Affiliated organizations |
| `alumniOf` | EducationalOrganization | Schools attended |
| `knowsAbout` | Text/Thing/URL | Areas of expertise |
| `knowsLanguage` | Language/Text | Languages spoken |
| `birthDate` | Date | Date of birth |
| `birthPlace` | Place | Place of birth |
| `address` | PostalAddress/Text | Physical address |
| `email` | Text | Email address |
| `telephone` | Text | Phone number |
| `sameAs` | URL | Social profiles |
| `url` | URL | Website |
| `image` | ImageObject/URL | Photo |

### PostalAddress Properties

| Property | Type | Description |
|----------|------|-------------|
| `streetAddress` | Text | Street address |
| `addressLocality` | Text | City |
| `addressRegion` | Text | State/Province |
| `postalCode` | Text | ZIP/Postal code |
| `addressCountry` | Text/Country | Country |
| `postOfficeBoxNumber` | Text | P.O. Box |

### Italian Administrative Levels (Google Maps API)

| Level | Italian | Example |
|-------|---------|---------|
| administrative_area_level_1 | Regione | Lombardia |
| administrative_area_level_2 | Provincia | Milano |
| administrative_area_level_3 | Comune | Milano |

### Implementation

```php
// User Model Enhancement
public function toPersonSchema(): array
{
    return [
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        'name' => $this->name,
        'givenName' => $this->profile?->first_name,
        'familyName' => $this->profile?->last_name,
        'email' => $this->email,
        'jobTitle' => $this->profile?->job_title,
        'worksFor' => $this->profile?->company ? [
            '@type' => 'Organization',
            'name' => $this->profile->company,
        ] : null,
        'knowsAbout' => $this->profile?->expertise, // ['Laravel', 'PHP', 'Vue.js']
        'address' => $this->address?->toSchemaOrg(),
        'sameAs' => array_filter([
            $this->profile?->github_url,
            $this->profile?->twitter_url,
            $this->profile?->linkedin_url,
        ]),
        'image' => $this->profile_photo_url,
        'url' => route('profiles.show', $this->id),
    ];
}
```

---

## Hotel Accommodations

### Schema.org URL: [docs/hotels.html](https://schema.org/docs/hotels.html)

### Key Concepts for Accommodation

1. **LodgingBusiness** - The business (Hotel, Hostel, Motel)
2. **Accommodation** - The room/unit type (HotelRoom, Suite)
3. **Offer** - The booking offer

### MTE Pattern (Multi-Typed Entity)

For bookable accommodations, mark as both:
- `Accommodation` (for physical properties)
- `Product` (for commercial aspects)

### Relationships

| Relationship | From | To | Description |
|--------------|------|-----|-------------|
| `containedInPlace` | Room | Hotel | Room belongs to hotel |
| `containsPlace` | Hotel | Room | Hotel contains rooms |
| `makesOffer` | Hotel | Offer | Hotel makes booking offers |
| `offeredBy` | Offer | Hotel | Offer is from hotel |
| `itemOffered` | Offer | Accommodation | What's being offered |

### Implementation (if needed for event venues)

```php
// For conference/event venues with accommodations
class AccommodationOffer extends BaseModel
{
    public function toSchemaOrg(): array
    {
        return [
            '@type' => ['Accommodation', 'Product'],
            'name' => $this->name,
            'description' => $this->description,
            'occupancy' => [
                '@type' => 'QuantitativeValue',
                'maxValue' => $this->max_occupancy,
            ],
            'bed' => $this->bed_configuration,
            'amenityFeature' => $this->amenities,
            'containedInPlace' => $this->venue->toSchemaOrg(),
        ];
    }
}
```

---

## Implementation Tasks

Based on this research, the following tasks should be created:

### High Priority Tasks

1. **task-event-scheduling.md** - Implement recurring event support
2. **task-event-series.md** - Create EventSeries model and relationships
3. **task-rsvp-actions.md** - Implement JoinAction/LeaveAction for RSVP system
4. **task-event-reservations.md** - Create reservation/ticketing system

### Medium Priority Tasks

5. **task-education-events.md** - Support for workshop/training events
6. **task-food-establishments.md** - Partner venue (pizzeria) integration
7. **task-pricing-offers.md** - Enhanced pricing and ticket offers

### Low Priority Tasks

8. **task-geo-service-areas.md** - GeoCircle for delivery/service areas
9. **task-person-enhancement.md** - Enhanced user profiles with Schema.org

---

## References

### Primary Sources

- [Event](https://schema.org/Event)
- [eventSchedule](https://schema.org/eventSchedule)
- [EventSeries](https://schema.org/EventSeries)
- [JoinAction](https://schema.org/JoinAction)
- [LeaveAction](https://schema.org/LeaveAction)
- [EventReservation](https://schema.org/EventReservation)
- [EducationEvent](https://schema.org/EducationEvent)
- [FoodEstablishment](https://schema.org/FoodEstablishment)
- [DeliveryChargeSpecification](https://schema.org/DeliveryChargeSpecification)
- [Offer](https://schema.org/Offer)
- [PriceSpecification](https://schema.org/PriceSpecification)
- [GeoCircle](https://schema.org/GeoCircle)
- [Person](https://schema.org/Person)
- [address](https://schema.org/address)
- [Hotels Markup Guide](https://schema.org/docs/hotels.html)

### Related Documentation

- [event-schema-org-implementation.md](./event-schema-org-implementation.md) - Current Event implementation
- [schema-org-enhancement-proposal.md](./schema-org-enhancement-proposal.md) - Enhancement proposals
- [schema-org-enhancement-recommendations.md](./schema-org-enhancement-recommendations.md) - Detailed recommendations

---

**Document Status**: Reference guide
