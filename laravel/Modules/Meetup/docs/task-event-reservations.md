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
        'price_currency',
        'booking_time',
        'modified_time',
        'confirmation_number',
        'num_tickets',
        'notes',
    ];
    
    protected $casts = [
        'total_price' => 'decimal:2',
        'booking_time' => 'datetime',
        'modified_time' => 'datetime',
        'num_tickets' => 'integer',
    ];
    
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    
    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }
    
    public function toSchemaOrg(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'EventReservation',
            'reservationId' => $this->reservation_id,
            'reservationStatus' => 'https://schema.org/Reservation' . $this->status,
            'reservationFor' => $this->event->toSchemaOrg(),
            'underName' => [
                '@type' => 'Person',
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'totalPrice' => $this->total_price,
            'priceCurrency' => $this->price_currency,
            'reservedTicket' => $this->ticket?->toSchemaOrg(),
            'bookingTime' => $this->booking_time->toIso8601String(),
            'modifiedTime' => $this->modified_time?->toIso8601String(),
            'confirmationNumber' => $this->confirmation_number,
        ];
    }
    
    protected static function boot(): void
    {
        parent::boot();
        
        static::creating(function ($reservation) {
            $reservation->reservation_id = $reservation->reservation_id 
                ?? Str::uuid()->toString();
            $reservation->confirmation_number = $reservation->confirmation_number 
                ?? strtoupper(Str::random(8));
            $reservation->booking_time = $reservation->booking_time ?? now();
        });
    }
}
```

### New Model: Ticket (Offer)

```php
// Models/Ticket.php
class Ticket extends BaseModel
{
    protected $fillable = [
        'event_id',
        'name',
        'description',
        'price',
        'price_currency',
        'availability',
        'valid_from',
        'valid_through',
        'max_quantity',
        'sold_count',
        'sort_order',
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_through' => 'datetime',
        'max_quantity' => 'integer',
        'sold_count' => 'integer',
    ];
    
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }
    
    public function reservations(): HasMany
    {
        return $this->hasMany(EventReservation::class);
    }
    
    public function getRemainingAttribute(): int
    {
        return max(0, $this->max_quantity - $this->sold_count);
    }
    
    public function getIsAvailableAttribute(): bool
    {
        $now = now();
        return $this->remaining > 0
            && ($this->valid_from === null || $now >= $this->valid_from)
            && ($this->valid_through === null || $now <= $this->valid_through);
    }
    
    public function toSchemaOrg(): array
    {
        return [
            '@type' => 'Offer',
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price ?? 0,
            'priceCurrency' => $this->price_currency,
            'availability' => 'https://schema.org/' . $this->availability,
            'validFrom' => $this->valid_from?->toIso8601String(),
            'validThrough' => $this->valid_through?->toIso8601String(),
            'url' => route('events.tickets', [$this->event_id]),
            'eligibleQuantity' => [
                '@type' => 'QuantitativeValue',
                'maxValue' => $this->max_quantity,
                'value' => $this->remaining,
            ],
        ];
    }
}
```

### Enum: ReservationStatus

```php
// Enums/ReservationStatus.php
enum ReservationStatus: string
{
    case CONFIRMED = 'Confirmed';
    case PENDING = 'Pending';
    case CANCELLED = 'Cancelled';
    case HOLD = 'Hold';
    
    public function label(): string
    {
        return match($this) {
            self::CONFIRMED => 'Confirmed',
            self::PENDING => 'Pending',
            self::CANCELLED => 'Cancelled',
            self::HOLD => 'On Hold',
        };
    }
    
    public function color(): string
    {
        return match($this) {
            self::CONFIRMED => 'success',
            self::PENDING => 'warning',
            self::CANCELLED => 'danger',
            self::HOLD => 'info',
        };
    }
}
```

### Enum: ItemAvailability

```php
// Enums/ItemAvailability.php
enum ItemAvailability: string
{
    case IN_STOCK = 'InStock';
    case OUT_OF_STOCK = 'OutOfStock';
    case PRE_ORDER = 'PreOrder';
    case LIMITED = 'LimitedAvailability';
    case SOLD_OUT = 'SoldOut';
    case ONLINE_ONLY = 'OnlineOnly';
    
    public function label(): string
    {
        return match($this) {
            self::IN_STOCK => 'Available',
            self::OUT_OF_STOCK => 'Out of Stock',
            self::PRE_ORDER => 'Pre-order',
            self::LIMITED => 'Limited Availability',
            self::SOLD_OUT => 'Sold Out',
            self::ONLINE_ONLY => 'Online Only',
        };
    }
}
```

### Database Migrations

```php
// create_meetup_tickets_table.php
Schema::create('meetup_tickets', function (Blueprint $table) {
    $table->id();
    $table->foreignId('event_id')->constrained('meetup_events')->cascadeOnDelete();
    $table->string('name');
    $table->text('description')->nullable();
    $table->decimal('price', 10, 2)->default(0);
    $table->string('price_currency', 3)->default('EUR');
    $table->string('availability')->default('InStock');
    $table->timestamp('valid_from')->nullable();
    $table->timestamp('valid_through')->nullable();
    $table->unsignedInteger('max_quantity')->default(100);
    $table->unsignedInteger('sold_count')->default(0);
    $table->unsignedSmallInteger('sort_order')->default(0);
    $table->timestamps();
    $table->softDeletes();
    
    $table->index(['event_id', 'availability']);
});

