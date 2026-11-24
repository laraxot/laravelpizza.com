---
title: "DownloadZipByPathsDiskAction — contratto"
type: contract
owner: Xot
status: accepted
updated: 2026-11-24
action: "Modules\\Xot\\Actions\\File\\DownloadZipByPathsDiskAction"
qmd: "DownloadZipByPathsDiskAction zip allegati download disco temp file mancanti log warning pdf non cancellato"
---

# DownloadZipByPathsDiskAction

Crea uno ZIP temporaneo con i file indicati presi da un disco e lo restituisce come download. Codice: `app/Actions/File/DownloadZipByPathsDiskAction.php:12-63`.

## Input

- `array<int, string> $attachments`: percorsi dei file sul disco (`execute`, riga 23).
- `string $disk`: nome del disco di storage (riga 23).

## Output

- `?BinaryFileResponse`: risposta di download, o `null` se `ZipArchive::open` fallisce (righe 35, 56-61).

## Invarianti

| ID | Regola | Prova nel codice | Test esistente |
|---|---|---|---|
| `FILE-ZIP-INV-1` | Crea la cartella `temp` sul disco `local` e lo ZIP in `storage_path('app/temp/temp_zip_<uniqid>.zip')`. | righe 25-33 | Test: nessuno |
| `FILE-ZIP-INV-2` | Ogni percorso presente nel disco entra nello ZIP come `<percorso>.pdf`, qualunque sia il tipo del file. | righe 39-42 | Test: nessuno |
| `FILE-ZIP-INV-3` | Un percorso mancante è saltato con `Log::warning`, senza errore. Lo ZIP può risultare vuoto. | righe 44-49 | Test: nessuno |
| `FILE-ZIP-INV-4` | Il download ha nome `attachments_<uniqid>.zip` e `Content-Type: application/zip`. | righe 53-58 | Test: nessuno |
| `FILE-ZIP-INV-5` | Lo ZIP temporaneo non è cancellato dopo l'invio (`deleteFileAfterSend` commentato): i file si accumulano in `storage/app/temp`. | riga 58 | Test: nessuno |

## Effetti collaterali

Scrittura di uno ZIP temporaneo, lettura dal disco, `Log::warning` per i file mancanti, risposta di download. Nessuna transazione.

## Errori

- Nessuna eccezione propria. Gli errori di `Storage` si propagano.
- Ritorno `null` per `ZipArchive::open` fallito, senza log.

## Non fa

- Non cancella lo ZIP temporaneo (`INV-5`).
- Assume che il disco `local` abbia radice `storage/app`, perché il percorso dello ZIP è costruito a mano con `storage_path`.
- Non valida i percorsi.
- Marker `@contract` aggiunto nel docblock della classe.
