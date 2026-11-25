---
title: "BaseS3Action — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\S3\\BaseS3Action"
qmd: "BaseS3Action classe astratta S3 configurazione media.aws fallback filesystems bucket region credenziali"
---

# BaseS3Action

Classe astratta base delle Action S3: costruisce il client S3 e risolve bucket, region e credenziali. Codice: `app/Actions/S3/BaseS3Action.php:11-67`.

## Input

- Costruttore: `LoggerInterface $logger`.

## Output

- Nessun `execute()`: è astratta. Le sottoclassi sono `CheckFileExistsAction`, `DeleteFileAction`, `GetFileInfoAction`, `UploadFileAction`.

## Invarianti

- **BASE-S3-INV-1** — Ogni valore è letto prima da `media.aws.*`, poi da `filesystems.disks.s3.*`, infine dal default: il primo valore stringa non vuoto vince.
  Test: `tests/Unit/Actions/MediaActionsCoverageTest.php:181-195` (verifica l'ereditarietà, non i valori).
- **BASE-S3-INV-2** — Il default della region è `us-east-1`; il bucket e le credenziali hanno default `''`.
  Test: nessuno.

## Effetti collaterali

- Nessuno a costruzione: crea solo il client `S3Client` in memoria (versione `2006-03-01`).

## Errori

- Nessuno dichiarato.

## Non fa

- Il nome `AWS_*` nel metodo `getStringConfig()` serve solo a scegliere la chiave di fallback: il codice non legge mai le variabili d'ambiente direttamente.
- Usa una configurazione diversa da `Diagnostic/Aws/*` (`filesystems.disks.s3` senza il ramo `media.aws`). Le due risoluzioni possono divergere.
