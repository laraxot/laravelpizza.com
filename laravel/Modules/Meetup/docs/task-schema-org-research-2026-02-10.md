# Task: Schema.org Research and Implementation - 2026-02-10

**Created**: 2026-02-10  
**Module**: Meetup  
**Status**: Pending  
**Priority**: High  

## Research Summary

Based on comprehensive research of Schema.org documentation, I've identified key areas for enhancement in the Meetup module:

### 1. Event Scheduling & Recurrence
- **URL**: https://schema.org/eventSchedule
- **Implementation**: Add schedule support for recurring events
- **Files to modify**: 
  - `laravel/Modules/Meetup/app/Models/Event.php`
  - `laravel/Modules/Meetup/database/migrations/*_add_schedule_fields_to_events_table.php`

### 2. Event Series & Super Events
- **URL**: https://schema.org/EventSeries
- **Implementation**: Create EventSeries model and relationships
- **Files to modify**:
  - `laravel/Modules/Meetup/app/Models/EventSeries.php`
  - `laravel/Modules/Meetup/database/migrations/*_create_event_series_table.php`

### 3. Participant Actions
- **URLs**: https://schema.org/JoinAction, https://schema.org/LeaveAction
- **Implementation**: Enhanced RSVP system with proper action tracking
- **Files to modify**:
  - `laravel/Modules/Meetup/app/Models/EventAttendance.php`
  - `laravel/Modules/Meetup/app/Actions/RsvpJoinAction.php`
  - `laravel/Modules/Meetup/app/Actions/RsvpLeaveAction.php`

### 4. Event Reservations
- **URL**: https://schema.org/EventReservation
- **Implementation**: Ticket reservation system
- **Files to modify**:
  - `laravel/Modules/Meetup/app/Models/EventReservation.php`
  - `laravel/Modules/Meetup/database/migrations/*_create_event_reservations_table.php`

### 5. Education Events
- **URL**: https://schema.org/EducationEvent
- **Implementation**: Support for workshop/training events
- **Files to modify**:
  - `laravel/Modules/Meetup/app/Models/Event.php` (add type detection)

### 6. Food Establishments
- **URL**: https://schema.org/FoodEstablishment
- **Implementation**: Partner venue integration
- **Files to modify**:
  - `laravel/Modules/Meetup/app/Models/Venue.php`
  - `laravel/Modules/Geo/app/Models/Place.php` (add toSchemaOrg)

### 7. Pricing & Offers
- **URLs**: https://schema.org/Offer, https://schema.org/PriceSpecification
- **Implementation**: Enhanced ticket pricing
- **Files to modify**:
  - `laravel/Modules/Meetup/app/Models/Ticket.php`
  - `laravel/Modules/Meetup/app/Models/EventOffer.php`

### 8. Geographic Areas
- **URLs**: https://schema.org/GeoCircle, https://schema.org/GeoShape
- **Implementation**: Delivery/service area support
- **Files to modify**:
  - `laravel/Modules/Geo/app/Models/Place.php`
  - `laravel/Modules/Meetup/app/Models/Venue.php`

### 9. Person & Address
- **URLs**: https://schema.org/Person, https://schema.org/address
- **Implementation**: Enhanced user profiles
- **Files to modify**:
  - `laravel/Modules/User/app/Models/User.php`
  - `laravel/Modules/Geo/app/Models/Address.php`

## Implementation Steps

### Phase 1: Core Models (High Priority)
1. **Create EventSeries model** with relationships
2. **Enhance Event model** with schedule support
3. **Create EventReservation model** for ticketing
4. **Update User model** with enhanced Person schema

### Phase 2: Actions & RSVP (High Priority)
1. **Implement JoinAction** for RSVP
2. **Implement LeaveAction** for unsubscription
3. **Create EventAttendance model** to track RSVPs
4. **Add action tracking** to Event model

### Phase 3: Pricing & Venues (Medium Priority)
1. **Enhance Ticket model** with pricing specs
2. **Create EventOffer model** for offers
3. **Update Venue model** with FoodEstablishment schema
4. **Add delivery zone support** using GeoCircle

### Phase 4: Education & Geographics (Medium Priority)
1. **Add EducationEvent support** to Event model
2. **Enhance Geo module** with service area support
3. **Add participant tracking** to RSVP actions
4. **Update address handling** for Italian provinces

## Technical Requirements

### Database Changes
- Add schedule fields to events table
- Create event_series table
- Create event_reservations table
- Add province field to addresses table
- Add service_radius to places table

### Model Enhancements
- Implement HasSchemaOrg trait pattern
- Add toSchemaOrg() methods to key models
- Update fillable arrays for new fields
- Add validation rules for new fields

### API Changes
- Update API endpoints to include schema.org data
- Add schema.org data to existing responses
- Ensure proper JSON-LD generation

## Testing Plan

1. **Unit Tests**: Test schema.org generation methods
2. **Integration Tests**: Test API endpoints with schema.org data
3. **Validation Tests**: Test new validation rules
4. **Regression Tests**: Ensure existing functionality still works

## Documentation Updates

1. Update existing schema.org documentation
2. Create new implementation guides
3. Update API documentation
4. Add examples for new features

## Success Criteria

1. All new models have proper schema.org support
2. API endpoints return valid JSON-LD
3. All new functionality is properly tested
4. Documentation is updated and accurate
5. No breaking changes to existing functionality

## Related Files

- [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md) - Comprehensive research document
- [schema-org-enhancement-recommendations.md](./schema-org-enhancement-recommendations.md) - Recommendations document
- [event-schema-org-implementation.md](./event-schema-org-implementation.md) - Current implementation
- [tasks-schema-org-event-series-actions.md](./tasks-schema-org-event-series-actions.md) - Event series tasks
- [tasks-schema-org-offer-price.md](./tasks-schema-org-offer-price.md) - Offer and price tasks

## References

- [Schema.org Official Documentation](https://schema.org/)
- [Event Scheduling](https://schema.org/eventSchedule)
- [Event Series](https://schema.org/EventSeries)
- [Join/Leave Actions](https://schema.org/JoinAction)
- [Event Reservation](https://schema.org/EventReservation)
- [Education Event](https://schema.org/EducationEvent)
- [Food Establishment](https://schema.org/FoodEstablishment)
- [Delivery Charge](https://schema.org/DeliveryChargeSpecification)
- [Offers & Pricing](https://schema.org/Offer)
- [GeoCircle](https://schema.org/GeoCircle)
- [Person & Address](https://schema.org/Person)

---

**Created by**: AI Assistant  
**Last Updated**: 2026-02-10