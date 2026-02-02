# Schema.org Offers, Pricing, and Ticketing Implementation

## Overview

This document provides comprehensive implementation guidance for Schema.org Offer types, PriceSpecification, and related entities for building a complete ticketing and monetization system in LaravelPizza.

## Core Offer Types

### 1. Offer (Base Type)

The fundamental offer type representing any proposal to transfer rights, goods, or services.

#### Key Properties
- `@type` - Always "Offer"
- `name` - Offer title/name
- `description` - Detailed offer description
- `price` - Numeric price value
- `priceCurrency` - ISO 4217 currency code
- `availability` - Stock status (InStock, OutOfStock, etc.)
- `businessFunction` - Transaction type (sell, lease, etc.)
- `itemOffered` - What's being offered (Event, Product, Service)
- `offeredBy` - Who's making the offer
- `validFrom`/`validThrough` - Validity period
- `url` - Offer landing page

### 2. PriceSpecification

Detailed pricing information for complex pricing models.

#### Key Properties
- `@type` - "PriceSpecification" or subtypes
- `price` - Base price
- `priceCurrency` - Currency code
- `valueAddedTaxIncluded` - Tax inclusion flag
- `validFrom`/`validThrough` - Price validity period
- `eligibleQuantity` - Quantity constraints
- `eligibleTransactionVolume` - Transaction limits

### 3. AggregateOffer

Multiple offers combined (e.g., from different sellers).

#### Key Properties
- `@type` - "AggregateOffer"
- `offers` - Array of individual Offer objects
- `highPrice`/`lowPrice` - Price range
- `offerCount` - Number of offers aggregated

## Implementation Tasks

### Task 1: Offer Management System

**Files**:
- `Modules/Meetup/app/Models/Offer.php`
- `Modules/Meetup/app/Models/PriceSpecification.php`
- `Modules/Meetup/app/Services/OfferService.php`

**Requirements**:
1. Multi-currency pricing support
2. Dynamic pricing based on demand
3. Discount and promotion management
4. Inventory integration
5. Historical pricing tracking

**Implementation Checklist**:
- [ ] Create comprehensive Offer model
- [ ] Implement PriceSpecification models
- [ ] Build dynamic pricing engine
- [ ] Add discount/promotion system
- [ ] Create inventory management
- [ ] Implement price history tracking
- [ ] Add multi-currency support

**Offer Model Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Meetup\Models\Event;

