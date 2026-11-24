---
title: "ExportXlsStreamByLazyCollection — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\ExportXlsStreamByLazyCollection"
qmd: "ExportXlsStreamByLazyCollection export CSV streaming LazyCollection intestazioni transKey tabulazioni StreamedResponse"
---

# ExportXlsStreamByLazyCollection

Esporta una `LazyCollection` come CSV in streaming, con intestazione tradotta opzionale e tre righe finali di tabulazioni.

Codice: `app/Actions/Export/ExportXlsStreamByLazyCollection.php:18-133`.

## Input

- `LazyCollection $data`.
- `string $filename` (default `test.csv`): usato nel `Content-Disposition`.
- `?string $transKey`: prefisso per le intestazioni.
- `?array $_fields`: ignorato.

## Output

`StreamedResponse` 200 con `Content-Disposition: attachment; filename=<filename>` (senza virgolette).

## Invarianti

- `XLS-STREAM-INV-1`: la prima riga è l'intestazione calcolata da `headings()` prima dello stream (righe 39, 46-48). Test: tests/Unit/XotExecuteCoverage50Test.php:853 (sola copertura).
- `XLS-STREAM-INV-2`: un elemento che non è array né oggetto con `toArray()` viene saltato senza errore (righe 55-61). Test: Nessun test dedicato.
- `XLS-STREAM-INV-3`: con `transKey`, ogni intestazione è `trans("{transKey}.fields.{campo}")`; se manca, prova il campo con punti→underscore; altrimenti il nome originale (righe 109-125). Test: Nessun test dedicato.
- `XLS-STREAM-INV-4`: valori `null` diventano stringa vuota; altri valori sono convertiti in stringa (righe 63-69). Test: Nessun test dedicato.
- `XLS-STREAM-INV-5`: tre righe di sole tabulazioni sono scritte in coda (righe 75-79). Test: Nessun test dedicato.

## Effetti collaterali

Scrittura su `php://output` durante lo stream. `headings()` chiama `first()` sulla sorgente prima dello stream: per sorgenti non ripetibili il primo elemento può essere letto due volte (da verificare). Nessuna transazione.

## Errori

Se il primo elemento non è array/`toArray()`, l'intestazione è vuota (riga 97-98). `Assert::string` (riga 117) e le funzioni `Safe\fputcsv` possono lanciare eccezioni dentro lo stream.

## Non fa

- Non ignora `$_fields`: il parametro non è usato.
- Non scrive BOM UTF-8 (possibile problema di apertura in Excel, da verificare).
- Il `Content-Disposition` non quota il nome file.
