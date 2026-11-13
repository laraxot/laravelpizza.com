---
title: "User — contratto runtime per le pagine auth del tema"
type: bmad-runtime-contract
status: active
updated: 2026-11-12
---

# Contratto

User possiede middleware, nomi Folio, Volt e azioni di autenticazione. Il tema
Sixteen può sostituire la view per applicare Design Comuni, ma non deve cambiare
throttle, redirect, validazione o notifiche.

La notice `/{locale}/auth/verify` richiede utente autenticato non verificato,
mantiene `verification.notice`, `throttle:6,1` e invia nuovamente la mail tramite
`ResendEmailVerificationAction`. Un utente già verificato deve essere rediretto
come previsto dal test di modulo.

La pagina deve sempre avere una direttiva `@volt` quando contiene una classe Volt
anonima o azioni `wire:*`. Senza `@volt`, l'errore appare solo a runtime durante
la compilazione Folio.

## Matrice minima delle view

Le pagine User restano il trasporto del comportamento; il tema attivo fornisce il
frammento visuale condiviso:

| Flusso | Contratto User | Contratto Sixteen |
|---|---|---|
| Notice verifica | `verification.notice`, `auth` + `throttle:6,1`, `resend()` | `components/pages/auth/verify.blade.php` |
| Conferma password | `password.confirm`, `current_password`, sessione di conferma | `components/pages/auth/password-confirm.blade.php` |
| Password dimenticata | route `password.request`, widget ForgotPassword | alias verso `components/pages/auth/password-reset.blade.php` |
| Nuova password | token Folio + widget ResetPassword | alias verso `components/pages/auth/password-token.blade.php` |

Ogni pagina deve usare `x-layouts.app`, `data-dc` e `x-auth.shell`. Le view duplicate
nel modulo non devono reintrodurre card Bootstrap o layout legacy: sono fallback di
ownership e devono restare parity-safe con il tema attivo.

## Verifica

Il comportamento è protetto da `VerifyEmailResendPageTest`; la parity visuale è
protetta da `Themes/Sixteen/tests/Feature/Pages/VerifyEmailDesignComuniParityTest`.
