# Coding Conventions (Quality Focus)

## Scope and evidence
This document summarizes conventions observed in the Laravel modular codebase, with concrete evidence from:
- `laravel/app/Application.php`
- `laravel/Modules/Geo/app/Actions/Mapbox/GetAddressFromMapboxAction.php`
- `laravel/Modules/Meetup/app/Actions/Auth/RegisterUserAction.php`
- `laravel/Modules/Media/app/Actions/S3/BaseS3Action.php`
- `laravel/Modules/Xot/app/Actions/File/AddStrictTypesDeclarationAction.php`
- `laravel/Modules/Xot/app/Datas/XotData.php`
- `laravel/Modules/Meetup/app/Models/Event.php`
- `laravel/Modules/Meetup/app/Enums/EventStatus.php`
- `laravel/Modules/User/app/Actions/Passport/RevokeAllUserTokensAction.php`
- `laravel/Modules/Media/app/Exceptions/CouldNotAddUpload.php`

## 1) Code style baseline
### Observed standard
- `declare(strict_types=1);` is consistently present in modern module/application PHP files.
- Typed properties and typed method signatures are widely used.
- Rich PHPDoc is used where generic typing is needed (models, arrays, class-strings).

### Evidence
- `laravel/app/Application.php`
- `laravel/Modules/Geo/app/Actions/Mapbox/GetAddressFromMapboxAction.php`
- `laravel/Modules/Meetup/app/Models/Event.php`
- `laravel/Modules/Xot/app/Datas/XotData.php`

### Practical guidance
- Keep `declare(strict_types=1);` at file top for all new PHP classes.
- Prefer native types first; use PHPDoc only for generics or advanced constraints.
- Keep method return types explicit (`: void`, `: int`, `: ?DataType`).

## 2) Naming conventions
### Observed standard
- PSR-4 module namespaces: `Modules\<Module>\...` with class names in PascalCase.
- Action classes use verb-based names and almost always expose `execute(...)`.
- Data classes are grouped in `Datas` and typically end with `Data`.
- Enum classes end with `Enum`-like domain names (e.g., `EventStatus`) and string-backed cases.

### Evidence
- `laravel/Modules/Meetup/app/Actions/Auth/RegisterUserAction.php`
- `laravel/Modules/User/app/Actions/Passport/RevokeAllUserTokensAction.php`
- `laravel/Modules/Xot/app/Datas/XotData.php`
- `laravel/Modules/Meetup/app/Enums/EventStatus.php`

### Quality risk (naming drift)
- Some paths/files show inconsistent casing or typos in class/file naming patterns in test and support areas (example: mixed lowercase variants in tests, non-standard folder names elsewhere in repo). This increases discoverability/autoload risk.

### Practical guidance
- Keep class/file names PascalCase and aligned 1:1 with class names.
- Keep action naming format: `<Verb><Subject>Action` with single responsibility.
- Avoid introducing new pluralization variants (`Data` vs `Datas`) within the same module.

## 3) Dominant implementation patterns
### Pattern A: Action-oriented domain logic
- Business logic is encapsulated in invokable/queueable action classes, often composable.
- Many actions use `Spatie\QueueableAction\QueueableAction`.

Evidence:
- `laravel/Modules/Meetup/app/Actions/Auth/RegisterUserAction.php`
- `laravel/Modules/Media/app/Actions/S3/BaseS3Action.php`
- `laravel/Modules/User/app/Actions/Passport/RevokeAllUserTokensAction.php`

### Pattern B: Data objects for transport and validation boundaries
- `spatie/laravel-data` style classes are used to shape/transport payloads.

Evidence:
- `laravel/Modules/Xot/app/Datas/XotData.php`
- `laravel/Modules/Geo/app/Actions/Mapbox/GetAddressFromMapboxAction.php` (returns `AddressData`)

### Pattern C: Rich Eloquent models with explicit casts/scopes
- Models include cast maps, fillables, scopes, and relation methods with typed signatures.

Evidence:
- `laravel/Modules/Meetup/app/Models/Event.php`

### Pattern D: Enum-driven domain values
- Domain states are represented by enums with behavior methods.

Evidence:
- `laravel/Modules/Meetup/app/Enums/EventStatus.php`

## 4) Error handling conventions
### Observed techniques
- Input/config guards throw explicit exceptions (`RuntimeException`, `InvalidArgumentException`).
- External integration failures are handled with `try/catch` plus structured logging.
- Domain-specific exceptions exist for clearer semantics.

### Evidence
- Config/input guards: `laravel/Modules/Geo/app/Actions/Mapbox/GetAddressFromMapboxAction.php`
- File validation and explicit failures: `laravel/Modules/Xot/app/Actions/File/AddStrictTypesDeclarationAction.php`
- Domain exception type: `laravel/Modules/Media/app/Exceptions/CouldNotAddUpload.php`
- Logging on external/API failures: `laravel/Modules/Geo/app/Actions/Mapbox/GetAddressFromMapboxAction.php`

### Quality gaps to watch
- Error behavior is not fully uniform across actions (some return `null` after logging, others throw).
- Exception taxonomy is mixed (generic runtime exceptions vs domain exceptions).

### Practical guidance
- For domain failures: prefer module-specific exceptions.
- For infrastructure failures: log with context and throw/return consistently per action contract.
- Document each action contract explicitly: success type, failure type, and whether `null` is allowed.

## 5) Recommended quality guardrails
1. Enforce strict typing and signature completeness for all new classes.
2. Keep action contracts deterministic (`execute` input/output and failure mode).
3. Standardize failure strategy per layer:
   - Domain/action layer: typed/domain exceptions.
   - Adapter/API layer: catch, log context, map to domain-friendly failure.
4. Normalize naming/casing in future touched files to reduce ambiguity.
5. Continue using typed enums/data objects to reduce stringly-typed logic.