class Offer extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'priceCurrency',
        'availability',
        'businessFunction',
        'itemOffered_type', // Event, Product, Service
        'itemOffered_id',
        'offeredBy_id',
        'validFrom',
        'validThrough',
        'discount_percentage',
        'promo_code',
        'availabilityStarts',
        'availabilityEnds',
        'eligibleQuantity',
        'priceSpecification', // JSON for complex pricing
        'metadata' // Additional offer metadata
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'eligibleQuantity' => 'integer',
        'priceSpecification' => 'array',
        'metadata' => 'array',
        'validFrom' => 'date',
        'validThrough' => 'date'
    ];

    protected $dates = ['date'];

    public function itemOffered(): BelongsTo
    {
        return $this->morphTo('itemOffered', 'itemOffered');
    }

    public function priceSpecification(): HasMany
    {
        return $this->hasMany(PriceSpecification::class);
    }

    public function isAvailable(): bool
    {
        return $this->availability === 'InStock';
    }

    public function getFormattedPrice(): string
    {
        return number_format($this->price, 2) . ' ' . $this->priceCurrency;
    }

    public function isDiscounted(): bool
    {
        return $this->discount_percentage > 0;
    }

    public function getDiscountedPrice(): float
    {
        return $this->price * (1 - ($this->discount_percentage / 100));
    }

    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Offer',
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'priceCurrency' => $this->priceCurrency,
            'availability' => $this->getSchemaAvailability(),
            'businessFunction' => $this->businessFunction ?? 'http://purl.org/goodrelations/v1#Sell',
            'validFrom' => $this->validFrom?->toIso8601String() : null,
            'validThrough' => $this->validThrough?->toIso8601String() : null
        ];
    }

    private function getSchemaAvailability(): string
    {
        return match($this->availability) {
            'InStock' => 'https://schema.org/InStock',
            'OutOfStock' => 'https://schema.org/OutOfStock',
            'PreOrder' => 'https://schema.org/PreOrder',
            'SoldOut' => 'https://schema.org/SoldOut',
            'Discontinued' => 'https://schema.org/Discontinued',
            default => 'https://schema.org/InStock'
        };
    }
}
```

### Task 2: Ticketing and Reservation System

**Files**:
- `Modules/Meetup/app/Models/Ticket.php`
- `Modules/Meetup/app/Services/TicketingService.php`
- `Modules/Meetup/app/Services/QRCodeService.php`

**Requirements**:
1. QR code generation for mobile tickets
2. Different ticket types (General, VIP, Student, etc.)
3. Seat assignment for venues
4. PDF ticket generation
5. Email/SMS ticket delivery

**Implementation Checklist**:
- [ ] Create Ticket model with seat management
- [ ] Implement QR code generation
- [ ] Build PDF ticket generation
- [ ] Add seat mapping system
- [ ] Create ticket delivery system
- [ ] Implement ticket validation
- [ ] Add transfer/refund support

**Ticket Model Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Order;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'qr_code',
        'ticket_type', // general, vip, student, speaker
        'event_id',
        'order_id',
        'user_id',
        'seat_id',
        'price_paid',
        'currency',
        'status', // valid, used, refunded, cancelled
        'issued_at',
        'validated_at',
        'metadata' // JSON for additional data
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'validated_at' => 'datetime',
        'price_paid' => 'decimal:2',
        'metadata' => 'array'
    ];

    protected $dates = ['date', 'datetime'];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seat(): BelongsTo
    {
        return $this->belongsTo(Seat::class);
    }

    public function isValid(): bool
    {
        return $this->status === 'valid';
    }

    public function isUsed(): bool
    {
        return $this->status === 'used';
    }

    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Ticket',
            'ticketNumber' => $this->ticket_number,
            'ticketToken' => $this->qr_code,
            'ticketedSeat' => $this->seat ? [
                '@type' => 'Seat',
                'seatRow' => $this->seat->row,
                'seatNumber' => $this->seat->number,
                'seatSection' => $this->seat->section
            ] : null,
            'issuedBy' => [
                '@type' => 'Organization',
                'name' => config('app.name')
            ]
        ];
    }
}
```

### Task 3: Dynamic Pricing Engine

**File**: `Modules/Meetup/app/Services/PricingService.php`

**Requirements**:
1. Demand-based pricing
2. Time-based pricing (early bird, etc.)
3. Tiered pricing support
4. Currency conversion
5. Price change tracking

**Implementation Checklist**:
- [ ] Create pricing calculation engine
- [ ] Implement demand-based adjustments
- [ ] Add time-based modifiers
- [ ] Build tiered pricing structure
- [ ] Add currency conversion service
- [ ] Create price history tracking
- [ ] Implement discount rules engine

**Pricing Service Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Services;

use Modules\Meetup\Models\Event;
use Modules\Meetup\Models\Offer;
use Carbon\Carbon;

class PricingService
{
    public function calculateEventPrice(Event $event, array $context = []): float
    {
        $basePrice = $this->getBasePrice($event);
        $multiplier = $this->getDemandMultiplier($context);
        $timeModifier = $this->getTimeModifier($context);
        $tierPrice = $this->getTierPriceAdjustment($context);
        
        return $basePrice * $multiplier * $timeModifier + $tierPrice;
    }

    public function generateDynamicOffers(Event $event): array
    {
        $offers = [];
        
        // General admission
        $offers[] = $this->createBaseOffer($event, 'general');
        
        // VIP pricing
        if ($event->hasVipTier()) {
            $offers[] = $this->createBaseOffer($event, 'vip');
        }
        
        // Student pricing
        if ($this->hasStudentDiscount($event)) {
            $offers[] = $this->createBaseOffer($event, 'student');
        }
        
        // Early bird pricing
        if ($this->isEarlyBirdPeriod($event)) {
            $offers[] = $this->createBaseOffer($event, 'early_bird');
        }
        
        return $offers;
    }

    private function getBasePrice(Event $event): float
    {
        return match($event->type) {
            'workshop' => 50.00,
            'conference' => 150.00,
            'meetup' => 0.00, // Free
            'social' => 15.00,
            default => 25.00
        };
    }

