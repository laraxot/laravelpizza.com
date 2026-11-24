---
title: "SendNotificationToRecipientAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SendNotificationToRecipientAction"
qmd: "SendNotificationToRecipientAction notifica email indirizzo route mail Assert email"
---

# SendNotificationToRecipientAction

Invia una `Notification` Laravel a un indirizzo email libero, senza un modello destinatario.

## Input

- `string $recipient`: indirizzo email.
- `IlluminateNotification $notification`: notifica da inviare.
- `?string $locale`: accettato ma non usato.

## Output

- `bool`: sempre `true` se non lancia.

## Invarianti

- `NOTIFY-NOTIFRCPT-INV-1`: un indirizzo non valido lancia l'eccezione di `Assert::email` prima di qualsiasi invio. Test: `tests/Unit/Actions/SendNotificationToRecipientActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-NOTIFRCPT-INV-2`: l'invio usa `Notification::route('mail', $recipient)->notify($notification)`. Stesso test.

## Effetti collaterali

- Invio tramite il sistema notifiche Laravel (canale mail). Il fatto che la notifica sia accodata dipende da `$notification` (ShouldQueue), non dall'Action.

## Errori

- Eccezione di `Assert::email` su indirizzo non valido. Errori del canale mail propagano.

## Non fa

- Non usa `$locale`.
- Non registra l'esito; `true` non significa consegna.
