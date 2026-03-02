# Schema.org Event Implementation Guide

## Overview

This document provides comprehensive implementation guidance for Schema.org Event types in the LaravelPizza project, based on the official Schema.org specifications. It covers Event, EventSeries, scheduling, actions, and related entities for building a robust meetup and event management system.

## Core Schema.org Event Types

### 1. Event (Base Type)

The foundational Event type with essential properties:

#### Required Properties
- `name` (Text) - Event title/name
- `startDate` (DateTime/Date) - Event start time in ISO 8601 format
- `location` (Place/VirtualLocation/Text) - Where the event occurs

#### Highly Recommended Properties
- `endDate` (DateTime/Date) - Event end time
- `description` (Text) - Event description
- `url` (URL) - Event page URL
- `eventStatus` (EventStatusType) - Current status (scheduled, cancelled, etc.)
- `eventAttendanceMode` (EventAttendanceModeEnumeration) - Online/offline/mixed

#### Optional but Important Properties
- `organizer` (Organization/Person) - Who organizes the event
- `performer` (Organization/Person) - Speakers/presenters
- `offers` (Offer) - Ticket/pricing information
- `maximumAttendeeCapacity` (Integer) - Venue capacity limits
- `remainingAttendeeCapacity` (Integer) - Available spots
- `image` (ImageObject/URL) - Event images
- `keywords` (Text/DefinedTerm) - Tags and categories

### 2. EventSeries

For recurring events or event collections:

#### Key Properties
- `subEvent` (Event) - Individual events in the series
- `superEvent` (Event) - Parent event/series
- `eventSchedule` (Schedule) - Recurrence patterns

#### Use Cases
- Weekly/monthly meetups
- Multi-day conferences
- Event series with common theme

### 3. Schedule (for Recurring Events)

Defines repeat patterns for events using `eventSchedule`:

#### Core Properties
- `startDate` (Date) - When schedule starts
- `endDate` (Date) - When schedule ends (optional)
- `repeatFrequency` (Duration) - ISO 8601 repeat frequency (P1W = weekly, P1M = monthly)
- `byDay` (DayOfWeek) - Days of week (Monday, Tuesday, etc.)
- `byMonthDay` (Integer) - Days of month (1, 15, etc.)
- `startTime` (Time) - Start time each occurrence
- `endTime` (Time) - End time each occurrence
- `repeatCount` (Integer) - Number of occurrences (optional)
- `scheduleTimezone` (Text) - Timezone identifier

## Implementation Tasks

### Task 1: Enhanced Event Model with Schema.org Properties

**File**: `Modules/Meetup/app/Models/Event.php`

**Requirements**:
1. Add all Schema.org properties as model attributes
2. Implement casts for proper data types
3. Add relationships for organizer, performers, location
4. Support for both single events and event series

**Implementation Checklist**:
- [ ] Add schema.org properties to $fillable array
- [ ] Implement datetime casting for date fields
- [ ] Create relationships to User, Organization, Place models
- [ ] Add scope methods for common queries (upcoming, past, etc.)
- [ ] Implement event status validation
- [ ] Add attendance mode validation

### Task 2: EventSeries Management System

**File**: `Modules/Meetup/app/Models/EventSeries.php`

**Requirements**:
1. Extend Event model or create separate model
2. Handle event recurrence patterns
3. Generate individual event instances from schedules
4. Manage series-level properties

**Implementation Checklist**:
- [ ] Create EventSeries model with proper inheritance
- [ ] Implement Schedule parsing and validation
- [ ] Create service to generate event instances
- [ ] Handle schedule modifications and updates
- [ ] Add Series-specific Filament resource

### Task 3: Schedule Parser Service

**File**: `Modules/Meetup/app/Services/ScheduleParserService.php`

**Requirements**:
1. Parse ISO 8601 repeat frequencies
2. Handle complex recurrence patterns
3. Generate occurrence dates/times
4. Validate schedule constraints

**Implementation Checklist**:
- [ ] Implement ISO 8601 duration parsing
- [ ] Create date recurrence algorithms
- [ ] Handle timezone conversions
- [ ] Add validation for impossible schedules
- [ ] Support exceptions and special dates

### Task 4: Enhanced Event Filament Resources

**File**: `Modules/Meetup/app/Filament/Resources/EventResource.php`

**Requirements**:
1. Support all Schema.org properties
2. Event series management interface
3. Schedule configuration forms
4. Validation and error handling

**Implementation Checklist**:
- [ ] Add form fields for all Schema.org properties
- [ ] Create schedule configuration component
- [ ] Implement event series wizard
- [ ] Add real-time validation
- [ ] Create preview mode for structured data

## JSON-LD Structured Data Implementation

### Basic Event JSON-LD Template

```json
{
  "@context": "https://schema.org",
  "@type": "Event",
  "name": "Laravel Meetup Milano",
  "description": "Monthly gathering for Laravel developers",
  "startDate": "[DATE]T19:00:00+01:00",
  "endDate": "[DATE]T21:00:00+01:00",
  "eventAttendanceMode": "https://schema.org/OfflineEventAttendanceMode",
  "eventStatus": "https://schema.org/EventScheduled",
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
  "offers": {
    "@type": "Offer",
    "price": "0",
    "priceCurrency": "EUR",
    "availability": "https://schema.org/InStock"
  }
}
```

### EventSeries with Schedule JSON-LD

```json
{
  "@context": "https://schema.org",
  "@type": "EventSeries",
  "name": "Laravel Weekly Meetups",
  "description": "Weekly Laravel developer gatherings",
  "eventSchedule": {
    "@type": "Schedule",
    "startDate": "[DATE]",
    "endDate": "[DATE]",
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
  }
}
```

## Frontend Integration Tasks

