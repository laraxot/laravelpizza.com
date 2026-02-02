# Task: Implement RSVP Actions (Join/Leave)

**Priority**: HIGH
**Status**: TODO
**Estimated Effort**: 2 days
**Reference**: [Schema.org JoinAction](https://schema.org/JoinAction), [LeaveAction](https://schema.org/LeaveAction)

---

## Objective

Implement Schema.org compliant RSVP system using `JoinAction` and `LeaveAction` patterns for tracking event participation with proper structured data output.

---

## Requirements

### New Model: EventAttendance

```php
// Models/EventAttendance.php
class EventAttendance extends BaseModel
{
    protected $fillable = [
        'user_id',
        'event_id',
        'action_type',      // 'join' or 'leave'
        'action_status',    // ActionStatusType
        'role',             // attendee, speaker, organizer
        'joined_at',
        'left_at',
        'notes',
        'num_guests',
    ];
    
    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
        'num_guests' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    
    public function toJoinActionSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'JoinAction',
            'agent' => [
                '@type' => 'Person',
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'object' => [
                '@type' => 'Event',
                '@id' => route('events.show', $this->event_id),
                'name' => $this->event->title,
            ],
            'startTime' => $this->joined_at?->toIso8601String(),
            'actionStatus' => 'https://schema.org/' . $this->action_status,
        ];
    }
    
    public function toLeaveActionSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'LeaveAction',
            'agent' => $this->toJoinActionSchema()['agent'],
            'object' => $this->toJoinActionSchema()['object'],
            'startTime' => $this->left_at?->toIso8601String(),
            'actionStatus' => 'https://schema.org/CompletedActionStatus',
        ];
    }
}
```

### Enum: ActionStatusType

```php
// Enums/ActionStatusType.php
enum ActionStatusType: string
{
    case ACTIVE = 'ActiveActionStatus';
    case COMPLETED = 'CompletedActionStatus';
    case FAILED = 'FailedActionStatus';
    case POTENTIAL = 'PotentialActionStatus';
    
    public function label(): string
    {
        return match($this) {
            self::ACTIVE => 'In Progress',
            self::COMPLETED => 'Completed',
            self::FAILED => 'Failed',
            self::POTENTIAL => 'Potential',
        };
    }
}
```

### Enum: AttendeeRole

```php
// Enums/AttendeeRole.php
enum AttendeeRole: string
{
    case ATTENDEE = 'attendee';
    case SPEAKER = 'speaker';
    case ORGANIZER = 'organizer';
    case SPONSOR = 'sponsor';
    case VOLUNTEER = 'volunteer';
    
    public function label(): string
    {
        return match($this) {
            self::ATTENDEE => 'Attendee',
            self::SPEAKER => 'Speaker',
            self::ORGANIZER => 'Organizer',
            self::SPONSOR => 'Sponsor',
            self::VOLUNTEER => 'Volunteer',
        };
    }
}
```

### Database Migration

```php
// create_meetup_event_attendances_table.php
Schema::create('meetup_event_attendances', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('event_id')->constrained('meetup_events')->cascadeOnDelete();
    $table->string('action_type')->default('join');
    $table->string('action_status')->default('ActiveActionStatus');
    $table->string('role')->default('attendee');
    $table->timestamp('joined_at')->nullable();
    $table->timestamp('left_at')->nullable();
    $table->text('notes')->nullable();
    $table->unsignedTinyInteger('num_guests')->default(0);
    $table->timestamps();
    
    $table->unique(['user_id', 'event_id']);
    $table->index('action_status');
    $table->index('role');
});
```

### Event Model Update

```php
// Event.php - Add relationships
public function attendances(): HasMany
{
    return $this->hasMany(EventAttendance::class);
}

public function confirmedAttendees(): HasManyThrough
{
    return $this->hasManyThrough(User::class, EventAttendance::class)
        ->where('action_status', ActionStatusType::COMPLETED->value);
}

// Update toSchemaOrg()
public function getAttendeeSchemaOrg(): array
{
    return $this->attendances
        ->where('action_status', ActionStatusType::COMPLETED->value)
        ->map(fn($att) => [
            '@type' => 'Person',
            'name' => $att->user->name,
        ])
        ->toArray();
}

// In toSchemaOrg(), add:
'attendee' => $this->getAttendeeSchemaOrg(),
'maximumAttendeeCapacity' => $this->max_attendees,
'remainingAttendeeCapacity' => $this->remaining_capacity,
```

### Actions

```php
// Actions/JoinEventAction.php
class JoinEventAction
{
    use QueueableAction;
    
    public function execute(User $user, Event $event, array $data = []): EventAttendance
    {
        return EventAttendance::updateOrCreate(
            ['user_id' => $user->id, 'event_id' => $event->id],
            [
                'action_type' => 'join',
                'action_status' => ActionStatusType::COMPLETED->value,
                'role' => $data['role'] ?? AttendeeRole::ATTENDEE->value,
                'joined_at' => now(),
                'left_at' => null,
                'num_guests' => $data['num_guests'] ?? 0,
            ]
        );
    }
}

// Actions/LeaveEventAction.php
class LeaveEventAction
{
    use QueueableAction;
    
    public function execute(User $user, Event $event): EventAttendance
    {
        return EventAttendance::updateOrCreate(
            ['user_id' => $user->id, 'event_id' => $event->id],
            [
                'action_type' => 'leave',
                'action_status' => ActionStatusType::COMPLETED->value,
                'left_at' => now(),
            ]
        );
    }
}
```

### Livewire Component

```php
// Livewire/RsvpButton.php
class RsvpButton extends Component
{
    public Event $event;
    public bool $isAttending = false;
    
    public function mount(Event $event): void
    {
        $this->event = $event;
        $this->isAttending = $this->event->attendances()
            ->where('user_id', auth()->id())
            ->where('action_type', 'join')
            ->exists();
    }
    
    public function toggleRsvp(): void
    {
        if (!auth()->check()) {
            $this->redirect(route('login'));
            return;
        }
        
        if ($this->isAttending) {
            app(LeaveEventAction::class)->execute(auth()->user(), $this->event);
        } else {
            app(JoinEventAction::class)->execute(auth()->user(), $this->event);
        }
        
        $this->isAttending = !$this->isAttending;
    }
}
```

---

## Implementation Steps

- [ ] Create `ActionStatusType` enum
- [ ] Create `AttendeeRole` enum
- [ ] Create `meetup_event_attendances` migration
- [ ] Create `EventAttendance` model
- [ ] Add relationships to `Event` model
- [ ] Implement `toJoinActionSchema()` and `toLeaveActionSchema()`
- [ ] Update `Event::toSchemaOrg()` with attendees
- [ ] Create `JoinEventAction` and `LeaveEventAction`
- [ ] Create Livewire `RsvpButton` component
- [ ] Create Blade view for RSVP button
- [ ] Add translations
- [ ] Write Pest tests
- [ ] Update documentation

---

## Related Files

- `Modules/Meetup/app/Models/EventAttendance.php` (new)
- `Modules/Meetup/app/Models/Event.php`
- `Modules/Meetup/app/Enums/ActionStatusType.php` (new)
- `Modules/Meetup/app/Enums/AttendeeRole.php` (new)
- `Modules/Meetup/app/Actions/JoinEventAction.php` (new)
- `Modules/Meetup/app/Actions/LeaveEventAction.php` (new)
- `Modules/Meetup/app/Livewire/RsvpButton.php` (new)

---

## Acceptance Criteria

1. Users can RSVP to events (join)
2. Users can un-RSVP from events (leave)
3. Attendance tracked with timestamps
4. Proper Schema.org JoinAction/LeaveAction output
5. Event shows attendee count and list
6. Multiple roles supported (attendee, speaker, etc.)
7. PHPStan Level 10 passes
8. Pest tests cover all scenarios

---

**Created**: 2026-02-10
**Reference**: [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md)
