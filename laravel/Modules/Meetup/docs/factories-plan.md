# Factory Implementation Plan - Meetup Module

## 1. Strategy & Goals
Create a robust set of factories for the Meetup module to support 100% test coverage and realistic data generation. All factories must follow Laraxot standards:
*   Strict typing.
*   Association with correct models.
*   Realistic, non-dummy data.
*   Support for multiple languages where applicable.

## 2. Factories to Create
*   `ProfileFactory`: User profiles with realistic bio and metadata.
*   `EventFactory`: Rich meetup events with descriptions, dates, and locations.
*   `EventUserFactory`: Pivot factory for event attendees.
*   `EventSponsorFactory`: Pivot factory for event sponsors.
*   `EventPerformerFactory`: Pivot factory for event performers/speakers.

## 3. Implementation Workflow
1.  **Research:** Study existing models and database schema for each.
2.  **Logic:** Define `definition()` with realistic Faker providers.
3.  **Refinement:** Use "Super Mucca" reasoning to ensure no `mixed` types and proper associations.
4.  **Verification:** Run PHPStan and Pest tests to ensure factory integrity.

## 4. Key Considerations
*   `EventUser`, `EventSponsor`, `EventPerformer` are pivot models; factories should handle IDs from related models.
*   `EventFactory` should use `ProfileFactory` for creator/organizer attributes if necessary.
*   Dates in `EventFactory` must be consistent (end_date > start_date).

---
*Status: Planned*
*
