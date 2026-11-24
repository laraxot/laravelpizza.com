---
title: "Contratto — SendOtpByUserAction"
type: contract
action: "Modules\\User\\Actions\\Otp\\SendOtpByUserAction"
tags: [contract, action, otp, mail]
created: 2026-11-24
updated: 2026-11-24
owner: User
status: accepted
qmd: "SendOtpByUserAction OTP password temporanea invio email scadenza is_otp notifica Filament hash"
---

# SendOtpByUserAction

Sorgente: `app/Actions/Otp/SendOtpByUserAction.php`.

## Input

- `UserContract $user`: destinatario; dipendenze iniettate `PasswordData` (scadenza), `Str`, `Otp\Hasher`.

## Output

- `void`.

## Invarianti

| ID | Regola | Group Pest |
|---|---|---|
| USER-OTP-SEND-INV-1 | La password temporanea (12 caratteri casuali) si salva solo come hash; in chiaro esiste solo nella notifica. | — |
| USER-OTP-SEND-INV-2 | `is_otp = true` e `password_expires_at = now + PasswordData::otp_expiration_minutes`. | — |
| USER-OTP-SEND-INV-3 | La notifica `Notifications\Auth\Otp` parte on-demand verso `$user->email`. | — |

Provate da `tests/Unit/Actions/Otp/SendOtpByUserActionTest.php`, che richiede un database di test migrato: il group si
aggiunge quando il test gira verde.

## Effetti collaterali

- `update()` dell'utente: **sostituisce la password** corrente con l'OTP.
- Notifica mail (`Notification::route('mail', ...)`): `Notifications\Auth\Otp` implementa `ShouldQueue`, quindi l'invio è in coda.
- Notifica Filament di successo nella sessione corrente.

## Errori

- Errori del database o del mailer si propagano; nessun rollback: se la mail fallisce, la password è già cambiata.

## Non fa

- Non verifica l'OTP (`VerifyOtpHashAction`) né forza il cambio password al login successivo (lo fa chi legge `is_otp`).
- Non limita la frequenza degli invii: chi la espone in una pagina deve frenarla.
- Non verifica che `$user->email` sia valorizzato prima di inviare: l'indirizzo può essere null.
- Mescola un effetto UI (notifica Filament di successo) con la logica di dominio: se l'Action deve girare in coda o via API, quell'effetto va spostato.
