# Task: Implement Education Events

**Priority**: MEDIUM
**Status**: TODO
**Estimated Effort**: 1 day
**Reference**: [Schema.org EducationEvent](https://schema.org/EducationEvent)

---

## Objective

Support EducationEvent type for workshops, training sessions, and hackathons with proper Schema.org structured data.

---

## Key Properties

| Property | Type | Description |
|----------|------|-------------|
| `teaches` | DefinedTerm/Text | Competencies taught |
| `assesses` | DefinedTerm/Text | Competencies assessed |
| `educationalLevel` | DefinedTerm/Text | Difficulty level |

---

## Event Type Selection

```php
// Enums/EventType.php
enum EventType: string
{
    case MEETUP = 'Event';
    case WORKSHOP = 'EducationEvent';
    case HACKATHON = 'Hackathon';
    case CONFERENCE = 'BusinessEvent';
}
```

---

## Implementation Steps

- [ ] Create `EventType` enum
- [ ] Add event_type field to events table
- [ ] Add educational fields (teaches, skill_level)
- [ ] Update Event model toSchemaOrg()
- [ ] Update Filament EventResource
- [ ] Write Pest tests

---

**Created**: 2026-02-10
**Reference**: [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md)
