# PHPStan Errors - Meetup Module

**Date**: 2025-12-16
**PHPStan Level**: 10
**Total Errors**: ~25
**Priority**: 🔴 **P0 - CRITICAL** (Module principale del progetto)

---

## Overview

Il modulo Meetup è il **core business** del progetto Laravel Pizza Meetups. Gli errori PHPStan qui sono critici perché impattano direttamente la funzionalità principale: gestione eventi.

**Errori Principali:**
1. **EventResource.php** - ~17 errori - Usa Filament v3 API invece di v4
2. **Event Actions** - 4 errori - Type safety su CRUD operations
3. **EventCalendarWidget.php** - 2 errori - Return types non precisi
4. **EventResource Pages** - 3 errori - Class not found
5. **MeetupDashboard.php** - 1 errore - Property override errato

---

## 🔴 CRITICAL: EventResource.php (~17 errors)

**File**: `Modules/Meetup/app/Filament/Resources/EventResource.php`
**Severity**: 🔴 Critical
**Root Cause**: Usa `Filament\Forms\Form` (v3) invece di `Filament\Schemas\Schema` (v4)

### Errors

**Line 16:**
```
Non-abstract class contains abstract method getFormSchema() from XotBaseResource
```

**Line 20:**
```
Type string|null of property $navigationIcon is not the same as type
BackedEnum|string|null of overridden property
```

**Line 28 (Multiple errors):**
```php
// ❌ SBAGLIATO - Filament v3 API
public function form(Form $form): Form
{
    return $form->schema([
        Section::make()
            ->schema([
                // ...
            ])
    ]);
}
```

**Errors:**
- `Filament\Forms\Form` class not found (è stato rimosso in v4)
- Method overrides final method `XotBaseResource::form()`
- Parameter `$form` is not contravariant with `$schema`
- Return type is not covariant with `Schema`

---

### ✅ RECOMMENDED FIX: Migrate to Filament v4 Schema API

**Step 1: Implement `getFormSchema()` instead of `form()`**

```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Resources;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Modules\Meetup\Models\Event;
use Modules\Xot\Filament\Resources\XotBaseResource;

/**
 * @property string $model
 */
class EventResource extends XotBaseResource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar';

    protected static ?int $navigationSort = 1;

    // ✅ CORRETTO - Implementa il metodo astratto
    /**
     * @return array<Component>
     */
    public static function getFormSchema(): array
    {
        return [
            Section::make('Event Details')
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),

                    MarkdownEditor::make('description')
                        ->required()
                        ->columnSpan(2),

                    DateTimePicker::make('start_date')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y H:i')
                        ->seconds(false),

                    DateTimePicker::make('end_date')
                        ->required()
                        ->native(false)
                        ->displayFormat('d/m/Y H:i')
                        ->seconds(false)
                        ->after('start_date'),

                    TextInput::make('location')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),

                    TextInput::make('max_participants')
                        ->numeric()
                        ->minValue(1)
                        ->default(50),

                    Select::make('status')
                        ->options([
                            'draft' => 'Draft',
                            'published' => 'Published',
                            'cancelled' => 'Cancelled',
                        ])
                        ->default('draft')
                        ->required(),
                ])
                ->columns(2),
        ];
    }

    // ❌ RIMUOVI QUESTO METODO - Non serve più
    // public function form(Form $form): Form { ... }
}
```

**Step 2: Fix Table Actions**

```php
// Nel metodo table() - Lines 119-125

// ❌ SBAGLIATO
->actions([
    Tables\Actions\EditAction::make(),
    Tables\Actions\DeleteAction::make(),
])

// ✅ CORRETTO - Import corretto
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

->actions([
    EditAction::make(),
    DeleteAction::make(),
])
->bulkActions([
    BulkActionGroup::make([
        DeleteBulkAction::make(),
    ]),
])
```

**Step 3: Fix Navigation Icon Type**

```php
// ❌ SBAGLIATO
protected static ?string $navigationIcon = 'heroicon-o-calendar';

// ✅ CORRETTO - Usa BackedEnum se serve, altrimenti string va bene
protected static string $navigationIcon = 'heroicon-o-calendar';
// Oppure
protected static ?string $navigationIcon = 'heroicon-o-calendar';
```

**Expected Error Reduction**: ~17 errors → 0

---

## Event Actions (~4 errors)

### Error 1: CreateEventAction.php (2 errors)

