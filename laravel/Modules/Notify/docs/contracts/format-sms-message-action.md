---
title: "FormatSmsMessageAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SMS\\FormatSmsMessageAction"
qmd: "FormatSmsMessageAction SMS formato caratteri GSM accenti euro conteggio 160 153 messaggi"
---

# FormatSmsMessageAction

Prepara il testo SMS sostituendo i caratteri accentati e stima il numero di caratteri e di SMS.

## Input

- `string $message`.

## Output

- `array{0: string, 1: int, 2: int}`: testo formattato, conteggio caratteri (con escape GSM), numero di SMS.

## Invarianti

- `NOTIFY-SMSFMT-INV-1`: le lettere accentate diventano apostrofate (`è` -> `e'`), `€` diventa `EUR`. Test: `tests/Unit/Actions/SMS/FormatSmsMessageActionTest.php` (dedicato, asserti non verificati).
- `NOTIFY-SMSFMT-INV-2`: i caratteri dell'estensione GSM (`^ { } [ ] ~ \ |`) contano doppio. Stesso test.
- `NOTIFY-SMSFMT-INV-3`: fino a 160 caratteri = 1 SMS; oltre, `ceil(n / 153)`. Stesso test.

## Effetti collaterali

- Nessuno.

## Errori

- Nessuna eccezione propria.

## Non fa

- Non tronca il testo (il troncamento a 320 e' in `SendNotificationAction`).
- Non verifica che i caratteri restanti siano GSM-7: il conteggio e' una stima.
