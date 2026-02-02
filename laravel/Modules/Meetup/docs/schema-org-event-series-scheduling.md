# Schema.org EventSeries and Scheduling Implementation

## Overview

This document provides comprehensive guidance for implementing EventSeries and scheduling functionality based on Schema.org specifications. EventSeries allows for efficient management of recurring events while maintaining structured data compliance.

## EventSeries Architecture

### Core Concepts

An EventSeries represents:
1. **Recurring Events** - Weekly meetups, monthly workshops
2. **Event Collections** - Conferences with multiple sessions
3. **Thematic Series** - Events sharing common topics or themes
4. **Multi-day Events** - Festivals spanning multiple days

### EventSeries vs Individual Events

| Use Case | EventSeries | Individual Event |
|-----------|-------------|-----------------|
| Weekly Laravel Meetup | ✅ | ❌ |
| One-time Conference | ❌ | ✅ |
| Multi-day Festival | ✅ (as series) | ✅ (as sub-events) |
| Monthly Workshop Series | ✅ | ❌ |

## Implementation Tasks

### Task 1: EventSeries Model Design

**File**: `Modules/Meetup/app/Models/EventSeries.php`

**Requirements**:
1. Extend base Model with Laraxot patterns
2. Support for all Schedule properties
3. Relationship to Event instances
4. Validation for schedule constraints

**Implementation Checklist**:
- [ ] Create EventSeries model with strict typing
- [ ] Implement schedule properties as JSON fields
- [ ] Add validation for ISO 8601 durations
- [ ] Create relationship methods to Event model
- [ ] Implement schedule generation methods
- [ ] Add scope methods for active/inactive series

**Model Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class EventSeries extends Model
{
    protected $fillable = [
        'name',
        'description', 
        'start_date',
        'end_date',
        'repeat_frequency',
        'by_day',
        'by_month_day',
        'start_time',
        'end_time',
        'repeat_count',
        'schedule_timezone',
        'exceptions', // JSON array of exception dates
        'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date', 
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'by_day' => 'array',
        'by_month_day' => 'array',
        'exceptions' => 'array',
        'is_active' => 'boolean'
    ];

    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'series_id');
    }

    public function generateOccurrences(Carbon $from, Carbon $to): Collection
    {
        // Implementation for generating event instances
    }
}
```

### Task 2: Schedule Parser Service

**File**: `Modules/Meetup/app/Services/ScheduleParserService.php`

**Requirements**:
1. Parse ISO 8601 repeat frequencies
2. Handle complex recurrence rules
3. Generate occurrence dates
4. Manage timezone conversions
5. Handle exceptions and special cases

**Implementation Checklist**:
- [ ] Implement ISO 8601 duration parser
- [ ] Create recurrence engine
- [ ] Add timezone handling
- [ ] Implement date exceptions
- [ ] Add validation for impossible schedules
- [ ] Create performance optimizations

**Service Structure**:
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Services;

use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ScheduleParserService
{
    public function parseFrequency(string $frequency): CarbonInterval
    {
        // Parse P1W, P1M, P1D, etc.
    }

    public function generateOccurrences(
        Carbon $startDate,
        Carbon $endDate,
        string $frequency,
        ?array $byDay = null,
        ?array $byMonthDay = null,
        ?int $repeatCount = null,
        array $exceptions = [],
        string $timezone = 'UTC'
    ): array {
        // Generate all valid occurrences
    }

    public function validateSchedule(array $scheduleData): bool
    {
        // Validate schedule constraints
    }
}
```

### Task 3: Event Generation Service

**File**: `Modules/Meetup/app/Services/EventGenerationService.php`

**Requirements**:
1. Create Event instances from EventSeries
2. Update existing events when schedule changes
3. Handle schedule modifications gracefully
4. Manage event deletion for removed occurrences

**Implementation Checklist**:
- [ ] Create events from series schedule
- [ ] Update existing events when series changes
- [ ] Handle past vs future event updates
- [ ] Implement conflict resolution
- [ ] Add event deletion for removed dates
- [ ] Create batch processing for performance

### Task 4: EventSeries Filament Resource

**File**: `Modules/Meetup/app/Filament/Resources/EventSeriesResource.php`

**Requirements**:
1. Form for series configuration
2. Schedule builder interface
3. Preview of generated events
4. Bulk event management
5. Status monitoring

**Implementation Checklist**:
- [ ] Create EventSeriesResource extending XotBaseResource
- [ ] Build schedule configuration form
- [ ] Add recurrence pattern builder
- [ ] Implement event preview functionality
- [ ] Add exception date management
- [ ] Create series status dashboard

