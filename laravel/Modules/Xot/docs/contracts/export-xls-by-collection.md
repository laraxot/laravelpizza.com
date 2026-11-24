---
title: "ExportXlsByCollection — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\ExportXlsByCollection"
qmd: "ExportXlsByCollection export Excel collezione CollectionExport Excel download executeWithSpreadsheet PhpSpreadsheet"
---

# ExportXlsByCollection

Esporta una collezione in Excel: `execute` produce un download, `executeWithSpreadsheet` scrive un file su disco.

Codice: `app/Actions/Export/ExportXlsByCollection.php:21-138`.

## Input

- `Collection|EloquentCollection $collection`.
- `string $filename` (default `test.xlsx`), `?string $transKey`, `array $fields`: chiave intera → percorso; chiave stringa → percorso con intestazione esplicita.

## Output

`execute`: `BinaryFileResponse` da `Excel::download`. `executeWithSpreadsheet`: `string` con il percorso `$filename`.

## Invarianti

- `XLS-COLL-INV-1`: `execute` delega a `Excel::download(CollectionExport)` con i tre argomenti ricevuti (righe 43-49). Test: Nessun test dedicato.
- `XLS-COLL-INV-2`: `executeWithSpreadsheet` scrive l'intestazione in riga 1 e le righe dalla riga 2, poi salva con `Xlsx` sovrascrivendo `$filename` e ritorna `$filename` (righe 68-77). Test: Nessun test dedicato.
- `XLS-COLL-INV-3`: in `writeRows` il valore è `data_get($data, percorso, '')`, dove il percorso è la chiave se stringa, altrimenti il valore del campo (righe 105-107, 125). Test: Nessun test dedicato.

## Effetti collaterali

`executeWithSpreadsheet` scrive un file su disco (`$filename`) e non crea la cartella. `execute` non scrive su disco direttamente: lo fa il layer Excel.

## Errori

Eccezioni di PhpSpreadsheet e Maatwebsite si propagano; nessun try/catch.

## Non fa

- Non valida l'estensione né crea directory di destinazione.
- `executeWithSpreadsheet` non traduce le intestazioni: scrive i valori di `$fields` (per chiave intera, il percorso), mentre `execute` passa `transKey` al layer Excel.
- Riga 42 (`$stringFields = $fields`) è un'assegnazione senza effetto.
- Un `EloquentCollection` è convertito con `toArray()` in `executeWithSpreadsheet`: le relazioni non caricate non compaiono.
