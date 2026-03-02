# Schema.org Research - Start Document

**Status**: Research complete – tasks created

---

## Research Scope

The following Schema.org URLs were thoroughly studied:

### Event-Related
- [eventSchedule](https://schema.org/eventSchedule) - Recurring event patterns
- [Event](https://schema.org/Event) - Core event type
- [EventSeries](https://schema.org/EventSeries) - Grouped recurring events
- [EventReservation](https://schema.org/EventReservation) - Ticket/booking system
- [EducationEvent](https://schema.org/EducationEvent) - Workshops/training

### Participant Actions
- [JoinAction](https://schema.org/JoinAction) - RSVP joining
- [LeaveAction](https://schema.org/LeaveAction) - RSVP leaving
- [attendee](https://schema.org/attendee) - Event attendees
- [attendees](https://schema.org/attendees) - Deprecated, use attendee
- [participant](https://schema.org/participant) - Generic participant

### Commercial
- [Offer](https://schema.org/Offer) - Ticket pricing
- [PriceSpecification](https://schema.org/PriceSpecification) - Detailed pricing
- [DeliveryChargeSpecification](https://schema.org/DeliveryChargeSpecification) - Delivery zones

### Location
- [FoodEstablishment](https://schema.org/FoodEstablishment) - Restaurant venues
- [GeoCircle](https://schema.org/GeoCircle) - Circular service areas
- [docs/hotels.html](https://schema.org/docs/hotels.html) - Accommodation markup

### Person & Address
- [Person](https://schema.org/Person) - User profiles
- [address](https://schema.org/address) - PostalAddress structure

---

## Documentation Created

### Comprehensive Research
- [schema-org-research-comprehensive.md](schema-org-research-comprehensive.md) - Full research guide

### Implementation Tasks (Priority Order)

1. **HIGH Priority**
   - [task-event-scheduling.md](task-event-scheduling.md) - Recurring events
   - [task-event-series.md](task-event-series.md) - Event series model
   - [task-rsvp-actions.md](task-rsvp-actions.md) - Join/Leave actions

2. **MEDIUM Priority**
   - [task-event-reservations.md](task-event-reservations.md) - Ticketing system
   - [task-food-establishments.md](task-food-establishments.md) - Partner venues
   - [task-education-events.md](task-education-events.md) - Workshops

3. **LOW Priority**
   - [task-geo-service-areas.md](task-geo-service-areas.md) - GeoCircle support
   - [task-person-profile-enhancement.md](task-person-profile-enhancement.md) - Profile schema

### Existing Documentation
- [event-schema-org-implementation.md](event-schema-org-implementation.md) - Current status
- [schema-org-enhancement-proposal.md](schema-org-enhancement-proposal.md) - Original proposal
- [schema-org-enhancement-recommendations.md](schema-org-enhancement-recommendations.md) - Recommendations

---

## Key Learnings Summary

### Event Scheduling
- Use ISO 8601 duration format (P1W, P1M)
- `eventSchedule` property takes a `Schedule` object
- Support `byDay`, `repeatFrequency`, `exceptDate`

### Event Series
- `superEvent` links child to parent series
- `subEvent` links parent to children
- Enables recurring meetup grouping

### RSVP System
- `JoinAction` for registration
- `LeaveAction` for cancellation
- `ActionStatusType` for tracking state

### Reservations
- `EventReservation` for booking tracking
- `Offer` for ticket types
- `ItemAvailability` for stock status

### Food Venues
- `FoodEstablishment` for partner pizzerias
- `openingHoursSpecification` for hours
- `amenityFeature` for WiFi, parking, etc.

---

## Next Steps

1. Start with HIGH priority tasks
2. Update Event model with schedule support
3. Create EventSeries model
4. Implement RSVP with actions
5. Run PHPStan after each implementation
6. Update documentation as features complete
