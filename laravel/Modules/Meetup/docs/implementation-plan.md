# Meetup Module Implementation Plan

## Overview
This document outlines the implementation steps for creating a Meetup module that replicates the functionality found in the laravelpizza.com website, using the existing modular architecture of the Laravel application.

## Core Features to Implement

### 1. Event Management System
- **Event Creation**: Allow users to create meetup events with details like title, description, date, time, location, capacity
- **Event Types**: Different types of meetups (social, educational, networking, etc.)
- **Event Status**: Draft, published, cancelled, completed states
- **Registration System**: User RSVP functionality with waitlist support

### 2. Calendar & Scheduling
- **Calendar View**: FullCalendar integration for viewing events chronologically
- **Scheduling Logic**: Prevent overlapping events, manage time slots
- **Recurring Events**: Support for recurring meetups (weekly, monthly, etc.)

### 3. Location & Venue Management
- **Venue Information**: Address, capacity, amenities, directions
- **Geolocation**: Map integration using the existing Geo module
- **Virtual Events**: Support for online meetups with video link integration

### 4. User Management
- **Attendee Management**: RSVP tracking, attendee lists, check-in functionality
- **Role-based Access**: Organizers, participants, administrators
- **Notifications**: Email/SMS notifications for event updates, reminders

## Technical Implementation

### Database Schema
```php
// Events table
- id (primary key)
- title (string)
- description (text)
- start_time (datetime)
- end_time (datetime)
- timezone (string)
- location_name (string)
- location_address (text)
- location_lat (decimal)
- location_lng (decimal)
- capacity (integer)
- status (enum: draft, published, cancelled, completed)
- type (enum: social, educational, networking, etc.)
- is_recurring (boolean)
- recurring_pattern (json)
- organizer_id (foreign key to users)
- created_at, updated_at, deleted_at (timestamps)

// Event registrations table
- id (primary key)
- event_id (foreign key)
- user_id (foreign key)
- status (enum: pending, confirmed, cancelled, attended)
- registration_date (datetime)
- created_at, updated_at (timestamps)

// Event categories table
- id (primary key)
- name (string)
- slug (string)
- description (text)
- created_at, updated_at (timestamps)
```

### Module Structure
```
Modules/Meetup/
├── app/
│   ├── Actions/              # Business logic actions
│   ├── Console/              # Commands
│   ├── Events/               # Event classes
│   ├── Exceptions/           # Custom exceptions
│   ├── Http/                 # Controllers, requests, middleware
│   ├── Models/               # Eloquent models
│   ├── Observers/            # Model observers
│   ├── Policies/             # Authorization policies
│   ├── Providers/            # Service providers
│   ├── Services/             # Complex business services
│   └── View/                 # Components, composers
├── config/
├── database/
│   ├── factories/            # Model factories
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── docs/                     # Documentation (this file)
├── resources/
│   ├── js/                   # JavaScript
│   ├── lang/                 # Language files
│   ├── sass/                 # Stylesheets
│   └── views/                # Blade templates
├── routes/
│   ├── api.php               # API routes
│   ├── channels.php          # Broadcasting channels
│   ├── console.php           # Console routes
│   └── web.php               # Web routes
├── tests/                    # Test files
├── composer.json
├── module.json               # Module configuration
└── package.json
```

### Key Models to Create

#### Event Model (`app/Models/Event.php`)
- Properties: title, description, start_time, end_time, location, capacity, status, etc.
- Relationships: belongsTo organizer (User), hasMany registrations
- Scopes: upcoming, past, byDateRange, byStatus, nearLocation

#### EventRegistration Model (`app/Models/EventRegistration.php`)
- Properties: event_id, user_id, status, registration_date
- Relationships: belongsTo event, belongsTo user
- Scopes: confirmed, pending, cancelled

#### EventCategory Model (`app/Models/EventCategory.php`)
- Properties: name, slug, description
- Relationships: hasMany events

### Implementation Steps

#### Phase 1: Basic Event Management
1. **Create Database Migrations**
   - Events table
   - Event registrations table
   - Event categories table

2. **Create Models**
   - Event model with proper relationships and scopes
   - EventRegistration model
   - EventCategory model

3. **Create Factories & Seeders**
   - EventFactory
   - EventRegistrationFactory
   - EventCategoryFactory
   - MeetupModuleSeeder

