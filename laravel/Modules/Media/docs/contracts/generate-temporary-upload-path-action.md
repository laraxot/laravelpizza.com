---
title: "GenerateTemporaryUploadPathAction — contratto"
type: contract
owner: Media
status: accepted
action: "Modules\\Media\\Actions\\GenerateTemporaryUploadPathAction"
tags: [contract, action, upload, percorsi, storage]
created: 2026-11-24
updated: 2026-11-24
qmd: "contract GenerateTemporaryUploadPathAction media upload temporaneo percorso tmp MEDIA-PATH-INV"
---

# GenerateTemporaryUploadPathAction

Genera il percorso di storage sotto `tmp/` per originale, conversioni e immagini responsive di un `Media`. Decisione di fondo: [ADR 0001](../adr/0001-upload-temporanei-con-percorso-scopato-e-policy.md).
Implementa il contratto del [PathGenerator](path-generator.md) tramite `getPath()`, `getPathForConversions()`, `getPathForResponsiveImages()`.

## Input

- `Media $media`: servono solo `id` (chiave) e `uuid`.
- `string $purpose`: `original` (default), `conversion`, `responsive`; qualsiasi altro valore e' trattato come `original`.

## Output

- `string`: `tmp/<md5(uuid+id)>/<md5(id+uuid+suffisso)>`; per `original` il percorso termina con `/`, per gli altri no.

## Invarianti

- **MEDIA-PATH-INV-1** — Il percorso dipende solo da `uuid` e `id` del media, mai dal nome file fornito dal client.
  Verifica non marcata: `Modules/Media/tests/Unit/Support/TemporaryUploadPathGeneratorTest.php` («separates two media that share the uuid but not the key»); nessun `->group('MEDIA-PATH-INV-1')`.
- **MEDIA-PATH-INV-2** — Originale, conversione e responsive dello stesso media hanno tre percorsi distinti e condividono la stessa cartella base.
  Stessa verifica non marcata («keeps the three paths distinct…», «shares the base path…»).
- **MEDIA-PATH-INV-3** — Il percorso originale termina con `/`.
  Stessa verifica non marcata («closes the original path with a slash»).
- **MEDIA-PATH-INV-4** — Una chiave primaria intera e' accettata (`Assert::scalar`).
  Stessa verifica non marcata («accepts the integer primary key the model actually declares»).

## Effetti collaterali

- Nessuno: non scrive su disco ne' su database.

## Errori

- `InvalidArgumentException` di Webmozart Assert se la chiave del media non e' scalare.

## Non fa

- Non e' un controllo di accesso e non offusca in modo sicuro: usa `md5`, voce elencata come debito `security` in `tests/Arch/debt.php`. L'accesso e' governato da `MediaPolicy` / `TemporaryUploadPolicy`.
- Non crea cartelle ne' pulisce i temporanei (la pulizia resta esplicita, come da ADR).
- Divergenza nota: `Actions/TemporaryUpload/GetTemporaryUploadPathAction.php` calcola lo stesso percorso con `Assert::string($media->getKey())`, che fallirebbe con chiave intera; la versione corretta e' questa.