// create_meetup_event_reservations_table.php
Schema::create('meetup_event_reservations', function (Blueprint $table) {
    $table->id();
    $table->uuid('reservation_id')->unique();
    $table->foreignId('user_id')->constrained()->cascadeOnDelete();
    $table->foreignId('event_id')->constrained('meetup_events')->cascadeOnDelete();
    $table->foreignId('ticket_id')->nullable()->constrained('meetup_tickets')->nullOnDelete();
    $table->string('status')->default('Pending');
    $table->decimal('total_price', 10, 2)->default(0);
    $table->string('price_currency', 3)->default('EUR');
    $table->timestamp('booking_time');
    $table->timestamp('modified_time')->nullable();
    $table->string('confirmation_number', 20)->unique();
    $table->unsignedTinyInteger('num_tickets')->default(1);
    $table->text('notes')->nullable();
    $table->timestamps();
    $table->softDeletes();
    
    $table->index(['user_id', 'status']);
    $table->index(['event_id', 'status']);
});
```

### Event Model Update

```php
// Event.php
public function tickets(): HasMany
{
    return $this->hasMany(Ticket::class)->orderBy('sort_order');
}

public function reservations(): HasMany
{
    return $this->hasMany(EventReservation::class);
}

public function availableTickets(): HasMany
{
    return $this->tickets()
        ->where('availability', ItemAvailability::IN_STOCK->value)
        ->whereRaw('sold_count < max_quantity');
}

// Update toSchemaOrg()
public function getOffersSchemaOrg(): array
{
    return $this->tickets->map->toSchemaOrg()->toArray();
}

// In toSchemaOrg(), replace 'offers' with:
'offers' => $this->getOffersSchemaOrg(),
```

### Actions

```php
// Actions/CreateReservationAction.php
class CreateReservationAction
{
    use QueueableAction;
    
    public function execute(
        User $user, 
        Event $event, 
        Ticket $ticket, 
        int $quantity = 1
    ): EventReservation {
        // Validate availability
        if ($ticket->remaining < $quantity) {
            throw new InsufficientTicketsException();
        }
        
        DB::transaction(function () use ($user, $event, $ticket, $quantity, &$reservation) {
            // Create reservation
            $reservation = EventReservation::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'ticket_id' => $ticket->id,
                'status' => ReservationStatus::CONFIRMED->value,
                'total_price' => $ticket->price * $quantity,
                'price_currency' => $ticket->price_currency,
                'num_tickets' => $quantity,
            ]);
            
            // Update ticket count
            $ticket->increment('sold_count', $quantity);
            
            // Update availability if sold out
            if ($ticket->remaining <= 0) {
                $ticket->update(['availability' => ItemAvailability::SOLD_OUT->value]);
            }
        });
        
        return $reservation;
    }
}
```

---

## Implementation Steps

- [ ] Create `ReservationStatus` enum
- [ ] Create `ItemAvailability` enum
- [ ] Create `meetup_tickets` migration
- [ ] Create `meetup_event_reservations` migration
- [ ] Create `Ticket` model with Schema.org support
- [ ] Create `EventReservation` model with Schema.org support
- [ ] Update `Event` model with ticket relationships
- [ ] Update `Event::toSchemaOrg()` with offers
- [ ] Create `CreateReservationAction`
- [ ] Create `CancelReservationAction`
- [ ] Create Filament resources for management
- [ ] Create frontend reservation flow
- [ ] Add email notifications for reservations
- [ ] Add translations
- [ ] Write Pest tests
- [ ] Update documentation

---

## Related Files

- `Modules/Meetup/app/Models/Ticket.php` (new)
- `Modules/Meetup/app/Models/EventReservation.php` (new)
- `Modules/Meetup/app/Models/Event.php`
- `Modules/Meetup/app/Enums/ReservationStatus.php` (new)
- `Modules/Meetup/app/Enums/ItemAvailability.php` (new)
- `Modules/Meetup/app/Actions/CreateReservationAction.php` (new)
- `Modules/Meetup/app/Filament/Resources/TicketResource.php` (new)
- `Modules/Meetup/app/Filament/Resources/EventReservationResource.php` (new)

---

## Acceptance Criteria

1. Events can have multiple ticket types
2. Users can make reservations for tickets
3. Ticket availability updates automatically
4. Reservations tracked with confirmation numbers
5. Proper Schema.org EventReservation/Offer output
6. Email notifications sent for reservations
7. PHPStan Level 10 passes
8. Pest tests cover all scenarios

---

**Created**: 2026-02-10
**Reference**: [schema-org-research-comprehensive.md](./schema-org-research-comprehensive.md)
