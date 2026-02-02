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

### Model Changes

```php
// Event.php
protected $casts = [
    'repeat_days' => 'array',
    'except_dates' => 'array',
    'schedule_end_date' => 'date',
];

public function isRecurring(): bool
{
    return !empty($this->repeat_frequency);
}

public function getScheduleSchemaOrg(): ?array
{
    if (!$this->isRecurring()) {
        return null;
    }
    
    return [
        '@type' => 'Schedule',
        'startDate' => $this->start_date->toDateString(),
        'endDate' => $this->schedule_end_date?->toDateString(),
        'startTime' => $this->start_date->format('H:i:s'),
        'endTime' => $this->end_date?->format('H:i:s'),
        'repeatFrequency' => $this->repeat_frequency,
        'byDay' => $this->repeat_days,
        'repeatCount' => $this->repeat_count,
        'exceptDate' => $this->except_dates,
        'scheduleTimezone' => $this->schedule_timezone,
    ];
}

// Update toSchemaOrg() to include:
'eventSchedule' => $this->getScheduleSchemaOrg(),
```

### Enum for Frequency

```php
// Enums/RepeatFrequency.php
enum RepeatFrequency: string
{
    case DAILY = 'P1D';
    case WEEKLY = 'P1W';
    case BIWEEKLY = 'P2W';
    case MONTHLY = 'P1M';
    case YEARLY = 'P1Y';
    
    public function label(): string
    {
        return match($this) {
            self::DAILY => 'Daily',
            self::WEEKLY => 'Weekly',
            self::BIWEEKLY => 'Every 2 Weeks',
            self::MONTHLY => 'Monthly',
            self::YEARLY => 'Yearly',
        };
    }
}
```

### Filament Resource Updates

```php
// EventResource.php - Add schedule section
Section::make('Schedule')
    ->schema([
        Select::make('repeat_frequency')
            ->enum(RepeatFrequency::class)
            ->nullable(),
        CheckboxList::make('repeat_days')
            ->options([
                'Monday' => 'Monday',
                'Tuesday' => 'Tuesday',
                // ...
            ])
            ->visible(fn($get) => $get('repeat_frequency')),
        TextInput::make('repeat_count')
            ->numeric()
            ->nullable(),
        DatePicker::make('schedule_end_date')
            ->nullable(),
    ])
```

---

## Implementation Steps

- [ ] Create migration for schedule fields
- [ ] Create `RepeatFrequency` enum
- [ ] Update Event model with schedule methods
- [ ] Add `getScheduleSchemaOrg()` method
- [ ] Update `toSchemaOrg()` to include schedule
- [ ] Update Filament EventResource form
- [ ] Add translations for schedule fields
- [ ] Create action to generate recurring instances
- [ ] Write Pest tests for scheduling logic
- [ ] Update documentation

---

## Related Files

- `Modules/Meetup/app/Models/Event.php`
- `Modules/Meetup/app/Enums/RepeatFrequency.php` (new)
- `Modules/Meetup/database/migrations/xxxx_add_schedule_fields.php` (new)
- `Modules/Meetup/app/Filament/Resources/EventResource.php`

---

## Acceptance Criteria

1. Events can be marked as recurring
2. Recurrence follows ISO 8601 duration format
3. JSON-LD output includes proper `eventSchedule`
4. Filament UI allows schedule configuration
5. PHPStan Level 10 passes
6. Pest tests cover all scenarios

---

**Created**: 2026-02-10
**Reference**: [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md)
