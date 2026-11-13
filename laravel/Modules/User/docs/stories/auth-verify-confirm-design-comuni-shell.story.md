---
title: "Auth verify e password/confirm: allineamento al guscio Design Comuni"
type: story
bmad: true
status: complete
created: 2026-11-12
owner: module:User
module: User
related: [DCP-290, front-office-audit]
tags: [auth, design-comuni, folio, volt, ui-ux]
---

# Auth verify e password/confirm: allineamento al guscio Design Comuni

## Contesto

Segnalazione utente: `/{lang}/auth/verify` non e' coerente con Design Comuni.
Causa: `Modules/User/resources/views/pages/auth/verify.blade.php` e
`auth/password/confirm.blade.php` usano ancora `<x-layouts.main>` (layout legacy
pre-DCP-290): niente header/footer CMS, card Tailwind grigia, testo inglese residuo.

DCP-290 ha convertito login, register, password/reset e password/[token] al pattern
`<x-layouts.app>` + `<div data-dc>` + `<x-auth.shell>` (breadcrumb, card, h1 unico,
classi `.auth-login-*` di `14-auth-login.css`). Queste due pagine sono sfuggite
perche' non sono pagine CMS JSON: sono blade Volt del modulo, quindi non compaiono
negli audit basati su `content/pages/*.json`.

## Pagina sfuggite — inventario

Blade Volt raggiungibili con layout non-DC controllati:

- `auth/verify` — FIX in questa story
- `auth/password/confirm` — FIX in questa story
- `auth/password/reset`, `auth/password/[token]` — gia' OK (DCP-290)
- `auth/login`, `auth/register` — CSS JSON design-comuni (le copie Volt modulo sono shadowed)
- `dashboard`, `notifications`, `profile/edit`, `learn`, `genesis/*`, `mobile/*`,
  `prova`, `artisan-commands-manager`, `errors/password-expired`, `pages/*` —
  irraggiungibili (404 guest o modulo disabilitato): nessuna azione

## Decisione

Riscrivere le due pagine come trasporto + contenuto nel guscio condiviso:

- `<x-layouts.app>` con `:title`/`:meta-description` localizzati
- `<div class="page-content content" data-dc data-side="content">`
- `<x-auth.shell>` per breadcrumb/card/h1
- Il markup interattivo resta Volt (`@volt`), con `x-auth.field` per il campo
  password e classi `.auth-login-*` / `.fi-btn` per il submit (stessa resa dei widget)

Nessun controller, nessun widget nuovo: la logica esistente (ResendEmailVerificationAction,
`password_confirmed_at`) resta invariata.

## File toccati

- `laravel/Modules/User/resources/views/pages/auth/verify.blade.php`
- `laravel/Modules/User/resources/views/pages/auth/password/confirm.blade.php`

## Verifica

- `GET /{lang}/auth/verify` auth → 200, header/footer CMS, h1 nel guscio auth
- `GET /{lang}/auth/password/confirm` → 200 stesso guscio
- `php artisan view:cache` exit 0

## Dev Agent Record — implementazione finale

### Cosa e' emerso in esecuzione

1. **Le pagine vive sono nel tema, non nel modulo.** Le copie in
   `Modules/User/resources/views/pages/auth/` sono shadowed dalle pagine Folio di
   `Themes/Sixteen/resources/views/pages/auth/` (stesso meccanismo della catch-all
   CMS per `area-personale/servizi`). Il fix doveva toccare entrambe: tema = live,
   modulo = fallback coerente.

2. **Vincolo Volt scoperto da `view:cache`:** `VoltDirectiveMissingException` se
   `@volt` non e' figlio diretto di `x-layouts.app`. `@volt` annidato dentro lo
   slot di `<x-auth.shell>` non viene riconosciuto dal precompilatore Volt.
   Pattern corretto (uguale a `auth/password/reset/[token]`): pagina = trasporto
   `x-layouts.app` + `@volt` + `<div data-dc>` + `@include` del partial tema.

3. **Nuovi partial condivisi** in `Themes/Sixteen/resources/views/components/pages/auth/`:
   - `verify.blade.php` — markup `x-auth.shell` + resend/logout (logica nel Volt)
   - `password-confirm.blade.php` — `x-auth.shell` + `x-auth.field` revealable + submit
   Entrambi inclusi anche dalle pagine modulo via `pub_theme::`, come gia' fanno
   `auth-password-reset` e `auth-password-token`.

4. **CSS:** `.auth-link-button` in `components/auth/assets.blade.php` per i bottoni
   azione non-anchor (resend `wire:click`, sign-out submit) con aspetto link e
   focus visibile.

### File toccati (finale)

- `Themes/Sixteen/resources/views/pages/auth/verify.blade.php` — riscritta (trasporto+@volt)
- `Themes/Sixteen/resources/views/pages/auth/password/confirm.blade.php` — riscritta
- `Themes/Sixteen/resources/views/components/pages/auth/verify.blade.php` — NUOVO partial
- `Themes/Sixteen/resources/views/components/pages/auth/password-confirm.blade.php` — NUOVO partial
- `Themes/Sixteen/resources/views/components/auth/assets.blade.php` — `.auth-link-button`
- `Modules/User/resources/views/pages/auth/verify.blade.php` — allineata (fallback)
- `Modules/User/resources/views/pages/auth/password/confirm.blade.php` — allineata

### Verifica eseguita

- `php artisan view:cache` → exit 0 (dopo fix del pattern @volt)
- Guest: `/it|en/auth/verify` → 302 login; `/it|en/auth/password/confirm` → 200
- Auth (Playwright, utente fo.audit): 200 su it+en, h1/title localizzati,
  `.page-content[data-dc]`, `.auth-login-card`, header+footer CMS, zero errori JS
- Sweep layout: nessun'altra pagina FO raggiungibile con `x-layouts.main` o card
  Bootstrap nel tema Sixteen attivo. `Themes/TwentyOne` ha pagine auth legacy ma e'
  tema non attivo (out of scope). `Modules/User/pages/notifications` usa card
  Bootstrap ma la rotta e' irraggiungibile (404, widget esposto in
  `area-personale/notifiche`): dead code, nessuna azione.
