---
title: "SendPushToAllUsersAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Push\\SendPushToAllUsersAction"
qmd: "SendPushToAllUsersAction push tutti utenti token attivi stub nessun token"
---

# SendPushToAllUsersAction

Invio push a tutti i token attivi. Oggi il recupero dei token e' uno stub che restituisce sempre `[]`: l'Action non invia mai.

## Input

- `PushNotificationData $notification`.
- `array $data`.

## Output

- Con token assenti: `['success' => false, 'message' => 'No active tokens found']`.
- Altrimenti: la mappa di `SendPushToDevicesAction` (mai raggiunta oggi).

## Invarianti

- `NOTIFY-PUSHALL-INV-1`: senza token la risposta e' `success = false` con il messaggio fisso. Test: `tests/Unit/NotifyHighestMissCoverageTest.php` (menzione, asserti non verificati).
- `NOTIFY-PUSHALL-INV-2`: `getAllActiveTokens()` restituisce sempre `[]` (riga 42), quindi il ramo di invio non e' eseguibile. Test: nessuno.

## Effetti collaterali

- Nessuno oggi.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non legge alcuno store di token: manca l'implementazione. Finche' e' uno stub, nessuna push parte.
