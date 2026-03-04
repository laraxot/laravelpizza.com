# Schema.org Actions and RSVP Implementation

## Overview

This document provides comprehensive implementation guidance for Schema.org Action types (JoinAction, LeaveAction) and EventReservation for building a complete RSVP and event participation system in LaravelPizza.

## Core Action Types

### 1. JoinAction

Used when an agent (user) joins an event, group, or organization.

#### Key Properties
- `agent` (Person/Organization) - Who is joining
- `object` (Thing) - What they're joining (Event, Organization, etc.)
- `event` (Event) - Specific event being joined (alternative to object)
- `startTime` (DateTime) - When the join action occurred
- `actionStatus` (ActionStatusType) - Status of the action

#### Use Cases for LaravelPizza
- User RSVPs "Yes" to an event
- User joins a community/group
- User subscribes to event series
- User becomes a member of organization

### 2. LeaveAction

The inverse of JoinAction - when an agent leaves an event or group.

#### Key Properties
- `agent` (Person/Organization) - Who is leaving
- `object` (Thing) - What they're leaving
- `event` (Event) - Specific event being left
- `startTime` (DateTime) - When the leave action occurred
- `actionStatus` (ActionStatusType) - Status of the action

#### Use Cases for LaravelPizza
- User cancels RSVP (changes from "Yes" to "No")
- User leaves community/group
- User unsubscribes from event series
- User withdraws membership

### 3. EventReservation

Represents a confirmed reservation for an event.

#### Key Properties
- `reservationFor` (Event) - The event being reserved
- `reservationId` (Text) - Unique reservation identifier
- `reservationStatus` (ReservationStatusType) - Current status
- `underName` (Person/Organization) - Who the reservation is for
- `bookingTime` (DateTime) - When reservation was made
- `totalPrice` (Number/PriceSpecification) - Cost information
- `reservedTicket` (Ticket) - Associated ticket information

## Implementation Tasks

### Task 1: RSVP Action System

**Files**: 
- `Modules/Meetup/app/Actions/RSVPAction.php`
- `Modules/Meetup/app/Models/RSVP.php`

**Requirements**:
1. Create RSVP model tracking user responses
2. Implement JoinAction/LeaveAction logging
3. Handle RSVP status changes (Yes/No/Maybe)
4. Support for waitlist management
5. Event capacity management

**Implementation Checklist**:
- [ ] Create RSVP model with proper relationships
- [ ] Implement RSVPAction service
- [ ] Add capacity validation
- [ ] Create waitlist functionality
- [ ] Add RSVP status tracking
- [ ] Implement notification system

