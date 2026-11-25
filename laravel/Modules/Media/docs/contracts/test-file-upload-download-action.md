---
title: "TestFileUploadDownloadAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Diagnostic\\S3\\TestFileUploadDownloadAction"
qmd: "TestFileUploadDownloadAction diagnostica upload download confronto contenuto S3 file temporaneo locale"
---

# TestFileUploadDownloadAction

Prova upload, download, confronto del contenuto, esistenza e dimensione di un file su S3. Codice: `app/Actions/Diagnostic/S3/TestFileUploadDownloadAction.php:21-83`.

## Input

- Nessuno. Il file è `test-file-<time()>.txt` con un contenuto fisso.

## Output

- Successo: `status=success`, `details` con `file_uploaded`, `file_downloaded`, `content_verified`, `file_exists_check`, `file_size`, `cleanup_completed`, `test_file`.
- Errore: `status=error` con `message` e `details` (per le eccezioni: classe, file e riga).

## Invarianti

- **TEST-FILE-UPLOAD-DOWNLOAD-INV-1** — Il successo richiede che il contenuto scaricato sia identico a quello caricato.
  Test: nessuno.
- **TEST-FILE-UPLOAD-DOWNLOAD-INV-2** — Se `put` restituisce falso l'Action risponde con errore senza leggere.
  Test: nessuno.

## Effetti collaterali

- Scrive un file temporaneo locale in `sys_get_temp_dir()`.
- Su S3: `put`, `get`, `exists`, `size`, `delete` del file di prova.

## Errori

- Eccezioni catturate e restituite come `status=error`.

## Non fa

- `cleanup_completed` è sempre `true`: il risultato di `delete` su S3 non viene verificato.
- Il file locale non viene rimosso quando `put` fallisce o quando cade un'eccezione prima di `unlink`.
