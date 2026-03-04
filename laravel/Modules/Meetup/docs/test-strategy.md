# Meetup Module: Test Strategy for 100% Coverage

## Overview

The Meetup module is the **core business logic** for LaravelPizza's event management platform. Achieving 100% coverage requires testing:
- Event lifecycle (create, update, publish, cancel)
- Participant management (attendees, performers, sponsors)
- Venue management
- Filament admin resources
- Event business logic and validations

## Module Structure

```
Modules/Meetup/app/
├── Actions/              # Business logic (critical)
├── Models/               # Domain entities
├── Filament/            # Admin resources
├── Services/            # Utility services
├── Datas/              # Spatie Data DTOs
├── Enums/              # Status enums
└── Providers/          # Service providers
```

## Testing Strategy by Type

### 1. Models (45 files)

**Files to test:**
- `Event.php` - Main event aggregate
- `Participant.php` - Event participants
- `Venue.php` - Venue details
- `EventUser.php`, `EventPerformer.php`, `EventSponsor.php` - Pivot models
- `Profile.php` - User profile
- `BaseModel.php` - Base class

**Coverage approach:**
```php
// Test model instantiation
#[Test]
public function event_can_be_created(): void
{
    $event = Event::factory()->create();
    $this->assertNotNull($event->id);
}

// Test relations
#[Test]
public function event_has_many_participants(): void
{
    $event = Event::factory()->create();
    $participants = Participant::factory(3)->for($event)->create();
    $this->assertCount(3, $event->participants);
}

// Test scopes
#[Test]
public function published_scope_filters_by_status(): void
{
    Event::factory(2)->create(['status' => EventStatus::PUBLISHED]);
    Event::factory(1)->create(['status' => EventStatus::DRAFT]);
    $this->assertCount(2, Event::published()->get());
}

// Test mutators/accessors
#[Test]
public function event_slug_is_generated_from_title(): void
{
    $event = Event::factory()->create(['title' => 'Laravel Meetup 2024']);
    $this->assertEquals('laravel-meetup-2024', $event->slug);
}
```

**Test files needed:**
- `tests/Unit/Models/EventTest.php`
- `tests/Unit/Models/ParticipantTest.php`
- `tests/Unit/Models/VenueTest.php`
- `tests/Unit/Models/Pivots/EventUserTest.php`
- `tests/Unit/Models/Pivots/EventPerformerTest.php`
- `tests/Unit/Models/Pivots/EventSponsorTest.php`
- `tests/Unit/Models/ProfileTest.php`

### 2. Actions (25+ files)

**Key Actions to test:**
- `Event/CreateEventAction.php` - Event creation
- `Event/UpdateEventAction.php` - Event updates
- `Event/DeleteEventAction.php` - Event deletion
- `Event/ImportEventsFromJsonAction.php` - JSON import
- `Event/SeedEventsFromJsonAction.php` - Database seeding

**Coverage approach:**
```php
// Test action execution
#[Test]
public function create_event_action_creates_event(): void
{
    $data = EventData::from([
        'title' => 'Laravel Meetup',
        'description' => 'Learn Laravel',
        'start_datetime' => now()->addDay(),
        'end_datetime' => now()->addDay()->addHours(2),
        'venue_id' => Venue::factory()->create()->id,
    ]);

    $event = app(CreateEventAction::class)->execute($data);

    $this->assertDatabaseHas('meetup_events', [
        'id' => $event->id,
        'title' => 'Laravel Meetup',
    ]);
}

// Test action validation
#[Test]
public function create_event_action_validates_dates(): void
{
    $data = EventData::from([
        'title' => 'Laravel Meetup',
        'start_datetime' => now()->subDay(),  // Invalid: past date
        'end_datetime' => now(),
        'venue_id' => Venue::factory()->create()->id,
    ]);

    $this->expectException(ValidationException::class);
    app(CreateEventAction::class)->execute($data);
}

// Test action side effects
#[Test]
public function create_event_action_logs_activity(): void
{
    $data = EventData::from([...]);
    $event = app(CreateEventAction::class)->execute($data);

    $this->assertTrue(
        Activity::where('subject_type', Event::class)
            ->where('subject_id', $event->id)
            ->exists()
    );
}
```