**RSVP Model Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class RSVP extends Model
{
    protected $fillable = [
        'user_id',
        'event_id',
        'status', // 'yes', 'no', 'maybe', 'waitlist'
        'response_time',
        'notes',
        'plus_ones', // Number of additional guests
        'waitlist_position'
    ];

    protected $casts = [
        'response_time' => 'datetime',
        'plus_ones' => 'integer',
        'waitlist_position' => 'integer'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function isConfirmed(): bool
    {
        return in_array($this->status, ['yes', 'maybe']);
    }

    public function isWaitlisted(): bool
    {
        return $this->status === 'waitlist';
    }
}
```

### Task 2: Action Logging Service

**File**: `Modules/Meetup/app/Services/ActionLogService.php`

**Requirements**:
1. Log all JoinAction/LeaveAction instances
2. Create JSON-LD structured data for actions
3. Store action history and analytics
4. Support for action status tracking

**Implementation Checklist**:
- [ ] Create ActionLogService
- [ ] Implement JoinAction logging
- [ ] Implement LeaveAction logging
- [ ] Add JSON-LD generation
- [ ] Create action history views
- [ ] Add analytics tracking

**Service Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Services;

use Modules\Meetup\Models\RSVP;
use Modules\Meetup\Models\Event;
use App\Models\User;

class ActionLogService
{
    public function logJoinAction(User $user, Event $event): void
    {
        $action = [
            '@context' => 'https://schema.org',
            '@type' => 'JoinAction',
            'agent' => [
                '@type' => 'Person',
                'name' => $user->name,
                'identifier' => $user->id
            ],
            'event' => [
                '@type' => 'Event',
                'name' => $event->name,
                'startDate' => $event->start_date->toIso8601String(),
                'identifier' => $event->id
            ],
            'startTime' => now()->toIso8601String(),
            'actionStatus' => 'https://schema.org/CompletedActionStatus'
        ];

        // Store action in database and/or send to analytics
        $this->storeAction($action, 'join', $user->id, $event->id);
    }

    public function logLeaveAction(User $user, Event $event): void
    {
        $action = [
            '@context' => 'https://schema.org',
            '@type' => 'LeaveAction',
            'agent' => [
                '@type' => 'Person',
                'name' => $user->name,
                'identifier' => $user->id
            ],
            'event' => [
                '@type' => 'Event',
                'name' => $event->name,
                'identifier' => $event->id
            ],
            'startTime' => now()->toIso8601String(),
            'actionStatus' => 'https://schema.org/CompletedActionStatus'
        ];

        $this->storeAction($action, 'leave', $user->id, $event->id);
    }

    private function storeAction(array $actionData, string $type, int $userId, int $eventId): void
    {
        // Implementation for storing actions
    }
}
```

### Task 3: Event Reservation System

**File**: `Modules/Meetup/app/Models/EventReservation.php`

**Requirements**:
1. Full EventReservation implementation
2. Ticket management integration
3. Pricing and payment support
4. Reservation status management
5. Confirmation and cancellation workflows

**Implementation Checklist**:
- [ ] Create EventReservation model
- [ ] Implement ticket generation
- [ ] Add pricing calculations
- [ ] Create status workflows
- [ ] Add email confirmations
- [ ] Implement cancellation policies

**Model Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventReservation extends Model
{
    protected $fillable = [
        'reservation_id',
        'user_id',
        'event_id',
        'reservation_status', // confirmed, pending, cancelled, etc.
        'booking_time',
        'total_price',
        'price_currency',
        'under_name', // For reservations made for others
        'notes',
        'ticket_data' // JSON for ticket information
    ];

    protected $casts = [
        'booking_time' => 'datetime',
        'total_price' => 'decimal:2',
        'ticket_data' => 'array'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function isActive(): bool
    {
        return in_array($this->reservation_status, ['confirmed', 'pending']);
    }

    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'EventReservation',
            'reservationId' => $this->reservation_id,
            'reservationStatus' => $this->getSchemaOrgStatus(),
            'underName' => [
                '@type' => 'Person',
                'name' => $this->user->name
            ],
            'reservationFor' => [
                '@type' => 'Event',
                'name' => $this->event->name,
                'startDate' => $this->event->start_date->toIso8601String(),
                'location' => $this->event->location ? $this->event->location->toSchemaOrg() : null
            ],
            'bookingTime' => $this->booking_time->toIso8601String(),
            'totalPrice' => $this->total_price,
            'priceCurrency' => $this->price_currency,
            'reservedTicket' => $this->ticket_data
        ];
    }

    private function getSchemaOrgStatus(): string
    {
        return match($this->reservation_status) {
            'confirmed' => 'https://schema.org/ReservationConfirmed',
            'pending' => 'https://schema.org/ReservationHold',
            'cancelled' => 'https://schema.org/ReservationCancelled',
            default => 'https://schema.org/ReservationPending'
        };
    }
}
```

### Task 4: RSVP Management Interface

**File**: `Modules/Meetup/app/Filament/Resources/RSVPResource.php`

**Requirements**:
1. RSVP CRUD operations
2. Waitlist management
3. Bulk operations (approve waitlist)
4. Communication tools
5. Analytics and reporting

**Implementation Checklist**:
- [ ] Create RSVPResource extending XotBaseResource
- [ ] Add RSVP status management
- [ ] Implement waitlist controls
- [ ] Create user communication tools
- [ ] Add RSVP analytics
- [ ] Build capacity management interface

### Task 5: Frontend RSVP Components

**Files**:
- `Themes/Meetup/resources/views/components/rsvp/form.blade.php`
- `Themes/Meetup/resources/views/components/rsvp/status.blade.php`
- `Themes/Meetup/resources/views/components/rsvp/attendees.blade.php`

**Requirements**:
1. RSVP submission forms
2. Status display components
3. Attendee lists with avatars
4. Social proof elements
5. Waitlist indicators

**Implementation Checklist**:
- [ ] Create RSVP form component
- [ ] Build status display
- [ ] Implement attendee list
- [ ] Add social proof indicators
- [ ] Create waitlist display
- [ ] Include Schema.org JSON-LD

## JSON-LD Implementation Examples

### JoinAction Example

```json
{
  "@context": "https://schema.org",
  "@type": "JoinAction",
  "agent": {
    "@type": "Person",
    "name": "Mario Rossi",
    "identifier": "user_123"
  },
  "event": {
    "@type": "Event",
    "name": "Laravel Meetup Milano",
    "startDate": "[DATE]T19:00:00+01:00",
    "identifier": "event_456"
  },
  "startTime": "[DATE]T10:30:00+01:00",
  "actionStatus": "https://schema.org/CompletedActionStatus"
}
```

### LeaveAction Example

```json
{
  "@context": "https://schema.org",
  "@type": "LeaveAction",
  "agent": {
    "@type": "Person",
    "name": "Mario Rossi",
    "identifier": "user_123"
  },
  "event": {
    "@type": "Event",
    "name": "Laravel Meetup Milano",
    "identifier": "event_456"
  },
  "startTime": "[DATE]T14:20:00+01:00",
  "actionStatus": "https://schema.org/CompletedActionStatus"
}
```

### EventReservation Example

```json
{
  "@context": "https://schema.org",
  "@type": "EventReservation",
  "reservationId": "LRM-[DATE]-001",
  "reservationStatus": "https://schema.org/ReservationConfirmed",
  "underName": {
    "@type": "Person",
    "name": "Mario Rossi"
  },
  "reservationFor": {
    "@type": "Event",
    "name": "Laravel Workshop: Advanced Eloquent",
    "startDate": "[DATE]T09:00:00+01:00",
    "endDate": "[DATE]T17:00:00+01:00",
    "location": {
      "@type": "Place",
      "name": "TechHub Training Center",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "Via Torino 45",
        "addressLocality": "Milano",
        "postalCode": "20158",
        "addressCountry": "IT"
      }
    }
  },
  "bookingTime": "[DATE]T10:30:00+01:00",
  "totalPrice": "50.00",
  "priceCurrency": "EUR",
  "reservedTicket": {
    "@type": "Ticket",
    "ticketNumber": "TKT-LRM-001",
    "ticketToken": "qrCode:LRM20260215001ABC123"
  }
}
```

## Database Schema

### RSVP Table

```sql
CREATE TABLE rsvps (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    event_id BIGINT NOT NULL,
    status ENUM('yes', 'no', 'maybe', 'waitlist') NOT NULL DEFAULT 'maybe',
    response_time TIMESTAMP NULL,
    notes TEXT NULL,
    plus_ones INT DEFAULT 0,
    waitlist_position INT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    
    UNIQUE KEY unique_user_event (user_id, event_id),
    INDEX idx_event_status (event_id, status),
    INDEX idx_waitlist (event_id, waitlist_position)
);
```

### Event Reservations Table

```sql
CREATE TABLE event_reservations (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    reservation_id VARCHAR(50) NOT NULL UNIQUE,
    user_id BIGINT NOT NULL,
    event_id BIGINT NOT NULL,
    reservation_status ENUM('pending', 'confirmed', 'cancelled', 'completed') NOT NULL DEFAULT 'pending',
    booking_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    total_price DECIMAL(10,2) NULL,
    price_currency CHAR(3) DEFAULT 'EUR',
    under_name VARCHAR(255) NULL, // For reservations made for others
    notes TEXT NULL,
    ticket_data JSON NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    
    INDEX idx_user_reservations (user_id),
    INDEX idx_event_reservations (event_id),
    INDEX idx_status (reservation_status),
    INDEX idx_booking_time (booking_time)
);
```

### Action Logs Table

```sql
CREATE TABLE action_logs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,
    event_id BIGINT NOT NULL,
    action_type ENUM('join', 'leave', 'rsvp_update', 'reservation') NOT NULL,
    action_data JSON NOT NULL, // Store full Schema.org action data
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    
    INDEX idx_user_actions (user_id, action_type),
    INDEX idx_event_actions (event_id, action_type),
    INDEX idx_created_at (created_at)
);
```

## Frontend Integration

### RSVP Form Component

```php
// Themes/Meetup/resources/views/components/rsvp/form.blade.php
@props([
    'event' => App\Models\Event::class,
    'userRsvp' => Modules\Meetup\Models\RSVP::class
])