## Schema.org JSON-LD Implementation

### Basic EventSeries Example

```json
{
  "@context": "https://schema.org",
  "@type": "EventSeries",
  "name": "Laravel Weekly Meetups",
  "description": "Weekly gatherings for Laravel developers to share knowledge and network",
  "startDate": "2026-01-01",
  "endDate": "2026-12-31",
  "eventSchedule": {
    "@type": "Schedule",
    "startDate": "2026-01-01",
    "endDate": "2026-12-31",
    "repeatFrequency": "P1W",
    "byDay": "https://schema.org/Thursday",
    "startTime": "19:00:00",
    "endTime": "21:00:00",
    "scheduleTimezone": "Europe/Rome"
  },
  "location": {
    "@type": "Place",
    "name": "TechHub Milano",
    "address": {
      "@type": "PostalAddress",
      "streetAddress": "Via Roma 123",
      "addressLocality": "Milano",
      "postalCode": "20121",
      "addressCountry": "IT"
    }
  },
  "organizer": {
    "@type": "Organization",
    "name": "Laravel Italy Community",
    "url": "https://laravel-italia.it"
  },
  "subEvent": [
    {
      "@type": "Event",
      "name": "Laravel Meetup - February 2026",
      "startDate": "2026-02-05T19:00:00+01:00",
      "endDate": "2026-02-05T21:00:00+01:00"
    }
  ]
}
```

### Complex Schedule Example

```json
{
  "@context": "https://schema.org",
  "@type": "EventSeries",
  "name": "Laravel Advanced Workshop Series",
  "description": "Monthly deep-dive workshops on advanced Laravel topics",
  "eventSchedule": [
    {
      "@type": "Schedule",
      "startDate": "2026-01-15",
      "endDate": "2026-06-15",
      "repeatFrequency": "P1M",
      "byMonthDay": [15],
      "startTime": "18:30:00",
      "endTime": "20:30:00",
      "scheduleTimezone": "Europe/Rome"
    },
    {
      "@type": "Schedule",
      "startDate": "2026-07-01",
      "endDate": "2026-12-31",
      "repeatFrequency": "P1M",
      "byDay": "2TU",
      "startTime": "19:00:00", 
      "endTime": "21:00:00",
      "scheduleTimezone": "Europe/Rome"
    }
  ],
  "subEvent": [
    {
      "@type": "EducationEvent",
      "name": "Advanced Laravel Performance Optimization",
      "startDate": "2026-01-15T18:30:00+01:00",
      "endDate": "2026-01-15T20:30:00+01:00",
      "teaches": "Laravel performance optimization techniques"
    }
  ]
}
```

## Database Schema

### EventSeries Table

```sql
CREATE TABLE event_series (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    start_date DATE NOT NULL,
    end_date DATE NULL,
    repeat_frequency VARCHAR(20) NOT NULL, -- P1W, P1M, P2W, etc.
    by_day JSON NULL, -- ["Monday", "Wednesday"] or ["2MO", "4WE"]
    by_month_day JSON NULL, -- [1, 15] or specific days
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    repeat_count INT NULL, -- Limit number of occurrences
    schedule_timezone VARCHAR(50) NOT NULL DEFAULT 'UTC',
    exceptions JSON NULL, -- Exception dates to skip
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_active_dates (is_active, start_date, end_date),
    INDEX idx_timezone (schedule_timezone)
);

-- Update events table to reference series
ALTER TABLE events 
ADD COLUMN series_id BIGINT NULL,
ADD FOREIGN KEY (series_id) REFERENCES event_series(id) ON DELETE SET NULL,
ADD INDEX idx_series (series_id);
```

## Frontend Integration

### Task 5: EventSeries Display Components

**File**: `Themes/Meetup/resources/views/components/blocks/event-series.blade.php`

**Requirements**:
1. Display series information
2. Show upcoming occurrences
3. Individual event registration
4. Series subscription options

**Implementation Checklist**:
- [ ] Create EventSeries display component
- [ ] Add upcoming events list
- [ ] Implement individual event registration
- [ ] Add series subscription functionality
- [ ] Include JSON-LD structured data
- [ ] Add calendar integration buttons

### Task 6: Schedule Builder Interface

**File**: `Themes/Meetup/resources/views/components/forms/schedule-builder.blade.php`

**Requirements**:
1. Visual schedule configuration
2. Recurrence pattern selection
3. Exception date management
4. Preview functionality

