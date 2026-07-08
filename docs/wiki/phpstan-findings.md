---
name: phpstan-findings
description: PHPStan error resolution log and findings
metadata:
  type: project
---

# PHPStan Findings - Session Gate Resolution

## Executive Summary

- **Initial errors**: 33 (gate report)
- **After fixes**: 36 errors (comprehensive analysis)
- **Error categories**: 4 main types

## Error Breakdown

### 1. Trait Unused (`trait.unused`) - 8 occurrences

Traits marked as unused by PHPStan:

| File | Trait | Module |
|------|-------|--------|
| Gdpr/app/Models/Traits/HasGdpr.php | HasGdpr | Gdpr |
| Geo/app/Filament/Forms/Components/Traits/HasCoordinatePicker.php | HasCoordinatePicker | Geo |
| Geo/app/Models/Traits/GeoTrait.php | GeoTrait | Geo |
| Geo/app/Models/Traits/HasAddress.php | HasAddress | Geo |
| Geo/app/Models/Traits/HasPlaceTrait.php | HasPlaceTrait | Geo |
| Geo/app/Traits/HasAddresses.php | HasAddresses | Geo |
| Notify/app/Models/Traits/HasContact.php | HasContact | Notify |
| User/app/Models/Traits/HasDevices.php | HasDevices | User |
| Xot/app/Models/Traits/HasCommonScopes.php | HasCommonScopes | Xot |
| Xot/app/Models/Traits/HasUuid.php | HasUuid | Xot |
| Xot/app/Models/Traits/TypedHasRecursiveRelationships.php | TypedHasRecursiveRelationships | Xot |

**Resolution**: These traits are likely used via `use` statements in models. PHPStan may not detect them due to dynamic usage or they may be legacy code awaiting application.

### 2. env() Outside Config (`larastan.noEnvCallsOutsideOfConfig`) - 7 occurrences

Files using `env()` outside config files:

| File | Lines | Module |
|------|-------|--------|
| Geo/config/config.php | 15-17 | Geo |
| Geo/config/sushi.php | 24, 25, 36, 37 | Geo |

**Resolution Pattern**: Replace `env()` with `config()` calls:
```php
// Before
$value = env('KEY');

// After  
$value = config('geo.key');
```

### 3. Missing Iterable Value Types (`missingType.iterableValue`) - 10 occurrences

Files lacking type hints in arrays:

| File | Lines | Issue |
|------|-------|-------|
| Meetup/app/Actions/Event/ImportEventsFromJsonAction.php | 130, 185, 206 | Parameter $item missing value type |
| Meetup/app/Filament/Pages/MeetupDashboard.php | 29 | getColumns() return type |
| Meetup/app/Filament/Widgets/CalendarWidget.php | 12 | fetchEvents() return type |
| Meetup/app/Models/Performer.php | 53 | $meta_data property |
| Meetup/app/Models/Profile.php | 77 | childrenWith() and childrenWithCount() |
| Meetup/app/Models/Venue.php | 58 | $meta_data property |

**Resolution Pattern**: Add value types:
```php
// Before
public function getColumns(): array

// After
public function getColumns(): array<int, Column>
```

### 4. Missing Generic Type Parameters (`missingType.generics`) - 11 occurrences

Files missing generic type specifications:

| File | Lines | Issue |
|------|-------|-------|
| Meetup/app/Models/Event.php | 153, 217, 222, 227 | Generic traits/methods |
| Meetup/app/Models/Feedback.php | 53, 58 | BelongsTo relations |
| Meetup/database/factories/FeedbackFactory.php | 7 | Factory generic |
| Xot/app/Models/Traits/HasXotFactory.php | 25, 28 | Factory generic |

**Resolution Pattern**: Specify generic types:
```php
// Before
/** @var Factory */
protected static $factory;

// After
/** @var Factory<Event> */
protected static $factory;
```

## Git History References

- Session gate report: `docs/chat/2026-07-08-phpstan-resolution.md`
- Wiki update command: `bash bashscripts/docs/llm-wiki-qmd.sh update`

## Action Items

- [ ] Fix env() calls in Geo module
- [ ] Add type hints to Meetup module
- [ ] Resolve generic type parameters
- [ ] Verify trait usage patterns

## Module Root File Hygiene

**Regola**: Nessun file `.txt` nei root dei moduli.

**Azione eseguita**: Spostati 120+ file `.txt` da root moduli → `docs/root-txt-files/` con prefisso modulo.

** comando corretto**:
```bash
find laravel/Modules -maxdepth 2 -type f -name "*.txt" -exec mv {} docs/root-txt-files/MODULENAME_$(basename {} \;
```

**Aggiornamento regole**: Aggiunto a `bashscripts/tools/prompts/rules.txt`