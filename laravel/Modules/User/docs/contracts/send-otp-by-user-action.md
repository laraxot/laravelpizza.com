---
<<<<<<< HEAD
title: "Contratto — SendOtpByUserAction"
type: contract
action: "Modules\User\Actions\Otp\SendOtpByUserAction"
tags: [contract, action, otp, mail]
created: 2026-11-24
updated: 2026-11-24
=======
title: "SendOtpByUserAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Otp\\SendOtpByUserAction"
qmd: "SendOtpByUserAction OTP password temporanea invio email scadenza is_otp notifica Filament hash"
>>>>>>> laraxot/dev
---

# SendOtpByUserAction

<<<<<<< HEAD
Sorgente: `app/Actions/Otp/SendOtpByUserAction.php`.

## Input

- `UserContract $user`: destinatario; dipendenze iniettate `PasswordData` (scadenza), `Str`, `Otp\Hasher`.
=======
Genera una password temporanea (OTP), la salva come hash con scadenza e la invia all'utente via email. Codice: `app/Actions/Otp/SendOtpByUserAction.php:21-103`.

## Input

- `UserContract $user`: destinatario (`execute`, riga 36).
- Dipendenze: `PasswordData` (scadenza in minuti), `Str` (generatore casuale), `Otp\Hasher` (wrapper dello stesso namespace, righe 25-29).
>>>>>>> laraxot/dev

## Output

- `void`.

## Invarianti

<<<<<<< HEAD
| ID | Regola | Group Pest |
|---|---|---|
| USER-OTP-SEND-INV-1 | La password temporanea (12 caratteri casuali) si salva solo come hash; in chiaro esiste solo nella notifica. | — |
| USER-OTP-SEND-INV-2 | `is_otp = true` e `password_expires_at = now + PasswordData::otp_expiration_minutes`. | — |
| USER-OTP-SEND-INV-3 | La notifica `Notifications\Auth\Otp` parte on-demand verso `$user->email`. | — |

Provate da `tests/Unit/Actions/Otp/SendOtpByUserActionTest.php`, che richiede un database di test migrato: il group si
aggiunge quando il test gira verde.

## Effetti collaterali

- `update()` dell'utente: **sostituisce la password** corrente con l'OTP.
- Notifica mail (`Notification::route('mail', ...)`), in coda o sincrona secondo la notifica.
- Notifica Filament di successo nella sessione corrente.

## Errori

- Errori del database o del mailer si propagano; nessun rollback: se la mail fallisce, la password è già cambiata.

## Non fa

- Non verifica l'OTP (`VerifyOtpHashAction`) né forza il cambio password al login successivo (lo fa chi legge `is_otp`).
- Non limita la frequenza degli invii: chi la espone in una pagina deve frenarla.
=======
| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `SEND-OTP-INV-1` | Nel database finisce solo l'hash della password temporanea, mai il valore in chiaro. | righe 38, 75-79 | `tests/Unit/Actions/User/UserMiscActionsTest.php`, `tests/Unit/Actions/AdditionalActionsTest.php`, `tests/Unit/Actions/Otp/SendOtpByUserActionTest.php` (riferimenti alla classe) |
| `SEND-OTP-INV-2` | Il campo `password` dell'utente è sostituito: la password precedente smette di valere. | riga 76 | come sopra |
| `SEND-OTP-INV-3` | La scadenza è `now + otp_expiration_minutes` di `PasswordData`. | righe 61-63, 78 | come sopra |
| `SEND-OTP-INV-4` | L'ordine è: aggiornamento utente, poi notifica mail, poi notifica Filament. | righe 41-43 | come sopra |

## Effetti collaterali

Nell'ordine: UPDATE su `users` (password, `is_otp`, `password_expires_at`), poi `Notification::route('mail')->notify(Otp)` (la notifica implementa `ShouldQueue`, quindi l'invio è in coda), poi notifica di successo Filament a schermo. Nessuna transazione: se la notifica fallisce la password è già cambiata.

## Errori

- Nessuna gestione esplicita: errori di database o di coda si propagano.

## Non fa

- Non verifica che `$user->email` sia valorizzato prima di inviare (dubbio: l'indirizzo può essere null).
- Non applica limiti di frequenza.
- Usa un'API UI (notifica Filament) dentro un'Action di dominio: effetto da spostare se l'Action deve girare in coda o via API.
>>>>>>> laraxot/dev