**Test files needed:**
- `tests/Unit/Actions/Event/CreateEventActionTest.php`
- `tests/Unit/Actions/Event/UpdateEventActionTest.php`
- `tests/Unit/Actions/Event/DeleteEventActionTest.php`
- `tests/Unit/Actions/Event/ImportEventsFromJsonActionTest.php`
- `tests/Unit/Actions/Event/SeedEventsFromJsonActionTest.php`

### 3. Filament Resources (12+ files)

**Resources to test:**
- `Resources/EventResource.php` - Event CRUD
- `Resources/ParticipantResource.php` - Participant CRUD
- `Resources/VenueResource.php` - Venue CRUD
- Pages: Dashboard, MeetupDashboard
- Widgets: CalendarWidget, EventStatsOverviewWidget, etc.
- Actions: ImportEventsAction

**Coverage approach:**
```php
// Test resource form
#[Test]
public function event_resource_form_has_required_fields(): void
{
    $resource = new EventResource();
    $form = $resource->form(Form::make());

    $this->assertContains('title', $form->getComponents());
    $this->assertContains('description', $form->getComponents());
}

// Test resource table
#[Test]
public function event_resource_table_has_columns(): void
{
    $resource = new EventResource();
    $table = $resource->table(Table::make());

    // Verify columns exist
    $this->assertTrue($table->hasColumn('title'));
}

// Test resource authorization
#[Test]
public function can_create_event_with_permission(): void
{
    $user = User::factory()->create();
    $user->givePermissionTo('create events');

    $resource = new EventResource();
    $this->assertTrue($resource->canCreate($user));
}
```

**Test files needed:**
- `tests/Unit/Filament/Resources/EventResourceTest.php`
- `tests/Unit/Filament/Resources/ParticipantResourceTest.php`
- `tests/Unit/Filament/Resources/VenueResourceTest.php`
- `tests/Unit/Filament/Pages/MeetupDashboardTest.php`
- `tests/Unit/Filament/Widgets/EventStatsOverviewWidgetTest.php`

### 4. Services (8+ files)

**Services to test:**
- `EventService.php` - Event business logic
- `ParticipantService.php` - Participant management
- etc.

**Coverage approach:**
```php
#[Test]
public function event_service_publishes_event(): void
{
    $event = Event::factory()->create(['status' => EventStatus::DRAFT]);

    app(EventService::class)->publish($event);

    $this->assertEquals(EventStatus::PUBLISHED, $event->refresh()->status);
}
```

### 5. DTOs & Enums

**Enums to test:**
- `EventStatus` - Validate all cases
- `EventAttendanceMode` - Validate all cases
- `RepeatFrequency` - Validate all cases

**Coverage approach:**
```php
#[Test]
public function event_status_enum_has_all_cases(): void
{
    $this->assertEquals(['DRAFT', 'PUBLISHED', 'CANCELLED'], EventStatus::cases());
}
```

## Test Coverage Goals

| Category | Count | Status |
|----------|-------|--------|
| Models | 8 | ⏳ TODO |
| Model Relations | 5+ | ⏳ TODO |
| Actions | 10+ | ⏳ TODO |
| Services | 8+ | ⏳ TODO |
| Filament Resources | 5+ | ⏳ TODO |
| Filament Widgets | 7+ | ⏳ TODO |
| DTOs | 3+ | ⏳ TODO |
| Enums | 3 | ⏳ TODO |
| **Total** | **50+** | ⏳ TODO |

## Implementation Order

1. **Models** - Foundation (Event, Participant, Venue)
2. **Relations** - belongsToManyX patterns
3. **Actions** - Business logic (create, update, delete, import)
4. **Services** - Utility methods
5. **Filament Resources** - Admin interface
6. **Enums & DTOs** - Data structures

## Coverage Report Location

After tests are complete: `Modules/Meetup/docs/coverage.md`

Format:
```
# Meetup Module - Test Coverage Report

## Summary
- Total source files: 250
- Total test files: 60+ (NEW)
- Coverage: 100%
- Last updated: 2024

## Coverage by Category
| Category | Files | Tests | Coverage |
|----------|-------|-------|----------|
| Models | 8 | 25 | 100% |
| Actions | 10 | 30 | 100% |
| Services | 8 | 15 | 100% |
| ...
```

## Testing Guidelines

- Use `DatabaseTransactions` trait (NOT `RefreshDatabase`)
- Create factories for all models
- Use Pest assertions with expressive names
- Test both happy path and error cases
- Document complex test scenarios
- Keep tests focused and readable

