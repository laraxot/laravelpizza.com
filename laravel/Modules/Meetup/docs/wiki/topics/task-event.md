---
title: "Topic task-event"
type: digest
status: active
qmd: "digest ceiling 100 task-event"
---

# Topic task-event

Sintesi automatica di 3 documenti (chiave `task-event`).

## Task: Implement Event Reservation System

_Fonte: `task-event-reservations.md`_

# Task: Implement Event Reservation System

**Priority**: MEDIUM
**Status**: TODO
**Estimated Effort**: 3 days
**Reference**: [Schema.org EventReservation](https://schema.org/EventReservation)

---

## Objective

Implement a complete reservation and ticketing system for events using Schema.org `EventReservation` and `Offer` patterns.

---

## Requirements

### New Model: EventReservation

```php
// Models/EventReservation.php
class EventReservation extends BaseModel
{
    protected $fillable = [
        'reservation_id',
        'user_id',
        'event_id',
        'ticket_id',
        'status',
        'total_price',

## Task: Implement Event Scheduling System

_Fonte: `task-event-scheduling.md`_

# Task: Implement Event Scheduling System

**Priority**: HIGH
**Status**: TODO
**Estimated Effort**: 2-3 days
**Reference**: [Schema.org eventSchedule](https://schema.org/eventSchedule)

---

## Objective

Implement recurring event support using Schema.org `eventSchedule` pattern to allow meetups to recur weekly, monthly, or on custom schedules.

---

## Requirements

### Database Changes

Add to `meetup_events` table:

```php
// Migration: add_schedule_fields_to_meetup_events_table.php
$table->string('repeat_frequency')->nullable()->comment('ISO 8601: P1D, P1W, P1M');
$table->json('repeat_days')->nullable()->comment('DayOfWeek array');
$table->integer('repeat_count')->nullable()->comment('Number of occurrences');
$table->date('schedule_end_date')->nullable()->comment('When recurrence ends');
$table->json('except_dates')->nullable()->comment('Excluded dates');
$table->string('schedule_timezone')->default('Europe/Rome');
```

## Task: Implement Event Series Model

_Fonte: `task-event-series.md`_

# Task: Implement Event Series Model

**Priority**: HIGH
**Status**: TODO
**Estimated Effort**: 2 days
**Reference**: [Schema.org EventSeries](https://schema.org/EventSeries)

---

## Objective

Create an `EventSeries` model to group recurring meetups (e.g., "Monthly Laravel Pizza Milan") with proper Schema.org structured data support.

---

## Requirements

### New Model: EventSeries

```php
// Models/EventSeries.php
class EventSeries extends BaseEventSeries
{
    protected $fillable = [
        'name',
        'description',
        'start_date',      // When series began
        'end_date',        // When series ends (optional)
        'frequency',       // Default frequency for events
        'status',          // active, completed, cancelled
