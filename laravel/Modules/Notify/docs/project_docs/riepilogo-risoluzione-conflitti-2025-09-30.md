# Riepilogo Risoluzione Conflitti – 2025-09-30

## Obiettivo
- Identificare file con marcatori di conflitto Git (`<<<<<<< HEAD`, `=======`, `>>>>>>>`) e definire una strategia di risoluzione.
- Allineare le modifiche alle regole Laraxot/Xot, Filament 3 e agli standard di codifica del progetto (PHP strict types, type hints, `getFormSchema()` per Filament, ecc.).

## File con conflitti principali
- `laravel/Modules/User/app/Models/BaseUser.php`
- `laravel/Modules/User/app/Filament/Pages/Dashboard.php`
- `laravel/Modules/Notify/app/Filament/Resources/NotifyThemeResource/RelationManagers/LinkableRelationManager.php`
- `laravel/Modules/Notify/resources/views/filament/pages/send-push-notification.blade.php`
- `laravel/Modules/User/app/Filament/Pages/Auth/PasswordExpired.php`

## Strategia di risoluzione
- Preferire sempre estensioni Xot/Laraxot (XotBase*) rispetto alle classi base Laravel/Filament quando previsto dalle regole.
- Per Filament:
  - Usare `getFormSchema()` nelle pagine/manager e NON metodi `form()`.
  - Evitare `->label()`; le label sono demandate alle traduzioni.
- Ripulire gli import duplicati e unificare i nomi (es. `Schema` alias per evitare collisioni con `Filament\Schemas\Schema` quando necessario).
- Conservare la variante più moderna/robusta delle funzioni (es. fallback sicuri, override con `#[Override]`, ritorni tipizzati).

## Decisioni specifiche per file
- `LinkableRelationManager.php`:
  - Mantieni `XotBaseRelationManager` e definisci `protected static ?string $recordTitleAttribute = 'id'`.
  - Implementa solo `getFormSchema()` con `TextInput::make('id')` richiesto e `maxLength(255)`.
- `send-push-notification.blade.php`:
  - Unifica in un singolo layout Filament 3 con `<x-filament-panels::page>` e `<x-filament::section>` usando slot `heading`, `description` e `footer` con `x-filament-panels::form.actions`.
- `PasswordExpired.php`:
  - Usa alias `Illuminate\Support\Facades\Schema as DatabaseSchema` per evitare collisione con `Filament\Schemas\Schema` presente nei docblock.
- `Dashboard.php`:
  - Estendi `XotBaseDashboard`.
  - `getWidgets()` ritorna `UsersChartWidget::make([...])` e `RecentLoginsWidget::class`.
  - `getFiltersFormSchema()` ritorna due `DatePicker` con `->native(false)`.
- `BaseUser.php`:
  - Consolidamento di import, traits (HasApiTokens, HasAuthenticationLogTrait, HasTeams, RelationX, ecc.) e metodi (`getFilamentName()`, `profile()`, accessors per `full_name`/`name`, `setPasswordAttribute()`, `hasRole(...)`).
  - Rimozione marcatori di conflitto e garantire fallback sicuri in assenza DB durante test.

## Prossimi passi
1. Applicare fix ai file Notify e alle pagine User minori (completato a step progressivi).
2. Finalizzare `Dashboard.php` e `BaseUser.php`.
3. Rieseguire una scansione completa dei marcatori di conflitto.
4. Aggiornare questo documento con esito finale.

## Note qualità
- `declare(strict_types=1);` in testa a ogni file PHP.
- Tipi di ritorno dichiarati e PHPDoc per metodi pubblici.
- Coerenza namespace secondo convenzioni `Modules/*`.