    private function getDemandMultiplier(array $context): float
    {
        // Calculate demand multiplier based on attendance, time to event, etc.
        $demandScore = $this->calculateDemandScore($context);
        
        return match(true) {
            $demandScore >= 80 => 1.5,      // High demand
            $demandScore >= 60 => 1.2,      // Medium demand
            $demandScore >= 40 => 1.1,      // Low demand
            default => 1.0               // Normal demand
        };
    }

    private function getTimeModifier(array $context): float
    {
        // Early bird discount
        if (isset($context['is_early_bird']) {
            return 0.8; // 20% discount
        }
        
        // Last minute increase
        if (isset($context['is_last_minute'])) {
            return 1.2; // 20% increase
        }
        
        return 1.0;
    }

    private function getTierPriceAdjustment(array $context): float
    {
        // Member tier adjustments
        if (isset($context['user_tier'])) {
            return match($context['user_tier']) {
                'platinum' => -10.0,    // $10 discount
                'gold' => -5.0,       // $5 discount
                'silver' => -2.0,      // $2 discount
                default => 0.0
            };
        }
        
        return 0.0;
    }

    private function calculateDemandScore(array $context): int
    {
        $score = 0;
        
        // Days to event (closer = higher demand)
        if (isset($context['days_to_event'])) {
            $days = $context['days_to_event'];
            $score += min($days * 2, 20);
        }
        
        // Historical attendance rate
        if (isset($context['historical_fill_rate'])) {
            $score += $context['historical_fill_rate'] * 15;
        }
        
        // Current registrations
        if (isset($context['current_registrations'])) {
            $score += min($context['current_registrations'] / 10, 30);
        }
        
        // Waitlist size
        if (isset($context['waitlist_size'])) {
            $score += min($context['waitlist_size'] / 5, 20);
        }
        
        return $score;
    }
}
```

### Task 4: Multi-Currency Support

**File**: `Modules/Meetup/app/Services/CurrencyService.php`

**Requirements**:
1. Real-time exchange rates
2. Currency conversion
3. Multi-currency pricing display
4. Payment method support
5. Reporting in base currency

**Implementation Checklist**:
- [ ] Integrate exchange rate API
- [ ] Create currency conversion service
- [ ] Add multi-currency price display
- [ ] Implement payment method detection
- [ ] Create currency reporting
- [ ] Add cache for exchange rates

### Task 5: Discount and Promotion System

**Files**:
- `Modules/Meetup/app/Models/Discount.php`
- `Modules/Meetup/app/Models/Promotion.php`
- `Modules/Meetup/app/Services/PromotionService.php`

**Requirements**:
1. Code-based discounts
2. Time-based promotions
3. User segment targeting
4. Bundle offers
5. Analytics tracking

**Implementation Checklist**:
- [ ] Create Discount and Promotion models
- [ ] Build promotion engine
- [ ] Add code validation system
- [ ] Implement user segmentation
- [ ] Create bundle offers
- [ ] Add usage analytics

## JSON-LD Implementation Examples

### Basic Event Offer

```json
{
  "@context": "https://schema.org",
  "@type": "Offer",
  "name": "General Admission - Laravel Meetup Milano",
  "description": "Standard admission ticket for monthly Laravel meetup",
  "price": "15.00",
  "priceCurrency": "EUR",
  "availability": "https://schema.org/InStock",
  "businessFunction": "http://purl.org/goodrelations/v1#Sell",
  "itemOffered": {
    "@type": "Event",
    "name": "Laravel Meetup Milano",
    "startDate": "2026-02-15T19:00:00+01:00",
    "url": "https://laravelpizza.it/events/laravel-meetup-milano"
  },
  "offeredBy": {
    "@type": "Organization",
    "name": "Laravel Italy Community",
    "url": "https://laravel-italia.it"
  },
  "validFrom": "2026-02-01T00:00:00+01:00",
  "validThrough": "2026-02-14T23:59:59+01:00",
  "url": "https://laravelpizza.it/events/laravel-meetup-milano/tickets"
}
```

### Complex Pricing with Specification

```json
{
  "@context": "https://schema.org",
  "@type": "AggregateOffer",
  "name": "Laravel Conference 2026 - Tiered Pricing",
  "description": "Multiple ticket options with different pricing tiers",
  "highPrice": "299.00",
  "lowPrice": "99.00",
  "offerCount": 3,
  "offers": [
    {
      "@type": "Offer",
      "name": "Platinum Pass",
      "description": "Full conference access + VIP benefits",
      "price": "299.00",
      "priceCurrency": "EUR",
      "priceSpecification": {
        "@type": "PriceSpecification",
        "valueAddedTaxIncluded": true,
        "eligibleQuantity": 1
      },
      "availability": "https://schema.org/InStock"
    },
    {
      "@type": "Offer",
      "name": "Gold Pass",
      "description": "Conference access + workshop access",
      "price": "199.00",
      "priceCurrency": "EUR",
      "discountPercentage": 10,
      "validFrom": "2026-01-01T00:00:00+01:00",
      "availability": "https://schema.org/InStock"
    },
    {
      "@type": "Offer",
      "name": "Silver Pass",
      "description": "Basic conference access",
      "price": "99.00",
      "priceCurrency": "EUR",
      "discountPercentage": 5,
      "validFrom": "2026-02-01T00:00:00+01:00",
      "availability": "https://schema.org/PreOrder"
    }
  ],
  "offeredBy": {
    "@type": "Organization",
    "name": "Laravel Italy Community"
    "url": "https://laravelpizza.it"
  }
}
```

### EventReservation with Ticket

```json
{
  "@context": "https://schema.org",
  "@type": "EventReservation",
  "reservationId": "LRM-2026-02-15-001",
  "reservationStatus": "https://schema.org/ReservationConfirmed",
  "underName": {
    "@type": "Person",
    "name": "Mario Rossi",
    "email": "mario.rossi@email.com"
  },
  "reservationFor": {
    "@type": "Event",
    "name": "Laravel Advanced Workshop",
    "startDate": "2026-02-15T09:00:00+01:00",
    "location": {
      "@type": "Place",
      "name": "TechHub Milano",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Via Torino 45",
        "addressLocality": "Milano",
        "postalCode": "20158",
        "addressCountry": "IT"
      }
    }
  },
  "bookingTime": "2026-02-01T10:30:00+01:00",
  "totalPrice": "150.00",
  "priceCurrency": "EUR",
  "reservedTicket": {
    "@type": "Ticket",
    "ticketNumber": "LRM-2026-001",
    "ticketToken": "qrCode:LRM20260215001ABC123",
    "ticketedSeat": {
      "@type": "Seat",
      "seatRow": "A",
      "seatNumber": "12",
      "seatSection": "101"
    }
  },
  "modifiedTime": "2026-02-05T14:20:00+01:00"
}
```

## Database Schema

### Offers Table

```sql
CREATE TABLE offers (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10,2) NOT NULL,
    priceCurrency CHAR(3) NOT NULL DEFAULT 'EUR',
    availability ENUM('InStock', 'OutOfStock', 'PreOrder', 'SoldOut', 'Discontinued') DEFAULT 'InStock',
    businessFunction VARCHAR(50) DEFAULT 'http://purl.org/goodrelations/v1#Sell',
    itemOffered_type VARCHAR(50) NOT NULL, -- Event, Product, Service
    itemOffered_id BIGINT NULL,
    offeredBy_id BIGINT NULL, -- Organization or Person
    validFrom DATE NULL,
    validThrough DATE NULL,
    discountPercentage DECIMAL(5,2) DEFAULT 0.00,
    promoCode VARCHAR(50) NULL,
    availabilityStarts DATE NULL,
    availabilityEnds DATE NULL,
    eligibleQuantity INT NULL,
    eligibleTransactionVolume DECIMAL(10,2) NULL,
    priceSpecification JSON NULL,
    metadata JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_availability (availability, validFrom, validThrough),
    INDEX idx_item_offered (itemOffered_type, itemOffered_id),
    INDEX idx_offered_by (offeredBy_id)
);
```

### Price Specifications Table

```sql
CREATE TABLE price_specifications (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    offer_id BIGINT NOT NULL REFERENCES offers(id) ON DELETE CASCADE,
    type VARCHAR(50) NOT NULL, -- Compound, UnitPrice, DeliveryCharge
    price DECIMAL(10,2) NOT NULL,
    priceCurrency CHAR(3) NOT NULL DEFAULT 'EUR',
    valueAddedTaxIncluded BOOLEAN DEFAULT FALSE,
    eligibleQuantityMin INT NULL,
    eligibleQuantityMax INT NULL,
    validFrom DATE NULL,
    validThrough DATE NULL,
    minReservationQuantity INT NULL,
    eligibleRegion VARCHAR(2) NULL,
    specificationData JSON NULL, -- Additional specification details
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (offer_id) REFERENCES offers(id) ON DELETE CASCADE,
    INDEX idx_offer_type (offer_id, type)
);
```

### Tickets Table

```sql
CREATE TABLE tickets (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    ticket_number VARCHAR(50) NOT NULL UNIQUE,
    qr_code VARCHAR(255) NOT NULL UNIQUE,
    ticket_type ENUM('general', 'vip', 'student', 'speaker', 'sponsor') DEFAULT 'general',
    event_id BIGINT NOT NULL REFERENCES events(id) ON DELETE CASCADE,
    order_id BIGINT NULL REFERENCES orders(id) ON DELETE SET NULL,
    user_id BIGINT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    seat_id BIGINT NULL REFERENCES seats(id) ON DELETE SET NULL,
    price_paid DECIMAL(10,2) NOT NULL,
    currency CHAR(3) NOT NULL DEFAULT 'EUR',
    status ENUM('issued', 'validated', 'used', 'refunded', 'cancelled') DEFAULT 'issued',
    issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    validated_at TIMESTAMP NULL,
    used_at TIMESTAMP NULL,
    metadata JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_ticket_number (ticket_number),
    INDEX idx_qr_code (qr_code),
    INDEX idx_event (event_id),
    INDEX idx_user (user_id),
    INDEX idx_status (status)
);
```

### Discounts Table

```sql
CREATE TABLE discounts (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    type ENUM('percentage', 'fixed', 'bogo') NOT NULL,
    value DECIMAL(10,2) NOT NULL,
    discountPercentage DECIMAL(5,2) NULL, -- For percentage discounts
    maxUses INT NULL,
    usedCount INT DEFAULT 0,
    validFrom TIMESTAMP NULL,
    validThrough TIMESTAMP NULL,
    applicableToType ENUM('all', 'event', 'product', 'user_type') DEFAULT 'all',
    metadata JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_code (code),
    INDEX idx_validity (validFrom, validThrough),
    INDEX idx_applicable (applicableToType)
);
```

## Frontend Integration

### Offer Display Component

```php
// Themes/Meetup/resources/views/components/offers/event-offers.blade.php
@props([
    'event' => Modules\Meetup\Models\Event::class,
    'offers' => Collection::class,
    'userCurrency' => 'EUR'
])

