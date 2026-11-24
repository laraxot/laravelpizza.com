---
title: "XlsByModelClassAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Export\\XlsByModelClassAction"
qmd: "XlsByModelClassAction export Excel modello classe where includes excludes callback relazioni data_get nome file timestamp"
---

# XlsByModelClassAction

Esporta in Excel le righe di un modello, con filtri di uguaglianza, relazioni, colonne da includere/escludere e callback per riga.

Codice: `app/Actions/Export/XlsByModelClassAction.php:18-149`.

## Input

- `string $modelClass`: deve essere classe esistente e sottoclasse di `Model`.
- `array $where`: coppie chiave→valore, legate con `where` (AND, uguaglianza).
- `array $includes`: campi o relazioni (`relazione.campo`).
- `array $excludes`: campi nascosti sui modelli.
- `?callable $callback`: trasforma ogni riga.

## Output

`BinaryFileResponse` da `Excel::download(CollectionExport)`.

## Invarianti

- `XLS-MODEL-INV-1`: la classe deve esistere e estendere `Model`; altrimenti eccezione Webmozart (righe 39-40). Test: Nessun test dedicato.
- `XLS-MODEL-INV-2`: con `includes` non vuoto ogni riga diventa array con chiave = include e valore `data_get` (righe 59-68); le relazioni caricate con `with` sono solo i segmenti prima del punto (righe 118-137). Test: Nessun test dedicato.
- `XLS-MODEL-INV-3`: l'ordine di trasformazione è includes → excludes → callback (righe 59-77). Test: Nessun test dedicato.
- `XLS-MODEL-INV-4`: il nome file è `{slug(classe)} {Y-m-d His}.xlsx` con l'orario corrente: non è deterministico (righe 145-147). Test: Nessun test dedicato.

## Effetti collaterali

Lettura DB (una query, senza limite). `makeHidden` modifica l'istanza del modello in memoria. Download via layer Excel.

## Errori

Eccezioni Webmozart per classe non valida; errori DB ed Excel si propagano.

## Non fa

- Con `includes` e `excludes` insieme, `excludes` non ha effetto: dopo la mappatura le righe sono array e il filtro agisce solo su `Model`.
- Non impone limite di righe.
- Il `where` supporta solo uguaglianza.
- Il `transKey` è preso dalla classe `Model\GetTransKeyByModelClassAction` (fuori perimetro, senza suffisso).