**File**: `Modules/Meetup/app/Actions/Event/CreateEventAction.php`

**Line 22:**
```php
// ❌ SBAGLIATO
$event = Event::create($data); // array given, array<string, mixed> expected
```

**Line 23:**
```php
// ❌ SBAGLIATO
$event->user_id = auth()->id(); // int|string|null given, int|null expected
```

**✅ FIX:**
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Facades\DB;
use Modules\Activity\Actions\Activity\ActivityLogAction;
use Modules\Meetup\Models\Event;

class CreateEventAction
{
    /**
     * @param array<string, mixed> $data
     */
    public function execute(array $data): Event
    {
        return DB::transaction(function () use ($data) {
            // ✅ Cast esplicito
            $userId = auth()->id();

            if ($userId !== null) {
                $data['user_id'] = (int) $userId; // Cast a int
            }

            /** @var Event $event */
            $event = Event::create($data);

            app(ActivityLogAction::class)->execute(
                event: 'created',
                model: $event,
                user: auth()->user(),
            );

            return $event;
        });
    }
}
```

**Expected Error Reduction**: 2 errors → 0

---

### Error 2: DeleteEventAction.php (1 error)

**File**: `Modules/Meetup/app/Actions/Event/DeleteEventAction.php`

**Line 20:**
```php
// ❌ SBAGLIATO
public function execute(Event $event): bool
{
    return $event->delete(); // Returns bool|null
}
```

**✅ FIX:**
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Facades\DB;
use Modules\Activity\Actions\Activity\ActivityLogAction;
use Modules\Meetup\Models\Event;

class DeleteEventAction
{
    public function execute(Event $event): bool
    {
        return DB::transaction(function () use ($event) {
            app(ActivityLogAction::class)->execute(
                event: 'deleted',
                model: $event,
                user: auth()->user(),
            );

            // ✅ Cast esplicito a bool
            return (bool) $event->delete();
        });
    }
}
```

**Expected Error Reduction**: 1 error → 0

---

### Error 3: UpdateEventAction.php (1 error)

**File**: `Modules/Meetup/app/Actions/Event/UpdateEventAction.php`

**Line 21:**
```php
// ❌ SBAGLIATO
$event->fill($data); // array given, array<string, mixed> expected
```

**✅ FIX:**
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Event;

use Illuminate\Support\Facades\DB;
use Modules\Activity\Actions\Activity\ActivityLogAction;
use Modules\Meetup\Models\Event;

class UpdateEventAction
{
    /**
     * @param array<string, mixed> $data
     */
    public function execute(Event $event, array $data): Event
    {
        return DB::transaction(function () use ($event, $data) {
            // ✅ PHPDoc specifica il tipo
            $event->fill($data);
            $event->save();

            app(ActivityLogAction::class)->execute(
                event: 'updated',
                model: $event,
                user: auth()->user(),
            );

            return $event;
        });
    }
}
```

**Expected Error Reduction**: 1 error → 0

---

## EventResource Pages (~3 errors)

**Files:**
- `Modules/Meetup/app/Filament/Resources/EventResource/Pages/CreateEvent.php`
- `Modules/Meetup/app/Filament/Resources/EventResource/Pages/EditEvent.php`
- `Modules/Meetup/app/Filament/Resources/EventResource/Pages/ListEvents.php`

**Error (all 3 files):**
```
Class Modules\Meetup\Filament\Resources\EventResource not found
```

**Root Cause**: PHPStan can't find EventResource because it has errors. Once EventResource is fixed, these errors will disappear automatically.

**✅ FIX**: Fix EventResource.php first (see above)

**Expected Error Reduction**: 3 errors → 0 (automatically after EventResource fix)

---

## EventCalendarWidget.php (2 errors)

**File**: `Modules/Meetup/app/Filament/Widgets/EventCalendarWidget.php`

### Error 1: Line 59

```php
// ❌ SBAGLIATO
/**
 * @return array<int, array<string, mixed>>
 */
public function fetchEvents(array $fetchInfo = []): array
{
    // Returns array<mixed> invece di array<int, array<string, mixed>>
}
```

**✅ FIX:**
```php
/**
 * @return array<int, array<string, mixed>>
 */
