# Architectural Rules & Guidelines (LaraXot)

## Core Philosophy
**DRY + KISS + SOLID + Robust + LaraXot**

This project follows a strict architectural approach designed for scalability, maintainability, and developer velocity.

## 🚫 STRICT PROHIBITIONS
1.  **NO Controllers**: Do not create standard Laravel Controllers (`Http/Controllers`) for the Front Office.
2.  **NO `web.php` / `api.php` Routes**: Do not define routes in `routes/web.php` or `routes/api.php` for Front Office pages.
3.  **NO Blade Layouts with `@yield`**: Use Components and Slots.

## ✅ MANDATORY ARCHITECTURE

### 1. Routing & Pages (Front Office)
*   **Technology**: **Laravel Folio**
*   **Location**: `resources/views/pages` (or module equivalent)
*   **Pattern**: File-based routing.
    *   URL `/events` -> `pages/events/index.blade.php`
    *   URL `/events/{id}` -> `pages/events/[id].blade.php`

### 2. Logic & State (Front Office)
*   **Technology**: **Laravel Volt** (Functional API preferred)
*   **Pattern**: Co-located logic within Blade files or separate Volt components.
*   **Usage**: Handle form submissions, data fetching, and state management directly in Volt components.

### 3. Admin Panel & Back Office
*   **Technology**: **FilamentPHP**
*   **Pattern**: Use Filament Resources, Pages, and Widgets.
*   **Location**: `app/Filament` or `Modules/Meetup/Filament`.

### 4. Business Logic
*   **Pattern**: **Actions** (Spatie style) or **Services**.
*   **Location**: `app/Actions` or `Modules/Meetup/Actions`.
*   **Usage**: Volt components and Filament Resources should call Actions to perform business logic (e.g., `CreateMeetupAction`).

## Summary of Stack
| Feature | Traditional Laravel ❌ | LaraXot Stack ✅ |
| :--- | :--- | :--- |
| **Routing** | `routes/web.php` | **Folio** (`pages/`) |
| **Logic** | Controllers | **Volt** / **Actions** |
| **UI** | Blade Templates | **Volt Components** + **Tailwind** |
| **Admin** | Nova / Custom | **Filament** |
| **API** | `routes/api.php` | **Filament API** / **Folio API** |

## Memories & Reminders
*   Always prioritize **Robustness**: Type-hint everything, use DTOs where appropriate.
*   **KISS**: Keep components small and focused.
*   **DRY**: Extract reusable logic into Actions or Traits.
