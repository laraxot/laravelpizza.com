# FullCalendar Component

## Introduction
This document provides an overview of the FullCalendar component in Laraxot PTVX, implemented using Saade's FullCalendar plugin for Filament. This document serves as a central reference point, linking to specific documentation in the UI and Ptv modules.

## General Architecture

The FullCalendar component is implemented following these principles:

1. **Base Widget in UI Module**: The `BaseCalendarWidget` class is defined in the UI module and provides common functionality for all implementations
2. **Specific Implementations in Modules**: Each module using the calendar extends the base widget
3. **Bidirectional Documentation**: Maintained both in specific modules and root documentation

## Links to Detailed Documentation

- [UI Component Documentation](../laravel/Modules/UI/docs/components/full-calendar.md)
- [Implementation in Ptv Module](../laravel/Modules/Ptv/docs/features/full-calendar.md)
- [Cursor Implementation Rules](../.cursor/rules/full_calendar_rules.mdc)
- [Windsurf Implementation Rules](../.windsurf/rules/full_calendar_rules.mdc)

## Key Rules

1. **Extension**: All calendar widgets must extend `BaseCalendarWidget` from the UI module
2. **Component Placement**: All Blade UI components must be in `Modules/UI/resources/views/components/ui/`
3. **Migrations**: Follow standard migration rules (extending `XotBaseMigration`, no `down()`, etc.)
4. **Translations**: All labels and messages must come from translation files
5. **PHPStan**: Code must pass PHPStan validation level 10+
6. **Naming Convention**: All class names and attributes must be in English following Laravel conventions

## Technologies Used

- [Saade FullCalendar Plugin for Filament](https://github.com/saade/filament-fullcalendar)
- [FullCalendar.io Library](https://fullcalendar.io/docs)
- [Alpine.js](https://alpinejs.dev/) for tooltips and client-side interactions

## Maintenance

When making changes to the FullCalendar component:

1. Update documentation in the UI module
2. Update documentation in the specific module using the component
3. Update this central document for cross-references
4. Verify compliance with rules in Cursor and Windsurf .mdc files
5. Ensure all class names and attributes follow English naming conventions

*Last updated: June 2025*
