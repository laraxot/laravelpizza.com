---
title: "ImportCsvAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\Import\\ImportCsvAction"
qmd: "ImportCsvAction import CSV LOAD DATA LOCAL INFILE SET GLOBAL local_infile tabella colonne decimal notifica"
---

# ImportCsvAction

Importa un file CSV in una tabella con `LOAD DATA LOCAL INFILE`. Codice: `app/Actions/Import/ImportCsvAction.php` (classe a riga 23, `execute()` a riga 33). Usata da `Sigma/app/Filament/Pages/ImportCsv.php` e `SqlUpload.php`.

## Input

- `string $disk`: disco di storage.
- `string $filename`: file nel disco.
- `string $db`: nome del database, usato nel SQL.
- `string $tbl`: nome della tabella, usato nel SQL.

## Output

- `void`.

## Invarianti

- `IMPORT-CSV-INV-1` — Il file deve esistere nel disco. Test: nessuno.
- `IMPORT-CSV-INV-2` — Le colonne sono quelle della tabella, escluso `id`; le colonne `decimal` sono lette in variabile e convertite con `REPLACE(',', '.')`. Test: nessuno.
- `IMPORT-CSV-INV-3` — Prima del caricamento esegue `SET GLOBAL local_infile=1`. Test: nessuno.
- `IMPORT-CSV-INV-4` — Al termine mostra una notifica di successo con il numero di righe restituito da `exec()`. Test: nessuno.

## Effetti collaterali

- Modifica `ini_set` del processo (`max_execution_time` 0, `memory_limit` -1).
- Cambia una variabile globale del server MySQL.
- Inserisce righe in tabella senza transazione.
- Invia una notifica.

## Errori

- `Assert` per file mancante; eccezioni PDO propagate. Il valore di ritorno di `exec()` non è verificato dal codice in caso di errore.

## Non fa

- Non valida il contenuto del CSV.
- Non usa transazioni.
- Rischio alto, da correggere: `$db`, `$tbl` e `$path` sono interpolati nel SQL senza escape né whitelist. Il caller `Sigma/.../SqlUpload.php` li riceve da campi di testo di un form Filament (`TextInput::make('db')`, `TextInput::make('tbl')`). Un utente che può usare quella pagina può iniettare SQL.
- Richiede il privilegio di modificare la configurazione globale del server.
