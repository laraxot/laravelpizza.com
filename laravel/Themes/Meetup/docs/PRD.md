# Meetup Theme - Product Requirements Document (PRD)

> Documento vivente. Tema pubblico LaravelPizza.

## 1. Purpose & Vision

Il tema **Meetup** è il tema frontend per LaravelPizza — conversione e miglioramento di laravelpizza.com. Design moderno, UX coinvolgente, conversion-optimized.

**Visione**: "WOW" non "nice" — design che cattura, animazioni che coinvolgono, CTAs che convertono.

## 2. Problem Statement

Senza tema dedicato:
- Design generico
- Nessuna identità visiva per meetup Laravel
- UX non ottimizzata per engagement e condivisione

## 3. Target Users

| User | Ruolo | Bisogni |
|------|-------|---------|
| **Visitante** | Sviluppatore Laravel | Scoprire eventi, iscriversi, condividere |
| **Partecipante** | Iscritto evento | Dettaglio evento, profilo, contatti |
| **Admin** | Configurazione | Personalizzazione colori, logo, header |

## 4. Scope

### In Scope
- Layout principale (app, guest)
- Componenti blocchi (hero, section, footer, header)
- Pagine: home, eventi, dettaglio evento, contatti, about, auth
- Stili Tailwind, animazioni Alpine.js
- SVG in file .svg (no inline)
- Namespace `pub_theme::` per views

### Out of Scope
- E-commerce UI
- Dashboard complessa (Filament)
- PWA offline (estensione futura)

## 5. Functional Requirements (Prioritized)

### P0: Core
- **FR-001**: Layout responsive (mobile-first)
- **FR-002**: Header e footer coerenti
- **FR-003**: Blocchi Cms (hero, block, section)
- **FR-004**: Pagine auth (login, register) con widget Filament
- **FR-005**: Localizzazione URL

### P1: Enhancement
- **FR-006**: Animazioni e micro-interazioni
- **FR-007**: Condivisione social
- **FR-008**: Dark mode (opzionale)

## 6. Non-Functional Requirements

- **NFR-001**: SVG in `resources/svg/`, icon `meetup-*`
- **NFR-002**: Link con `LaravelLocalization::localizeUrl()`
- **NFR-003**: Build: `npm run build` + `npm run copy`
- **NFR-004**: Accessibilità WCAG 2.1

## 7. Technical Architecture

- **Stack**: Tailwind v4, Alpine.js, Blade
- **Namespace**: `pub_theme::` (config via `pub_theme` in xra.php)
- **Dipendenze**: Cms, Meetup, UI, Lang
- **Path**: `laravel/Themes/Meetup/`

## 8. Risks & Assumptions

- Assunzione: pub_theme è Meetup per tenant laravelpizza
- Rischio: conflitti CSS con Filament — namespace isolato

## 9. References

- [PRD Progetto](../../../../docs/prd.md)
- [Modulo Meetup PRD](../../Modules/Meetup/docs/prd.md)
- [Theme Resolution](../../../../.cursor/rules/theme-resolution-critical.md)
- [SVG Icons](./svg-icons-no-hardcoded-blade.md)

## Testing & Coverage

Il tema Meetup segue la **Metodologia "Super Mucca" (Laraxot Zen)**:
- **XotBaseTestCase**: Tutti i test estendono `Modules\Xot\Tests\XotBaseTestCase`.
- **MySQL Only**: Test eseguiti contro MySQL (.env.testing).
- **No RefreshDatabase**: Utilizzo di `DatabaseTransactions`.
- **Automated Migrations**: `XotBaseTestCase` esegue `artisan migrate` automaticamente **una sola volta** per sessione di test.
- **Obiettivo**: 100% di coverage. Se un test fallisce, va sistemato o eliminato se il sito è funzionale.