public function fetchEvents(array $fetchInfo = []): array
{
    return Event::query()
        ->whereBetween('start_date', [
            $fetchInfo['start'] ?? now()->startOfMonth(),
            $fetchInfo['end'] ?? now()->endOfMonth(),
        ])
        ->get()
        ->map(function (Event $event): array {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date?->toIso8601String(),
                'end' => $event->end_date?->toIso8601String(),
                'url' => route('filament.admin.resources.events.edit', $event),
                'backgroundColor' => match ($event->status) {
                    'published' => '#10b981',
                    'draft' => '#f59e0b',
                    'cancelled' => '#ef4444',
                    default => '#6b7280',
                },
            ];
        })
        ->values() // ✅ Re-index array to ensure int keys
        ->toArray();
}
```

### Error 2: Line 94

```php
// ❌ SBAGLIATO
/**
 * @return array<int, TextInput|Grid>
 */
protected function getFormSchema(): array
{
    return [
        // ...
        Select::make('status'), // ❌ Select non è nel tipo di ritorno
    ];
}
```

**✅ FIX:**
```php
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;

/**
 * @return array<int, TextInput|Select|Grid>
 */
protected function getFormSchema(): array
{
    return [
        Grid::make(2)
            ->schema([
                TextInput::make('title')
                    ->required(),

                Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                        'cancelled' => 'Cancelled',
                    ]),

                // ... altri campi
            ]),
    ];
}
```

**Expected Error Reduction**: 2 errors → 0

---

## MeetupDashboard.php (1 error)

**File**: `Modules/Meetup/app/Filament/Pages/MeetupDashboard.php`

**Line 12:**
```php
// ❌ SBAGLIATO
class MeetupDashboard extends XotBasePage
{
    protected static string $view = 'meetup::filament.pages.dashboard'; // Static property
}
```

**Error:**
```
Static property $view overrides non-static property XotBasePage::$view
```

**✅ FIX:**
```php
<?php

declare(strict_types=1);

namespace Modules\Meetup\Filament\Pages;

use Modules\Xot\Filament\Pages\XotBasePage;

class MeetupDashboard extends XotBasePage
{
    // ✅ CORRETTO - Non-static come nel parent
    protected string $view = 'meetup::filament.pages.dashboard';

    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $routePath = 'dashboard';

    protected static ?int $navigationSort = -1;

    public static function getNavigationLabel(): string
    {
        return 'Dashboard';
    }
}
```

**Expected Error Reduction**: 1 error → 0

---

## Fix Priority Roadmap

### Phase 1: EventResource Migration (Critical)
**Impact**: Fixes ~17 + 3 = 20 errors
**Time**: 1-2 hours

1. Rimuovi metodo `form()`
2. Implementa `getFormSchema()`
3. Fix import di Actions
4. Fix navigation icon type

### Phase 2: Event Actions Type Safety
**Impact**: Fixes 4 errors
**Time**: 30 minutes

1. Fix CreateEventAction - Cast user_id
2. Fix DeleteEventAction - Cast delete() result
3. Fix UpdateEventAction - Add PHPDoc

### Phase 3: Widget & Dashboard
**Impact**: Fixes 3 errors
**Time**: 30 minutes

1. Fix EventCalendarWidget return types
2. Fix MeetupDashboard property static/non-static

---

## Testing Commands

```bash
# Test Meetup module
./vendor/bin/phpstan analyse Modules/Meetup

# Test specific files
./vendor/bin/phpstan analyse Modules/Meetup/app/Filament/Resources/EventResource.php
./vendor/bin/phpstan analyse Modules/Meetup/app/Actions/Event/

# After fixes - verify
./vendor/bin/phpstan analyse Modules
```

---

## Summary

| File | Errors | Complexity | Priority |
|------|--------|------------|----------|
| EventResource.php | ~17 | ⭐⭐⭐ High | P0 |
| EventResource Pages | 3 | ⭐ Auto-fix | P0 |
| Event Actions | 4 | ⭐ Easy | P0 |
| EventCalendarWidget | 2 | ⭐ Easy | P1 |
| MeetupDashboard | 1 | ⭐ Easy | P1 |
| **TOTALE** | **~27** | **Medium** | **P0** |

**Expected Total Reduction**: ~27 errors → 0

**CRITICAL**: EventResource deve essere fixato SUBITO - è il core del business logic del progetto.

---

**Status**: 🔴 **CRITICAL** - Blocca funzionalità principale
**Owner**: Meetup Module Owner
**Last Updated**: 2025-12-16
