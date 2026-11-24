---
title: "GetCurrentDeviceAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\GetCurrentDeviceAction"
qmd: "GetCurrentDeviceAction dispositivo corrente user agent mobile_id Jenssegers Agent device platform browser firstOrCreate"
---

# GetCurrentDeviceAction

Trova o crea la riga `Device` del dispositivo che sta facendo la richiesta, e ne aggiorna browser e versione. Codice: `app/Actions/GetCurrentDeviceAction.php:14-92`.

## Input

- `?string $mobileId`: identificativo del dispositivo mobile, se disponibile (`execute`, riga 26).
- Dipendenze iniettate: `Agent` (user agent) e `Device` (modello).

## Output

- `Device` (riga 42 con `mobile_id`, riga 51 senza).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `DEVICE-INV-1` | Con `$mobileId` non null il dispositivo si cerca per `mobile_id`; con stringa vuota (anche `"0"`) lancia `InvalidArgumentException`. | righe 31-36 | `tests/Unit/Actions/GetCurrentDeviceActionTest.php`, `tests/Unit/Actions/User/UserMiscActionsTest.php` (riferimento alla classe) |
| `DEVICE-INV-2` | Senza `$mobileId` il dispositivo si cerca per tutti i dati di `getDeviceInfo()`. | righe 45-46 | come sopra |
| `DEVICE-INV-3` | Ad ogni chiamata browser, versione e robot sono riscritti sulla riga trovata. | righe 40, 49, 84-90 | come sopra |

## Effetti collaterali

Due scritture per chiamata: `firstOrCreate` (eventuale INSERT) e `update` (UPDATE). Nessuna transazione, nessun evento esplicito.

## Errori

- `InvalidArgumentException` per `mobileId` vuoto.
- Il controllo `RuntimeException` su `null` (righe 37-39, 46-48) non è raggiungibile: `firstOrCreate` non restituisce `null`.

## Non fa

- Non associa il dispositivo all'utente.
- Il ramo senza `mobileId` cerca per tutti i campi: un cambio di versione del browser crea una nuova riga invece di aggiornare la vecchia (conseguenza del criterio di ricerca, da verificare in base ai dati reali).