<div class="event-offers" x-data="{ selectedOffer: null, processingPurchase: false }">
    <h3>{{ __('meetup::offers.select_ticket') }}</h3>
    
    <div class="offers-grid">
        @foreach($offers as $offer)
        <div class="offer-card {{ $selectedOffer?->id === $offer->id ? 'selected' : '' }}" 
             @click="selectOffer({{ $offer->id }})" 
             itemscope itemtype="https://schema.org/Offer">
            
            <!-- Schema.org microdata -->
            <meta itemprop="name" content="{{ $offer->name }}">
            <meta itemprop="description" content="{{ $offer->description }}">
            <meta itemprop="price" content="{{ $offer->getFormattedPrice() }}">
            <meta itemprop="priceCurrency" content="{{ $offer->priceCurrency }}">
            <meta itemprop="availability" content="{{ $offer->getSchemaAvailability() }}">
            <meta itemprop="businessFunction" content="{{ $offer->businessFunction ?? 'http://purl.org/goodrelations/v1#Sell' }}">
            
            <div class="offer-header">
                @if($offer->isDiscounted())
                <span class="discount-badge">{{ __('meetup::offers.discount', ['percentage' => $offer->discount_percentage]) }}</span>
                @endif
                <h4 itemprop="name">{{ $offer->name }}</h4>
            </div>
            
            <div class="offer-price">
                <span class="current-price">{{ $offer->getFormattedPrice() }}</span>
                @if($offer->originalPrice())
                    <span class="original-price">{{ $offer->originalPrice() }}</span>
                @endif
            </div>
            
            @if($offer->description)
            <p class="offer-description" itemprop="description">{{ $offer->description }}</p>
            @endif
            
            @if($offer->validFrom || $offer->validThrough)
            <div class="offer-validity">
                @if($offer->validFrom)
                    <span>{{ __('meetup::offers.valid_from', ['date' => $offer->validFrom->format('d/m/Y')]) }}</span>
                @endif
                @if($offer->validThrough)
                    <span>- {{ __('meetup::offers.valid_until', ['date' => $offer->validThrough->format('d/m/Y')]) }}</span>
                @endif
            </div>
            
            <button class="btn btn-primary" 
                    @click="purchaseOffer({{ $offer->id }})"
                    :disabled="$selectedOffer?->id === $offer->id || $processingPurchase">
                {{ $processingPurchase ? __('meetup::offers.processing') : __('meetup::offers.purchase') }}
            </button>
        </div>
        @endforeach
    </div>
    
    <!-- JSON-LD structured data -->
    @schema('offer', ['offers' => $offers])
