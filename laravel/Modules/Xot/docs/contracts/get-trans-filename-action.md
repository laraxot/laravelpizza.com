---
title: "GetTransFilenameAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Trans\\GetTransFilenameAction"
qmd: "GetTransFilenameAction percorso file traduzione lang locale modulo namespace GetModulePathByGeneratorAction fallback base_path"
---

# GetTransFilenameAction

Calcola il percorso assoluto del file di traduzione PHP per il locale corrente, dato un nome nel formato `modulo::file.chiave`.

Codice: `app/Actions/Trans/GetTransFilenameAction.php:11-30`.

## Input

- `string $filename`: formato `modulo::file.chiave`.

## Output

`string`: percorso con separatori di sistema, `{lang}/{file}.php` sotto la cartella lang del modulo.

## Invarianti

- `TRANS-FILE-INV-1`: `ns` è la parte prima di `::`; `file` è il testo tra `::` e il primo `.` (righe 16-17). Test: Nessun test dedicato.
- `TRANS-FILE-INV-2`: la cartella lang è quella del generatore di moduli; se la risoluzione lancia un errore usa `base_path('Modules/{ns}/lang')` (righe 19-25). Test: Nessun test dedicato.
- `TRANS-FILE-INV-3`: i separatori sono normalizzati; l'esistenza del file non è verificata (riga 28). Test: Nessun test dedicato.

## Effetti collaterali

Nessuno: sola lettura del locale e della configurazione dei moduli.

## Errori

Gli errori del generatore sono assorbiti (`catch Throwable`, riga 22) senza log: il fallback avviene in silenzio.

## Non fa

- Se `$filename` non contiene `::`, `ns` diventa l'intero input.
- Il locale è quello corrente dell'app.