<div x-data="{ rsvp: @entangle('userRsvp') }" class="rsvp-form">
    <h3>{{ __('meetup::rsvp.title') }}</h3>
    
    <div class="space-y-4">
        <div class="flex space-x-4">
            <label class="flex items-center">
                <input type="radio" name="rsvp" value="yes" x-model="rsvp.status" 
                       {{ $userRsvp?->status === 'yes' ? 'checked' : '' }}>
                <span>{{ __('meetup::rsvp.yes') }}</span>
            </label>
            
            <label class="flex items-center">
                <input type="radio" name="rsvp" value="maybe" x-model="rsvp.status"
                       {{ $userRsvp?->status === 'maybe' ? 'checked' : '' }}>
                <span>{{ __('meetup::rsvp.maybe') }}</span>
            </label>
            
            <label class="flex items-center">
                <input type="radio" name="rsvp" value="no" x-model="rsvp.status"
                       {{ $userRsvp?->status === 'no' ? 'checked' : '' }}>
                <span>{{ __('meetup::rsvp.no') }}</span>
            </label>
        </div>
        
        @if($event->allows_plus_ones)
        <div>
            <label>{{ __('meetup::rsvp.plus_ones') }}</label>
            <input type="number" x-model="rsvp.plus_ones" min="0" 
                   max="{{ $event->max_plus_ones ?? 3 }}" class="form-input">
        </div>
        @endif
        
        <div>
            <label>{{ __('meetup::rsvp.notes') }}</label>
            <textarea x-model="rsvp.notes" rows="3" class="form-textarea"></textarea>
        </div>
        
        @if($userRsvp?->isWaitlisted())
        <div class="waitlist-notice">
            <p>{{ __('meetup::rsvp.waitlist_position', ['position' => $userRsvp->waitlist_position]) }}</p>
        </div>
        @endif
        
        <button type="button" @click="submitRSVP" 
                class="btn btn-primary">
            {{ __('meetup::rsvp.submit') }}
        </button>
    </div>
    
    <!-- Schema.org JoinAction/LeaveAction JSON-LD -->
    @schema('action', ['type' => $userRsvp?->status === 'yes' ? 'JoinAction' : 'LeaveAction', 
                         'user' => auth()->user(), 'event' => $event])
