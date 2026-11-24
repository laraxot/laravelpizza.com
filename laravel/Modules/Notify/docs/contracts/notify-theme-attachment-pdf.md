---
title: "NotifyTheme\\Attachment\\Pdf — contratto"
type: contract
owner: Notify
status: accepted
updated: 2026-11-24
action: "Modules\\Notify\\Actions\\NotifyTheme\\Attachment\\Pdf"
qmd: "Pdf allegato PDF notifica tema HtmlToPdf cache disco file_name slug attachment"
---

# NotifyTheme\Attachment\Pdf

Genera il PDF di allegato da un tema notifica (canale `pdf`) e restituisce i dati dell'allegato. Classe senza suffisso `Action`: il nome del file, nella convenzione, usa il prefisso del sottopercorso.

## Input

- `string $post_type`: tipo di post per il tema.
- `array $view_params`: parametri per `Get`.

## Output

- `AttachmentData`: `path` (file su disco cache), `as` (nome file), `mime` = `application/pdf`.

## Invarianti

- `NOTIFY-PDF-INV-1`: il nome file e' `Str::slug(subject).pdf`. Test: `tests/Unit/Actions/NotifyTheme/Attachment/PdfTest.php` (dedicato, asserti non verificati).
- `NOTIFY-PDF-INV-2`: se `$view_params` ha una chiave uguale al nome calcolato, il suo valore sostituisce il nome file. Stesso test.
- `NOTIFY-PDF-INV-3`: il PDF viene scritto con `HtmlToPdfAction` in orientamento verticale, `out = file`, nel disco `cache`. Stesso test.

## Effetti collaterali

- Scrittura di un file PDF sul disco `cache`.
- Effetti di `Get` (vedi [notify-theme-get](notify-theme-get.md)).

## Errori

- `Assert::string` sul nome file. Errori di `HtmlToPdfAction` propagano.

## Rischi rilevati

- Il valore di `$view_params[<nome file>]` diventa il nome file senza validazione: un valore con `../` puo' scrivere fuori dal disco `cache`. Verificare da dove arrivano i `view_params` nei chiamanti.

## Non fa

- Non cancella il file dopo l'uso.
- Non controlla la dimensione del PDF.
