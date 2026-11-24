---
title: "ContentPdfAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Pdf\\ContentPdfAction"
qmd: "ContentPdfAction PDF binario allegato email HTML vista Html2Pdf A4 portrait output S"
---

# ContentPdfAction

Genera il contenuto binario di un PDF da HTML diretto o da una vista Blade, per allegati email.

Codice: `app/Actions/Pdf/ContentPdfAction.php:17-112`.

## Input

- `?string $html`: HTML diretto; se nullo si usa `$view`.
- `?string $view`: nome vista Blade.
- `?array $data`: dati della vista (default array vuoto).
- `string $_filename`: solo riferimento, non usato.

## Output

`string`: contenuto binario del PDF (`output('', 'S')`).

## Invarianti

- `PDF-CONTENT-INV-1`: con `$html` nullo e `$view` valorizzata, la vista deve esistere; altrimenti `\Exception` "View ... not found" (righe 41-44). Test: Nessun test dedicato.
- `PDF-CONTENT-INV-2`: senza HTML né vista, `Assert::string` fallisce (riga 52). Test: Nessun test dedicato.
- `PDF-CONTENT-INV-3`: la configurazione è fissa: portrait, A4, lingua `it`, UTF-8, margini 10 mm (righe 55-63). Test: Nessun test dedicato.
- `PDF-CONTENT-INV-4`: il PDF non viene salvato su disco: il risultato è solo la stringa (riga 68). Test: Nessun test dedicato.

## Effetti collaterali

Rendering della vista; nessuna scrittura su disco, nessun evento, nessuna coda.

## Errori

`\Exception` per vista mancante; `Assert` per input assente; eccezioni di Html2Pdf si propagano.

## Non fa

- `$engine` è una proprietà pubblica non usata.
- Il parametro `$_filename` non ha effetto sul contenuto.
- Il docblock di `fromView` è duplicato in un blocco orfano (righe 81-83).