4. **Create Actions**
   - CreateEventAction
   - UpdateEventAction
   - DeleteEventAction
   - RegisterForEventAction
   - CancelRegistrationAction

5. **Create Form Requests**
   - StoreEventRequest
   - UpdateEventRequest
   - RegisterForEventRequest

#### Phase 2: Calendar & Frontend
1. **Create Folio Pages** (NO Controllers)
   - `resources/views/pages/events.blade.php` (Folio routing: `/events`)
   - `resources/views/pages/events/[event].blade.php` (Folio routing: `/events/{event}`)
   - `resources/views/pages/calendar.blade.php` (Folio routing: `/calendar`)
   - Componenti Volt integrati nelle pagine per interattività

2. **Create Volt Components**
   - Event listing component (`@volt('events')`)
   - Event detail component (`@volt('event-detail')`)
   - Event registration component (`@volt('event-registration')`)
   - Calendar component (`@volt('calendar')`)

3. **Integrate FullCalendar**
   - Use existing `saade/filament-fullcalendar` dependency
   - Create calendar widget/component in Filament (admin)
   - Calendar data via Actions chiamate da Volt

#### Phase 3: Advanced Features
1. **Location & Maps**
   - Integrate with existing Geo module
   - Add map components to event views
   - Implement location search

2. **Notifications**
   - Create event reminder notifications
   - Implement RSVP confirmation notifications
   - Add notification preferences

3. **User Dashboard**
   - My events page (organized events)
   - My registrations page (attending events)
   - Calendar integration in user dashboard

#### Phase 4: Admin & Management
1. **Filament Integration**
   - Create admin panels for event management
   - Add statistics and reporting
   - Implement bulk actions

2. **Permissions & Policies**
   - Create event policies
   - Implement role-based access
   - Add admin-only features

3. **SEO & Performance**
   - Add meta tags for events
   - Implement caching strategies
   - Optimize database queries

### Key Actions to Implement

#### CreateEventAction
```php
class CreateEventAction
{
    public function execute(array $data, User $organizer): Event
    {
        // Validate and create event
        // Send notification to organizer
        // Return created event
    }
}
```

#### RegisterForEventAction
```php
class RegisterForEventAction
{
    public function execute(Event $event, User $user, array $data = []): EventRegistration
    {
        // Check event capacity
        // Validate registration requirements
        // Create registration record
        // Send confirmation notification
        // Return registration
    }
}
```

### Views & Components
- **EventCardComponent**: Display event information in a card format
- **CalendarWidget**: Interactive calendar component
- **EventRegistrationForm**: Registration form component
- **EventLocationMap**: Map component with location pin

### Folio Pages (File-Based Routing)
**NON definire rotte in web.php!** Folio crea rotte automaticamente da file:

```
resources/views/pages/
├── events.blade.php              → /events (automatico)
├── events/
│   └── [event].blade.php         → /events/{event} (automatico)
├── calendar.blade.php            → /calendar (automatico)
└── auth/
    ├── login.blade.php           → /login (automatico)
    └── register.blade.php        → /register (automatico)
```

**Registrazione Eventi**: Gestita tramite componenti Volt che chiamano Actions:
- `RegisterEventAction` chiamato da `@volt('event-registration')`
- `CancelEventRegistrationAction` chiamato da Volt
- Nessuna rotta POST necessaria, tutto gestito da Livewire/Volt

**Nota Architetturale**:
- ❌ **NON creare controller** per frontoffice
- ❌ **NON scrivere rotte** in `web.php` o `api.php`
- ✅ **Folio** gestisce routing automaticamente
- ✅ **Volt** gestisce interattività e form submissions

### Integration with Existing Modules
- **User Module**: Leverage existing authentication and user management
- **Geo Module**: Use location and mapping services
- **UI Module**: Use existing components and layouts
- **Notify Module**: Use notification system for event updates
- **Media Module**: Handle event image uploads
- **Cms Module**: Integrate with content management for event pages

### Testing Strategy
- Unit tests for actions and services
- Feature tests for event registration flow
- API tests for calendar endpoints
- Integration tests for full user journey

### Security Considerations
- Validate event capacity and registration limits
- Prevent duplicate registrations
- Implement proper authorization checks
- Sanitize user inputs for event descriptions
- Protect against CSRF attacks

### Performance Optimization
- Implement caching for event listings
- Use eager loading for related data
- Optimize location-based queries
- Implement pagination for large event lists
