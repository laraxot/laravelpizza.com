---
title: "Merge — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Image\\Merge"
qmd: "Merge immagini PNG unione verticale Intervention GD public_path copia singolo file"
---

# Merge

Unisce più immagini in verticale in un unico file PNG. Espone due punti di ingresso: `handle()` con percorsi assoluti e `execute()` con percorsi relativi a `public_path()`. Codice: `app/Actions/Image/Merge.php:21-126`.

## Input

- `handle(string $path1, string $path2, string $outputPath)`: percorsi assoluti.
- `execute(array $filenames, string $outputFilename)`: lista di percorsi relativi a `public_path()`.

## Output

- Entrambi restituiscono `bool`: `true` se il file di output esiste dopo l'operazione.

## Invarianti

- **MERGE-INV-1** — Con due immagini in `handle()`, l'altezza è la somma delle altezze e la larghezza è la massima.
  Test: `tests/Unit/MediaCoverage100RemainingTest.php:88-101` («Image Merge con due png minimi»; verifica anche che esista `execute`).
- **MERGE-INV-2** — In `execute()` con un solo file il sorgente è copiato tale e quale; lista vuota o file mancante danno `false`.
  Test: nessuno esplicito per la copia.
- **MERGE-INV-3** — In `execute()` con più file ogni immagine è centrata orizzontalmente sulla larghezza massima.
  Test: nessuno.

## Effetti collaterali

- Scrive il file di output (crea le cartelle con `ensureDirectoryExists`). Nessuna cancellazione dei sorgenti.
- Con file mancanti `execute()` scrive un log di errore (`logger()->error`).

## Errori

- Un sorgente non decodificabile fa propagare l'eccezione di Intervention Image (`handle()` non controlla l'esistenza dei file).

## Non fa

- Non è collegato a nessun flusso di produzione: nessun chiamante in `app/`, `Modules/` o `config/` (verificato con grep).
- Non è un `*Action` per nome, ma usa il trait `QueueableAction`.
- `execute()` accetta qualsiasi percorso relativo, incluso `..`: chi lo chiama con input esterno deve validarlo prima (dubbio, non verificato).
