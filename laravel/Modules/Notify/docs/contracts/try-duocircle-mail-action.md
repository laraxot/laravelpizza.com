---
title: "TryDuocircleMailAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\Engines\\Duocircle\\TryDuocircleMailAction"
qmd: "TryDuocircleMailAction Webklex IMAP casella lettura messaggi sposta INBOX.read cartelle"
---

# TryDuocircleMailAction

Engine di prova per il driver `duocircle`: si collega alla casella IMAP (Webklex), elenca tutte le cartelle e legge tutti i messaggi.

## Input

- `array $vars`: chiavi stringa diventano proprieta' dell'Action. Nessun altro parametro e' usato.
- Richiede le classi `Webklex\PHPIMAP\Client` e `Webklex\IMAP\Facades\Client` installate.

## Output

- `array<int, array{subject: string, attachments: int, body: string, moved: bool}>`: un elemento per messaggio letto in ogni cartella.

## Invarianti

- `NOTIFY-TRYDUO-INV-1`: senza le classi Webklex lancia `Exception`. Test: `tests/Unit/NotifyHighestMissCoverageTest.php` (menzione, asserti non verificati).
- `NOTIFY-TRYDUO-INV-2`: ogni messaggio di ogni cartella produce un elemento con subject, numero allegati e corpo HTML. Test: nessuno dedicato verificato.
- `NOTIFY-TRYDUO-INV-3`: ogni messaggio viene spostato in `INBOX.read` e il risultato `moved` riflette il ritorno di `move`. Test: nessuno.

## Effetti collaterali

- Connessione IMAP, senza disconnessione esplicita.
- Sposta in `INBOX.read` ogni messaggio letto, in tutte le cartelle: la casella viene modificata.
- Nessuna scrittura su DB.

## Errori

- `UnexpectedValueException` quando un metodo Webklex non restituisce il tipo atteso.
- Eccezioni Webklex propagano.

## Rischi rilevati

- Nessun limite di messaggi: `all()->get()` scarica tutta la casella in memoria per ogni cartella.
- Lo spostamento e' un effetto collaterale non dichiarato nel nome `Try`: chi chiama in test puo' alterare la casella reale.

## Non fa

- Non filtra per data, mittente o stato.
- Non salva ne' registra il contenuto letto.