### Task 5: Schema.org Component for Blade

**File**: `Themes/Meetup/resources/views/components/schema/event.blade.php`

**Requirements**:
1. Generate JSON-LD structured data
2. Support both Event and EventSeries
3. Include all relevant properties
4. Handle validation and errors

**Implementation Checklist**:
- [ ] Create base Schema.org component
- [ ] Implement Event type rendering
- [ ] Add EventSeries support
- [ ] Include proper escaping and validation
- [ ] Add debug mode for development

### Task 6: Event Page SEO Enhancement

**Files**: 
- `Themes/Meetup/resources/views/pages/events/[slug].blade.php`
- `Themes/Meetup/resources/views/components/blocks/event-details.blade.php`

**Requirements**:
1. Include JSON-LD structured data
2. Meta tags for social sharing
3. Open Graph and Twitter Cards
4. Rich snippets for search engines

**Implementation Checklist**:
- [ ] Add JSON-LD component to event pages
- [ ] Implement dynamic meta tags
- [ ] Add social sharing metadata
- [ ] Test with Google Rich Results Test
- [ ] Add breadcrumb navigation

## API and Data Management Tasks

### Task 7: Enhanced Event API Endpoints

**File**: `Modules/Meetup/app/Http/Controllers/Api/EventController.php`

**Requirements**:
1. Support Schema.org properties in API responses
2. Event series endpoints
3. Schedule parsing and generation
4. Filter and search capabilities

**Implementation Checklist**:
- [ ] Create comprehensive event API
- [ ] Add Schema.org formatted responses
- [ ] Implement event series endpoints
- [ ] Add filtering by dates, location, etc.
- [ ] Include pagination and sorting

### Task 8: Search Integration with Schema.org

**File**: `Modules/Meetup/app/Services/EventSearchService.php`

**Requirements**:
1. Index events with Schema.org properties
2. Faceted search capabilities
3. Geographic search with GeoCircle
4. Category and keyword search

**Implementation Checklist**:
- [ ] Implement Elasticsearch/Algolia integration
- [ ] Add Schema.org property mapping
- [ ] Create search filters and facets
- [ ] Implement geographic search
- [ ] Add autocomplete suggestions

## Testing and Quality Assurance

### Task 9: Schema.org Validation Tests

**File**: `tests/Unit/SchemaOrg/EventTest.php`

**Requirements**:
1. Validate JSON-LD structure
2. Test required properties
3. Verify data types and formats
4. Test with Google validation tools

**Implementation Checklist**:
- [ ] Create unit tests for JSON-LD generation
- [ ] Add Schema.org validation tests
- [ ] Test edge cases and error conditions
- [ ] Implement automated validation
- [ ] Add integration tests with Google tools

### Task 10: Performance Optimization

**Requirements**:
1. Efficient JSON-LD generation
2. Caching for structured data
3. Database query optimization
4. Fast API responses

**Implementation Checklist**:
- [ ] Implement caching for JSON-LD data
- [ ] Optimize database queries
- [ ] Add lazy loading for large datasets
- [ ] Monitor and optimize performance
- [ ] Add CDN integration for assets

## Migration and Database Updates

### Required Database Schema Changes

```sql
-- Enhanced events table with Schema.org properties
ALTER TABLE events 
ADD COLUMN event_status VARCHAR(50) DEFAULT 'EventScheduled',
ADD COLUMN attendance_mode VARCHAR(50) DEFAULT 'OfflineEventAttendanceMode',
ADD COLUMN previous_start_date DATETIME NULL,
ADD COLUMN door_time TIME NULL,
ADD COLUMN typical_age_range VARCHAR(20) NULL,
ADD COLUMN is_accessible_for_free BOOLEAN DEFAULT FALSE,
ADD COLUMN maximum_physical_attendee_capacity INT NULL,
ADD COLUMN maximum_virtual_attendee_capacity INT NULL,
ADD COLUMN remaining_attendee_capacity INT NULL;

-- Event series table
CREATE TABLE event_series (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE NULL,
    repeat_frequency VARCHAR(20) NOT NULL,
    by_day JSON NULL,
    by_month_day JSON NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    repeat_count INT NULL,
    schedule_timezone VARCHAR(50) NOT NULL DEFAULT 'UTC',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Event schedule relationship
CREATE TABLE event_schedules (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    event_id BIGINT NOT NULL,
    schedule_id BIGINT NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE,
    FOREIGN KEY (schedule_id) REFERENCES event_series(id) ON DELETE CASCADE
);
```

## Best Practices and Guidelines

### 1. Always Use Valid ISO 8601 Formats
- Dates: `[DATE]`
- DateTimes: `[DATE]T19:00:00+01:00`
- Durations: `PT2H` (2 hours), `P1W` (1 week)

### 2. Use Proper Schema.org URLs
- EventStatus: `https://schema.org/EventScheduled`
- AttendanceMode: `https://schema.org/OfflineEventAttendanceMode`
- Days: `https://schema.org/Monday`

### 3. Include All Required Properties
- Always validate required fields before saving
- Use validation rules in models and forms
- Provide helpful error messages

### 4. Handle Multiple Languages
- Use language-specific properties where available
- Implement proper content negotiation
- Include hreflang links where appropriate

### 5. Performance Considerations
- Cache generated JSON-LD
- Minimize database queries
- Use lazy loading for large datasets

## Next Steps

1. Implement the Event model enhancements (Task 1)
2. Create the EventSeries management system (Task 2)
3. Build the Schedule parser service (Task 3)
4. Update Filament resources (Task 4)
5. Add frontend JSON-LD components (Task 5-6)

This implementation will make LaravelPizza fully compliant with Schema.org Event specifications, improving SEO and enabling better integration with search engines, calendar applications, and event discovery platforms.