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
        'cover_image',
        'user_id',         // Creator
        'organizer_id',    // Official organizer
        'venue_id',        // Default venue (optional)
    ];
    
    public function events(): HasMany
    {
        return $this->hasMany(Event::class, 'series_id');
    }
    
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'EventSeries',
            'name' => $this->name,
            'description' => $this->description,
            'startDate' => $this->start_date->toIso8601String(),
            'endDate' => $this->end_date?->toIso8601String(),
            'subEvent' => $this->events->map->toSchemaOrg()->toArray(),
        ];
    }
}
```

### Database Migration

```php
// create_meetup_event_series_table.php
Schema::create('meetup_event_series', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->text('description')->nullable();
    $table->date('start_date');
    $table->date('end_date')->nullable();
    $table->string('frequency')->nullable()->comment('ISO 8601');
    $table->string('status')->default('active');
    $table->string('cover_image')->nullable();
    $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
    $table->foreignId('organizer_id')->nullable()->constrained('users')->nullOnDelete();
    $table->foreignId('venue_id')->nullable();
    $table->timestamps();
    $table->softDeletes();
});

// Add series_id to events table
Schema::table('meetup_events', function (Blueprint $table) {
    $table->foreignId('series_id')->nullable()
        ->constrained('meetup_event_series')->nullOnDelete();
    $table->foreignId('previous_event_id')->nullable()
        ->constrained('meetup_events')->nullOnDelete();
    $table->foreignId('next_event_id')->nullable()
        ->constrained('meetup_events')->nullOnDelete();
});
```

### Event Model Updates

```php
// Event.php - Add relationships
public function series(): BelongsTo
{
    return $this->belongsTo(EventSeries::class, 'series_id');
}

public function previousEvent(): BelongsTo
{
    return $this->belongsTo(Event::class, 'previous_event_id');
}

public function nextEvent(): BelongsTo
{
    return $this->belongsTo(Event::class, 'next_event_id');
}

// Update toSchemaOrg()
public function toSchemaOrg(): array
{
    $schema = [
        // ... existing fields ...
    ];
    
    if ($this->series) {
        $schema['superEvent'] = [
            '@type' => 'EventSeries',
            '@id' => route('event-series.show', $this->series_id),
            'name' => $this->series->name,
        ];
    }
    
    if ($this->previousEvent) {
        $schema['previousStartDate'] = $this->previousEvent->start_date->toIso8601String();
    }
    
    return $schema;
}
```

### Filament Resource

```php
// EventSeriesResource.php
class EventSeriesResource extends XotBaseResource
{
    protected static ?string $model = EventSeries::class;
    
    public static function getFormSchema(): array
    {
        return [
            'basic' => Section::make('Basic Information')
                ->schema([
                    TextInput::make('name')->required()->maxLength(255),
                    Textarea::make('description')->rows(3),
                    DatePicker::make('start_date')->required(),
                    DatePicker::make('end_date'),
                    Select::make('frequency')
                        ->options([
                            'P1W' => 'Weekly',
                            'P2W' => 'Bi-weekly',
                            'P1M' => 'Monthly',
                        ]),
                    Select::make('status')
                        ->options([
                            'active' => 'Active',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                        ])
                        ->default('active'),
                ]),
            'relations' => Section::make('Organization')
                ->schema([
                    Select::make('organizer_id')
                        ->relationship('organizer', 'name')
                        ->searchable()
                        ->preload(),
                    FileUpload::make('cover_image')
                        ->image()
                        ->directory('event-series'),
                ]),
        ];
    }
    
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('events_count')->counts('events'),
            TextColumn::make('start_date')->date()->sortable(),
            BadgeColumn::make('status')
                ->colors([
                    'success' => 'active',
                    'warning' => 'completed',
                    'danger' => 'cancelled',
                ]),
        ];
    }
}
```

---

## Implementation Steps

- [ ] Create `meetup_event_series` migration
- [ ] Add `series_id`, `previous_event_id`, `next_event_id` to events table
- [ ] Create `EventSeries` model with relationships
- [ ] Update `Event` model with series relationships
- [ ] Implement `toSchemaOrg()` for EventSeries
- [ ] Update Event `toSchemaOrg()` with `superEvent`
- [ ] Create `EventSeriesResource` for Filament
- [ ] Add translations
- [ ] Create action to link events in sequence
- [ ] Write Pest tests
- [ ] Update documentation

---

## Related Files

- `Modules/Meetup/app/Models/EventSeries.php` (new)
- `Modules/Meetup/app/Models/Event.php`
- `Modules/Meetup/database/migrations/xxxx_create_event_series.php` (new)
- `Modules/Meetup/app/Filament/Resources/EventSeriesResource.php` (new)

---

## Acceptance Criteria

1. EventSeries model created with proper relationships
2. Events can belong to a series
3. Events can reference previous/next in sequence
4. JSON-LD includes `superEvent` reference
5. Filament resource for managing series
6. PHPStan Level 10 passes
7. Pest tests cover all scenarios

---

**Created**: 2026-02-10
**Reference**: [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md)
