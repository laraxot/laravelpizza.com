# Event Sourcing Integration

## Overview
The Laravel Pizza project implements event sourcing using the spatie/laravel-event-sourcing package, primarily through the Activity module.

## Core Components

### StoredEvent Model
- Captures all significant domain events
- Maintains event history for audit trails
- Supports event replay for state reconstruction
- Implements proper serialization

### Snapshot Model
- Optimizes event replay performance
- Captures aggregate state at specific points
- Reduces replay time for long-lived aggregates
- Maintains data consistency

### Aggregate Roots
- Event-driven state management
- Consistency boundaries
- Business logic encapsulation
- Event application patterns

## Integration Pattern

### HasEvents Trait
- Provides morphMany relationship to StoredEvent
- Enables event sourcing capabilities on any model
- Standardizes event storage approach
- Supports audit trail functionality

### State Management
- Uses spatie/laravel-model-states for state transitions
- Integrates with event sourcing for state changes
- Provides status tracking and workflow management
- Supports custom state transitions

## Usage Examples

### In Meetup Module
- Event model uses HasEvents trait
- Tracks event lifecycle (draft → published → completed)
- Maintains audit trail for all changes
- Supports state-based business logic

### Cross-Module Integration
- Activity module centralizes event storage
- Multiple modules can contribute events
- Consistent audit and monitoring
- Unified event replay capabilities

## Best Practices

### Event Naming
- Use past tense (e.g., UserRegistered, OrderPlaced)
- Include aggregate context
- Maintain consistency across modules
- Follow domain language

### Event Structure
- Include all necessary data for replay
- Maintain immutability
- Support versioning for schema changes
- Include metadata for context

### Performance Considerations
- Use snapshots appropriately
- Optimize event storage
- Consider read/write model separation
- Implement proper indexing

## Testing Event Sourced Systems

### Event Replay Testing
- Verify state consistency after replay
- Test event ordering requirements
- Validate business rule enforcement
- Ensure data integrity

### Integration Testing
- Test cross-module event flows
- Verify audit trail completeness
- Validate snapshot correctness
- Ensure system consistency

## Migration and Versioning

### Event Schema Changes
- Maintain backward compatibility
- Implement proper upcasting
- Plan for data migration
- Handle version conflicts

### Aggregate Evolution
- Support multiple event versions
- Maintain historical consistency
- Plan for aggregate splitting/merging
- Handle aggregate state transitions
