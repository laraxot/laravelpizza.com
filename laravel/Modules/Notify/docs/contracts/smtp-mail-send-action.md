---
title: "SmtpMailSendAction — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\SmtpMailSendAction"
qmd: "SmtpMailSendAction smtp invio mail rimosso debug stub eccezione"
---

# SmtpMailSendAction

Placeholder per l'invio SMTP diretto. Oggi lancia sempre un'eccezione di debug.

## Input

- `string $_to`, `string $_subject`, `string $_body`: non usati.

## Output

- Nessuno: l'Action non ritorna mai, lancia sempre.

## Invarianti

- `NOTIFY-SMTP-INV-1`: ogni chiamata lancia `RuntimeException('Removed debug dddx')`. Test: nessuno (il sorgente e' un residuo di debug).
- `NOTIFY-SMTP-INV-2`: il codice SMTP reale (Symfony Mailer) e' solo nel commento finale del metodo e non viene eseguito. Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- `RuntimeException` fissa, sempre.

## Non fa

- Non invia email.
- Non e' richiamata da altre Action del modulo nei sorgenti: candidata a rimozione dopo verifica dei chiamanti.
