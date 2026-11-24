---
title: "SendDuocircleMailAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\Engines\\Duocircle\\SendDuocircleMailAction"
qmd: "SendDuocircleMailAction engine duocircle invio mail WIP stub eccezione"
---

# SendDuocircleMailAction

Engine di invio del driver `duocircle`. Non implementato: copia le proprieta' e lancia sempre un errore WIP.

## Input

- `array $vars`: chiavi stringa diventano proprieta' dell'Action.

## Output

- `void` apparente: il metodo non ritorna, lancia sempre.

## Invarianti

- `NOTIFY-DUOSEND-INV-1`: ogni chiamata lancia `RuntimeException('WIP [<riga>][<classe>]')`. Test: nessuno (nessun riferimento nei test).
- `NOTIFY-DUOSEND-INV-2`: nessuna email viene inviata. Test: nessuno.

## Effetti collaterali

- Nessuno oltre alla copia delle proprieta'.

## Errori

- `RuntimeException` fissa.

## Non fa

- Non invia, non usa `$to`, `$body`, `$from`.
- Il metodo dichiara `: void` nel contratto dell'engine ma non ritorna mai; il dispatcher `SendMailAction` propaga l'errore.
