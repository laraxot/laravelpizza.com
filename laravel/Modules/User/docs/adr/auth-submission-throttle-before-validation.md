---
title: "ADR — Registrazione e recupero password si frenano per IP ed email prima di validare"
type: decision
status: accepted
created: 2026-11-24
updated: 2026-11-24
related:
  - ../../app/Actions/Auth/ConsumeAuthSubmissionSlotAction.php
  - ../../app/Enums/AuthThrottleScope.php
  - ../contracts/consume-auth-submission-slot-action.md
qmd: "auth submission throttle before validation registrazione"
---

# ADR: registrazione e recupero password si frenano per IP ed email prima di validare

## Contesto

- Registrazione e recupero password sono aperti agli anonimi: la prima crea utenti, la seconda manda email (SEC-012).
- Il freno del login (`LoginWidget`) conta solo i tentativi errati: qui non basta, perché anche un invio valido costa
  (insert, query `unique` sull'email, invio di posta).
- Un IP condiviso (un ufficio) non deve bloccarsi subito; chi bersaglia la casella di altri cambia IP.
- Domanda: cosa si conta, quando, e con quali chiavi senza tenere dati personali in cache?

## Decisione

- `ConsumeAuthSubmissionSlotAction::execute(scope, email, ip)` è chiamata **prima** di `form->getState()` in
  `RegisterWidget` e `ForgotPasswordWidget`: ogni invio conta, valido o no.
- Due finestre di `AuthThrottleScope::DECAY_SECONDS` (600 s): per IP (`MAX_PER_IP` = 10) e per email (`maxPerEmail()`:
  5 registrazione, 3 recupero).
- Chiavi `auth-submit:<scope>:<ip|email>:<sha256>`: in cache solo hash.

## Alternative scartate

- Middleware `throttle` sulla rotta: i widget Livewire/Filament non hanno una rotta propria per modulo, e il limite per
  email non si esprime per IP.
- Contare solo gli invii falliti: il bot che registra indirizzi validi non verrebbe mai fermato.
- Chiavi in chiaro: IP ed email resterebbero nello store di cache, fuori da ogni registro dei trattamenti.

## Conseguenze

- Pro: il bot non raggiunge né il database né la posta.
- Contro: un utente vero che sbaglia molte volte aspetta fino a 10 minuti; il messaggio dice quanti secondi.

## Verifica

`Modules/User/tests/Unit/Actions/Auth/ConsumeAuthSubmissionSlotActionTest.php` (groups `USER-AUTH-THROTTLE-INV-1..4`).
Che la chiamata preceda la validazione nei widget: solo revisione di `RegisterWidget::submit()` e `ForgotPasswordWidget`.
