# Meetup Module

The Meetup module provides event and meeting management functionality for the Laravel Pizza application.

## Features

- Event/Meetup creation and management
- Calendar integration (with FullCalendar when compatible with Filament v4)
- Event status tracking (draft, published, cancelled)
- Attendee management
- Location tracking
- Event metadata support

## Architecture

The module follows the Laraxot modular architecture pattern with specific front office implementation:

- **Front Office**: Laravel Folio for routing (NO traditional controllers/routes in web.php/api.php), Laravel Volt for components
- **Back Office**: Filament for admin panel and backend management
- **Models**: `Event` model with event sourcing capabilities 
- **Actions**: Create, Update, Delete operations using action pattern
- **Filament Resources**: Complete CRUD interface for event management
- **Widgets**: Calendar widget for visual event representation
- **Traits**: Integration with Activity module for event sourcing

## 🏗️ Front Office Implementation

### Laravel Folio (File-based Routing)
- Pages automatically created from Blade files in `/resources/views/pages/`
- Example: `/resources/views/pages/events/index.blade.php` → `/events`
- Parameters captured with `[parameter]` syntax
- No need to define routes in web.php for front office

### Laravel Volt (Declarative Components)
- Single-file components with PHP logic and Blade template
- Reduced boilerplate compared to traditional Livewire components
- Perfect integration with Folio pages
- Built-in validation and error handling

### Critical Architecture Rule
- **Front Office**: Use ONLY Folio + Volt (NO controllers)
- **Back Office**: Use traditional controllers with Filament
- **NEVER** create routes in web.php/api.php for front office functionality
- **NEVER** create traditional controllers for front office pages

## Event Sourcing

Events are tracked using the Activity module's event sourcing capabilities:
- Stored events are maintained for audit trails
- Snapshots can be used for state restoration

## Calendar Integration

The calendar widget is based on the UI module's calendar implementation, 
though currently disabled due to Filament v4 compatibility issues with the 
saade/filament-fullcalendar package.

## Usage

The module is automatically integrated into the Filament admin panel when enabled.