---
title: "GetPdfContentByRecordAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Pdf\\GetPdfContentByRecordAction"
qmd: "GetPdfContentByRecordAction PDF binario record Eloquent vista show.pdf convenzione modulo allegato email valutatore firma Html2Pdf"
---

# GetPdfContentByRecordAction

Genera il contenuto binario di un PDF da un record Eloquent, risolvendo la vista per convenzione `modulo::modello.show.pdf`.

Codice: `app/Actions/Pdf/GetPdfContentByRecordAction.php:22-203`.

## Input

- `Model $record`.
- `?string $filename`: solo per il log di errore; non influisce sul risultato.

## Output

`string`: contenuto binario del PDF.

## Invarianti

- `PDF-REC-INV-1`: il nome vista è `mb_strtolower(modulo)::kebab(modello).show.pdf`; se manca lancia `\Exception` "View ... not found" (righe 43-51, 90-97). Test: tests/Feature/Actions/Pdf/GetPdfContentByRecordActionTest.php:44 e :133.
- `PDF-REC-INV-2`: HTML vuoto o solo spazi lancia `\Exception` (righe 59-61). Test: tests/Feature/Actions/Pdf/GetPdfContentByRecordActionTest.php:146.
- `PDF-REC-INV-3`: il parametro `firma` è aggiunto solo se la relazione `valutatore` è caricata e ha `nome_diri` (righe 119-129). Test: Nessun test dedicato.
- `PDF-REC-INV-4`: il nome file calcolato non viene restituito né salvato: serve solo al log in caso di errore (righe 63-69, 194-197). Test: tests/Feature/Actions/Pdf/GetPdfContentByRecordActionTest.php:61, :83, :152 (verificare se testano l'output o solo i metodi protetti).
- `PDF-REC-INV-5`: un errore di generazione è loggato e rilanciato come `\Exception` con la causa concatenata (righe 193-200). Test: tests/Feature/Actions/Pdf/GetPdfContentByRecordActionTest.php:180.

## Effetti collaterali

Lettura della relazione `valutatore` solo se già caricata; rendering vista; `Log::error` in caso di errore. Nessuna scrittura su disco.

## Errori

Tre `\Exception`: vista mancante, HTML vuoto, errore di generazione (con `previous`).

## Non fa

- Se la classe del modello non è sotto `Modules\...\Models`, il nome modulo è vuoto e la vista risultante non esiste.
- Non restituisce né salva il nome file.
- `$engine` (default SPIPU) è dichiarato ma non usato.
