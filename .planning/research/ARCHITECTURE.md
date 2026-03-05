# Architecture Research

**Domain:** Laraxot Modular Monolith (Meetup Platform)
**Researched:** 2026-03-05
**Confidence:** HIGH

## Standard Architecture

### System Overview

```
┌─────────────────────────────────────────────────────────────┐
│                        Frontend Layer                       │
├─────────────────────────────────────────────────────────────┤
│  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐        │
│  │ Folio   │  │ Volt    │  │ Themes  │  │ JSON    │        │
│  │ Pages   │  │ Comps   │  │ Assets  │  │ Content │        │
│  └────┬────┘  └────┬────┘  └────┬────┘  └────┬────┘        │
│       │            │            │            │              │
├───────┴────────────┴────────────┴────────────┴──────────────┤
│                        Module Layer                         │
├─────────────────────────────────────────────────────────────┤
│  ┌─────────────────────────────────────────────────────┐    │
│  │       Modules (Meetup, User, Cms, Notify, etc.)     │    │
│  │   (Models, Actions, Filament Resources, Migrations)  │    │
│  └─────────────────────────────────────────────────────┘    │
├─────────────────────────────────────────────────────────────┤
│                        Core Layer                           │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────┐  ┌──────────┐  ┌──────────┐                   │
│  │ XotBase  │  │ Tenant   │  │ Base     │                   │
│  │ Framework│  │ Router   │  │ Models   │                   │
│  └──────────┘  └──────────┘  └──────────┘                   │
└─────────────────────────────────────────────────────────────┘
```

### Component Responsibilities

| Component | Responsibility | Typical Implementation |
|-----------|----------------|------------------------|
| Cms Module | Resolving and rendering pages from JSON. | `ResolvePageContentAction` + `x-page` component. |
| Meetup Module | Core domain: events, venues, registrations. | Eloquent Models + Spatie Actions. |
| Tenant Module | Database and Theme routing. | `TenantServiceProvider` + Middleware. |
| UI Module | Shared Blade components and Filament bases. | `XotBaseSection`, `XotBaseResource`. |
| User Module | Authentication and profiles. | Laravel Fortify/Breeze + Filament Shield. |

## Recommended Project Structure

```
laravel/
├── Modules/
│   ├── Meetup/
│   │   ├── app/Actions/       # Spatie Queueable Actions
│   │   ├── app/Filament/      # XotBase Filament Resources
│   │   ├── app/Models/        # BaseModels
│   │   ├── lang/              # Localized strings (navigation, fields)
│   │   └── resources/views/   # Module-specific Blade/Volt
│   └── Cms/                   # Page resolution logic
├── Themes/
│   └── Meetup/
│       ├── resources/views/   # Folio Pages & Theme Components
│       └── resources/html/    # Frontend Assets (Vite)
└── config/local/laravelpizza/database/content/pages/  # JSON content files
```

### Structure Rationale

- **Modules/:** Domain isolation. Each module is self-contained with its own logic, UI, and translations.
- **Themes/:** Visual isolation. Decouples the "look and feel" from the business logic in modules.
- **config/local/...:** CMS isolation. Page structure is data, not code, allowing no-code updates.

## Architectural Patterns

### Pattern 1: Spatie Queueable Actions

**What:** Encapsulating a single business operation into a class with an `execute()` method.
**When to use:** For all business logic (e.g., `RegisterUserToEventAction`).
**Trade-offs:** Adds more files, but improves testability and reusability.

**Example:**
```php
class RegisterUserToEventAction {
    use QueueableAction;
    public function execute(Event $event, User $user): Registration {
        // Validation, Creation, Notification
    }
}
```

### Pattern 2: XotBase Wrappers (Filament)

**What:** Extending custom base classes instead of Filament directly.
**When to use:** For all Filament Resources, Pages, and Widgets.
**Trade-offs:** Requires discipline, but ensures project-wide consistency and automation.

**Example:**
```php
class EventResource extends XotBaseResource {
    // Inherits automatic navigation, labels, and permissions.
}
```

### Pattern 3: JSON Content Blocks (CMS)

**What:** Defining page structure as an array of content blocks in JSON.
**When to use:** For all public-facing content pages.
**Trade-offs:** More abstract than plain Blade, but enables the no-code CMS goal.

## Data Flow

### Request Flow

```
[User Request] → [Folio Page] → [Volt Component] → [Spatie Action] → [Eloquent Model]
    ↓                 ↓               ↓                  ↓                  ↓
[HTML Output] ← [Blade Render] ← [DTO/Array] ← [Action Result] ← [Database]
```

### State Management

```
[Livewire Component State]
    ↓ (reactive update)
[Volt Component] ←→ [User Interaction] → [Spatie Action] → [Database Update]
```

### Key Data Flows

1. **Page Rendering:** Folio catches the URL → Cms module reads the corresponding JSON file → `x-page` component iterates through blocks and includes the relevant theme components.
2. **Event Registration:** User submits a Volt form → Volt component calls `RegisterUserToEventAction` → Action validates limits, creates a record, and triggers `NotifyUserAction`.

## Scaling Considerations

| Scale | Architecture Adjustments |
|-------|--------------------------|
| 0-10k users | Standard Monolith on a single server is sufficient. |
| 10k-100k users | Move to a dedicated Database server; use Redis for caching/sessions. |
| 100k+ users | Horizontal scaling of web nodes; consider splitting heavy modules (e.g., Notify) into separate microservices. |

### Scaling Priorities

1. **First bottleneck:** Database queries for event lists. Fix: Use eager loading and Redis caching for the events list JSON.
2. **Second bottleneck:** Real-time ticket updates under high load. Fix: Offload to Laravel Reverb and use broadcast throttling.

## Anti-Patterns

### Anti-Pattern 1: Logic in Blade/Volt

**What people do:** Writing complex DB queries or business rules directly in `.blade.php`.
**Why it's wrong:** Violates separation of concerns and makes testing impossible.
**Do this instead:** Move logic to Spatie Actions and pass results to the view.

### Anti-Pattern 2: Traditional Controllers

**What people do:** Creating `EventController` for public pages.
**Why it's wrong:** Bypasses the Folio/Volt ecosystem and the CMS-driven goal.
**Do this instead:** Use Folio for routing and Volt for interactivity.

## Integration Points

### External Services

| Service | Integration Pattern | Notes |
|---------|---------------------|-------|
| Stripe | Spatie Action Wrapper | For future paid ticketing. |
| Postmark | Mail Driver | For reliable email dispatch. |
| Google Maps | API Wrapper / Static | For venue location display. |

### Internal Boundaries

| Boundary | Communication | Notes |
|----------|---------------|-------|
| Meetup ↔ Notify | Events / Direct Action | Meetup calls Notify's actions to send emails. |
| User ↔ Meetup | Relationships | Users own Profiles and Registrations in Meetup. |

## Sources

- Laraxot Documentation — Modular architecture rules.
- Laravel Folio & Volt Official Docs.
- Spatie Action Pattern Guide.

---
*Architecture research for: Laravel Meetup Platform*
*Researched: 2026-03-05*