</div>
```

## API Endpoints

### Offer API Routes

```php
// Modules/Meetup/routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('events/{event}/offers', [OfferController::class, 'index']);
    Route::post('events/{event}/offers', [OfferController::class, 'store']);
    Route::get('offers/{offer}', [OfferController::class, 'show']);
    Route::put('offers/{offer}', [OfferController::class, 'update']);
    Route::delete('offers/{offer}', [OfferController::class, 'destroy']);
    
    // Ticketing routes
    Route::post('events/{event}/reserve', [ReservationController::class, 'store']);
    Route::get('reservations/{reservation}', [ReservationController::class, 'show']);
    Route::put('reservations/{reservation}', [ReservationController::class, 'update']);
    Route::post('reservations/{reservation}/confirm', [ReservationController::class, 'confirm']);
    
    // Pricing routes
    Route::get('events/{event}/pricing', [PricingController::class, 'calculate']);
    Route::post('discounts/validate', [DiscountController::class, 'validate']);
});
```

## Advanced Features

### Task 6: Subscription Model Integration

**Requirements**:
1. Season passes and memberships
2. Recurring billing
3. Usage-based pricing
4. Package deals and bundles
5. Loyalty points integration

### Task 7: Analytics and Reporting

**Requirements**:
1. Sales performance tracking
2. Conversion funnel analysis
3. Revenue optimization insights
4. A/B testing framework
5. Customer lifetime value tracking

## Best Practices

### 1. Pricing Strategy
- Use psychological pricing ($9.99 vs $10.00)
- Implement early bird discounts effectively
- Create scarcity and urgency indicators
- Offer clear value propositions
- Use dynamic pricing based on demand

### 2. User Experience
- Clear pricing display
- Simple checkout process
- Multiple payment options
- Mobile-optimized ticket interface
- Transparent fees and taxes

### 3. Technical Implementation
- Atomic pricing operations
- Real-time availability updates
- Scalable offer generation
- Efficient caching strategies
- Comprehensive error handling

### 4. Security and Compliance
- PCI DSS compliance for payments
- GDPR compliance for customer data
- Secure QR code generation
- Anti-fraud measures
- Tax compliance by region

## Testing Strategy

### Pricing Tests

```php
// tests/Unit/PricingServiceTest.php
public function test_dynamic_pricing_calculation()
{
    $event = Event::factory()->create(['type' => 'conference']);
    $pricingService = new PricingService();
    
    $context = [
        'days_to_event' => 30,  // High demand
        'current_registrations' => 150,
        'is_early_bird' => false
    ];
    
    $price = $pricingService->calculateEventPrice($event, $context);
    
    $this->assertEquals(150.00, $price); // Base conference price
}

public function test_early_bird_discount()
{
    $event = Event::factory()->create(['type' => 'conference']);
    $pricingService = new PricingService();
    
    $context = [
        'days_to_event' => 30,
        'is_early_bird' => true,
    ];
    
    $price = $pricingService->calculateEventPrice($event, $context);
    $expectedPrice = 150.00 * 0.8; // 20% discount
    
    $this->assertEquals($expectedPrice, $price);
}
```

## Next Steps

1. ✅ **Complete Offer Model Foundation** (Task 1)
2. ✅ **Build Ticketing System** (Task 2)
3. 🔄 **Implement Dynamic Pricing** (Task 3)
4. ⏳ **Add Multi-Currency Support** (Task 4)
5. ⏳ **Create Discount Engine** (Task 5)
6. 📈 **Analytics Integration** (Task 6-7)

This comprehensive implementation provides LaravelPizza with enterprise-grade ticketing, dynamic pricing, and monetization capabilities fully compliant with Schema.org Offer specifications and optimized for conversion and user experience.