**Implementation Checklist**:
- [ ] Create recurrence pattern selector
- [ ] Add day/month picker
- [ ] Implement exception date picker
- [ ] Add timezone selector
- [ ] Create live preview component
- [ ] Add validation feedback

## API Endpoints

### Task 7: EventSeries API

**File**: `Modules/Meetup/app/Http/Controllers/Api/EventSeriesController.php`

**Requirements**:
1. CRUD operations for EventSeries
2. Schedule generation endpoints
3. Occurrence listing APIs
4. Subscription management

**Implementation Checklist**:
- [ ] Create EventSeries CRUD endpoints
- [ ] Add schedule generation API
- [ ] Implement occurrence listing
- [ ] Add subscription endpoints
- [ ] Include Schema.org formatted responses
- [ ] Add pagination and filtering

**API Routes**:
```php
// EventSeries routes
Route::apiResource('event-series', EventSeriesController::class);
Route::get('event-series/{id}/occurrences', [EventSeriesController::class, 'occurrences']);
Route::post('event-series/{id}/generate', [EventSeriesController::class, 'generateEvents']);
Route::post('event-series/{id}/subscribe', [EventSeriesController::class, 'subscribe']);
```

## Advanced Features

### Task 8: Smart Scheduling

**Requirements**:
1. Conflict detection and resolution
2. Optimal time suggestions
3. Holiday and blackout management
4. Multi-timezone support

**Implementation Checklist**:
- [ ] Add venue availability checking
- [ ] Implement conflict detection
- [ ] Create smart scheduling suggestions
- [ ] Add holiday calendar integration
- [ ] Handle timezone complexities
- [ ] Add availability notifications

### Task 9: Series Analytics

**Requirements**:
1. Attendance tracking across series
2. Performance metrics
3. Trend analysis
4. Predictive analytics

**Implementation Checklist**:
- [ ] Track attendance patterns
- [ ] Calculate engagement metrics
- [ ] Create trend analysis
- [ ] Add predictive capabilities
- [ ] Generate series reports
- [ ] Create dashboard visualizations

## Testing Strategy

### Task 10: Comprehensive Testing

**File**: `tests/Feature/EventSeriesTest.php`

**Requirements**:
1. Unit tests for schedule generation
2. Feature tests for API endpoints
3. Integration tests with Filament
4. Performance tests for large datasets

**Implementation Checklist**:
- [ ] Test schedule parsing accuracy
- [ ] Verify event generation
- [ ] Test API endpoints
- [ ] Validate JSON-LD output
- [ ] Performance test large series
- [ ] Test edge cases and errors

**Test Cases**:
```php
public function test_weekly_schedule_generation()
{
    $series = EventSeries::factory()->create([
        'repeat_frequency' => 'P1W',
        'by_day' => ['Thursday'],
        'start_time' => '19:00:00',
        'end_time' => '21:00:00'
    ]);
    
    $occurrences = $series->generateOccurrences(
        Carbon::parse('2026-02-01'),
        Carbon::parse('2026-02-28')
    );
    
    $this->assertCount(4, $occurrences); // 4 Thursdays in February 2026
}
```

## Best Practices

### 1. Schedule Validation
- Always validate ISO 8601 formats
- Check for impossible date combinations
- Validate timezone identifiers
- Prevent infinite recurrence

### 2. Performance Optimization
- Cache generated occurrences
- Use database indexes effectively
- Implement lazy loading for large datasets
- Consider background processing

### 3. Error Handling
- Provide clear error messages
- Handle timezone mismatches gracefully
- Manage schedule conflicts appropriately
- Log generation failures

### 4. User Experience
- Provide clear schedule previews
- Offer multiple recurrence patterns
- Include easy exception management
- Add timezone auto-detection

## Migration Path

### Phase 1: Basic EventSeries
1. Create EventSeries model and migration
2. Implement basic schedule parsing
3. Add simple Filament interface
4. Create basic JSON-LD output

### Phase 2: Advanced Features
1. Add complex schedule patterns
2. Implement exception handling
3. Create comprehensive API
4. Add frontend components

### Phase 3: Analytics & Optimization
1. Add analytics tracking
2. Implement smart scheduling
3. Create advanced reporting
4. Optimize performance

## Next Steps

1. Implement EventSeries model (Task 1)
2. Create ScheduleParserService (Task 2)
3. Build EventGenerationService (Task 3)
4. Develop Filament resource (Task 4)
5. Add frontend components (Task 5-6)

This implementation will provide LaravelPizza with world-class event scheduling capabilities, fully compliant with Schema.org specifications and optimized for both user experience and developer productivity.