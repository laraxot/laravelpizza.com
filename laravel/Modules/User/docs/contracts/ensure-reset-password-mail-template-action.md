---
title: "EnsureResetPasswordMailTemplateAction — contratto"
type: contract
owner: User
status: accepted
updated: 2026-11-24
action: "Modules\\User\\Actions\\Auth\\EnsureResetPasswordMailTemplateAction"
qmd: "EnsureResetPasswordMailTemplateAction template mail reset-password lingue it en de es placeholder reset_password_url DCP-285"
---

# EnsureResetPasswordMailTemplateAction

Garantisce il template `reset-password` della mail di reimpostazione password, in tutte le lingue del sito (DCP-285, D-05). Codice: `app/Actions/Auth/EnsureResetPasswordMailTemplateAction.php:20-78`.

## Input

- Nessuno.

## Output

- `MailTemplate` esistente o appena creato (riga 53).

## Invarianti

| ID | Regola | Prova nel codice | Test |
|---|---|---|---|
| `MAIL-TPL-INV-1` | Il template è identificato da `mailable` = `SpatieEmail` e `slug` = `reset-password`; se manca viene creato con layout `base.html`. | righe 24, 38-41 | Test: nessuno. |
| `MAIL-TPL-INV-2` | Per ogni lingua in `it`, `en`, `de`, `es` il testo è scritto solo se la lingua è vuota oppure contiene ancora il default legacy e non il segnaposto URL. | righe 27-30, 43-45, 56-65 | Test: nessuno. |
| `MAIL-TPL-INV-3` | Un testo personalizzato non viene mai sovrascritto. | righe 60-64 | Test: nessuno. |
| `MAIL-TPL-INV-4` | Il salvataggio avviene solo se il modello è sporco: una seconda esecuzione a contenuto invariato non scrive. | righe 49-51 | Test: nessuno. |

## Effetti collaterali

Ordine: `firstOrCreate` (eventuale INSERT), poi scrittura per lingua in memoria, poi un solo `save()` se sporco. Nessuna transazione esplicita, nessun invio di mail, nessuna coda.

## Errori

- Nessuna gestione esplicita: gli errori del database si propagano.

## Non fa

- Non invia mail né verifica che il layout `base.html` esista.
- Controlla solo il campo `html_template` per decidere se riscrivere una lingua: `subject` e `text_template` non sono valutati singolarmente (dubbio: una lingua con HTML personalizzato e `subject` vuoto resta senza oggetto).
