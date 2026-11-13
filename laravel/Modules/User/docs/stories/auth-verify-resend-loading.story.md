---
title: "Verify page — spinner su resend email"
type: story
tags: [user, auth, verify, ux, livewire]
created: 2026-11-13
status: done
issues: []
discussions: []
related:
  - "./auth-verify-confirm-design-comuni-shell.story.md"
---

# Verify page — spinner su "richiedine un altro"

## Contesto

Su `/it/auth/verify` il click su "clicca qui per richiederne un altro" parte una
chiamata Livewire (`resend()`) che può richiedere secondi (invio SMTP reale).
Senza feedback l'utente può cliccare di nuovo o pensare che la pagina sia
bloccata. Richiesta esplicita: loading state sempre, senza chiedere.

## Decisione

Nel parziale condiviso
`Themes/Sixteen/resources/views/components/pages/auth/verify.blade.php`:

- `wire:loading.attr="disabled"` + `wire:target="resend"` sul bottone
  (impedisce il doppio invio e tiene coerenza con `login.blade.php`).
- `<x-filament::loading-indicator wire:loading wire:target="resend">` inline +
  testo "invio in corso…" al posto della label, via `wire:loading.remove` /
  `wire:loading` — stesso pattern di `livewire/auth/login.blade.php`.
- Nuova chiave di traduzione `user::auth_pages.verify.request_another.sending`
  in it/en/de/es.

## File toccati

- `Themes/Sixteen/resources/views/components/pages/auth/verify.blade.php`
- `Themes/Sixteen/resources/views/components/auth/assets.blade.php`
  (stili `.auth-link-button__loading` / `:disabled`)
- `Themes/TwentyOne/resources/views/pages/auth/verify.blade.php` (stesso pattern)
- `Modules/User/resources/views/livewire/auth/verify.blade.php` (fallback legacy)
- `Modules/User/lang/{it,en,de,es}/auth_pages.php`