</div>
```

## API Endpoints

### RSVP API Routes

```php
// Modules/Meetup/routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::post('events/{event}/rsvp', [RSVPController::class, 'store']);
    Route::put('events/{event}/rsvp', [RSVPController::class, 'update']);
    Route::delete('events/{event}/rsvp', [RSVPController::class, 'destroy']);
    Route::get('events/{event}/attendees', [RSVPController::class, 'attendees']);
});

// Reservation API routes
Route::post('events/{event}/reserve', [ReservationController::class, 'store']);
Route::get('reservations/{reservation}', [ReservationController::class, 'show']);
Route::put('reservations/{reservation}', [ReservationController::class, 'update']);
Route::delete('reservations/{reservation}', [ReservationController::class, 'cancel']);
```

## Advanced Features

### Task 6: Smart Waitlist Management

**Requirements**:
1. Automatic promotion from waitlist
2. Notification system for openings
3. Time-based reservations
4. Priority management

**Implementation Checklist**:
- [ ] Implement automatic waitlist promotion
- [ ] Create notification workflows
- [ ] Add time-based reservation expiry
- [ ] Build priority scoring system
- [ ] Add analytics for waitlist conversion

### Task 7: Social RSVP Integration

**Requirements**:
1. Social sharing of RSVPs
2. Friend invitation system
3. Group registration
4. Social proof features

**Implementation Checklist**:
- [ ] Add social sharing buttons
- [ ] Implement friend invitations
- [ ] Create group registration flow
- [ ] Build social proof displays
- [ ] Add referral tracking

## Best Practices

### 1. Privacy Considerations
- Never display full user lists publicly
- Provide privacy controls for RSVP visibility
- Implement proper data anonymization
- Respect user communication preferences

### 2. Performance Optimization
- Cache RSVP counts and attendee lists
- Use database indexes effectively
- Implement real-time updates efficiently
- Optimize for mobile devices

### 3. User Experience
- Provide clear RSVP status indicators
- Offer easy RSVP modification
- Include waitlist transparency
- Add calendar integration

### 4. Accessibility
- Ensure form accessibility
- Provide screen reader support
- Include keyboard navigation
- Add high contrast options

## Testing Strategy

### RSVP System Tests

```php
// tests/Feature/RSVPTest.php
public function test_user_can_rsvp_yes_to_event()
{
    $user = User::factory()->create();
    $event = Event::factory()->create(['maximum_attendee_capacity' => 10]);
    
    $response = $this->actingAs($user)
        ->postJson("/api/events/{$event->id}/rsvp", [
            'status' => 'yes',
            'plus_ones' => 0
        ]);
    
    $response->assertStatus(200);
    $this->assertDatabaseHas('rsvps', [
        'user_id' => $user->id,
        'event_id' => $event->id,
        'status' => 'yes'
    ]);
}

public function test_waitlist_promotion()
{
    // Test automatic promotion from waitlist
}

public function test_rsvp_capacity_limits()
{
    // Test capacity enforcement
}
```

## Next Steps

1. Implement RSVP system foundation (Task 1-2)
2. Build reservation management (Task 3-4)
3. Create frontend components (Task 5)
4. Add advanced features (Task 6-7)

This implementation will provide LaravelPizza with a complete, Schema.org compliant RSVP and reservation system that enhances user engagement and provides robust event management capabilities.