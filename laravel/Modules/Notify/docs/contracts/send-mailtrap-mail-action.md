---
title: "SendMailtrapMailAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\Mail\\SendMailtrapMailAction"
qmd: "SendMailtrapMailAction mailtrap test email invio prova Mail::raw subject"
---

# SendMailtrapMailAction

Invio di prova verso il trasporto Mail configurato (Mailtrap in ambienti di test). Il corpo e' testo grezzo.

## Input

- `string $to`, `string $body`, `array $vars`, `?string $from`.

## Output

- `void`.

## Invarianti

- `NOTIFY-MAILTRAP-INV-1`: il destinatario viene impostato con `$msg->to($this->to)`. Test: nessuno dedicato verificato.
- `NOTIFY-MAILTRAP-INV-2`: il subject e' sempre la stringa fissa `Test Email`. Test: nessuno.
- `NOTIFY-MAILTRAP-INV-3`: un destinatario vuoto lancia `InvalidArgumentException` dentro la closure di `Mail::raw`. Test: nessuno.

## Effetti collaterali

- Una mail via `Mail::raw` sul mailer di default.

## Errori

- `Assert::string` su `$body`; `InvalidArgumentException` per destinatario vuoto.

## Non fa

- Non usa template ne' `$from`: `$from` viene salvato ma non applicato al messaggio.
- Non e' pensata per la produzione: il subject fisso lo rende inadatto a invii reali.
