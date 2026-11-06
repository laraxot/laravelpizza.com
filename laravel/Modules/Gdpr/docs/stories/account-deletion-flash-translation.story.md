---
title: "Flash message account_deleted tradotta e integrata nel layout (Gdpr + Sixteen)"
type: story
status: completed
created: 2026-10-15
updated: 2026-10-15
module: Gdpr
tags: [flash, translation, toast, account-deletion]
---

# Flash message account_deleted tradotta e integrata nel layout (Gdpr + Sixteen)

## Richiesta
`DeleteAccountAction` faceva `->with('status', 'account_deleted')` ma:
1. la stringa non era tradotta in nessun file lang;
2. nessun layout la consumava (la flash veniva persa dopo il redirect).

## Analisi
- I flash messages esistenti (`verification-link-sent`, `password-updated`, `profile-updated`, `email-verified`) sono
  consumati **inline** dalle viste che li generano, non da un layout centrale.
- `account.delete` è l'unica route che redirect su `/{locale}` ( homepage ), quindi la flash deve essere letta dal layout
  principale, non dalla vista di delete.
- `layouts/main.blade.php` è l'unico layout che capisce tutte le pagine (ha `@livewire('notifications')` e
  `livewire:toast`).

## Modifiche
- `Modules/Gdpr/lang/{it,en,de,es}/account.php`: aggiunta chiave `flash.account_deleted` con testo che include il riferimento
  all'art. 17 GDPR.
- `Themes/Sixteen/resources/views/layouts/main.blade.php`: script inline che legge `session('status')`, traduce
  `namespace.key` tramite `__()`, e chiama `window.toast(message, { type: 'success' })` se il toast è inizializzato.

## Verifica
```bash
php -l Modules/Gdpr/lang/*/account.php  # tutti OK
php -l Themes/Sixteen/resources/views/layouts/main.blade.php  # OK
phpstan analyse Modules  # 0 errors
```

## Decisioni
- **D-1**: le flash messages usano la convenzione `namespace.key` (es. `account.delete.flash.account_deleted`) per
  evitare collisioni tra moduli.
- **D-2**: la traduzione avviene lato server (`__()`) prima di iniettare nel JS, non lato client.
- **D-3**: il toast viene inizializzato solo se `window.toast` è già pronto (il livewire:toast lo è dopo l'init).

## Aperto
- Test end-to-end del flusso cancellazione account richiede DB (non disponibile in questo ambiente).