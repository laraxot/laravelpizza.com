---
title: "GetAttachmentsSchemaAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\GetAttachmentsSchemaAction"
qmd: "GetAttachmentsSchemaAction schema form FileUpload allegati mime size MediaConfigData Filament"
---

# GetAttachmentsSchemaAction

Costruisce un `FileUpload` Filament per ogni nome di allegato, con i limiti letti da `MediaConfigData`. Codice: `app/Actions/GetAttachmentsSchemaAction.php:18-64`.

## Input

- `array<array-key, string> $attachments`: nomi dei campi (uno per allegato).
- `string $disk = 'attachments'`: disco di destinazione.

## Output

- `list<FileUpload>`: un componente per allegato, nello stesso ordine.

## Invarianti

- **GET-ATTACHMENTS-SCHEMA-INV-1** — Ogni componente accetta i mime type e rispetta la dimensione massima di `MediaConfigData`; è obbligatorio, singolo, senza riordino, con anteprima e download.
  Test: `tests/Unit/Actions/GetAttachmentsSchemaActionTest.php:20` («returns attachment schema») e `:40` («has correct names»): non verificano i limiti del mime type o della dimensione.
- **GET-ATTACHMENTS-SCHEMA-INV-2** — Il percorso di upload è `temp` sul disco indicato, con visibilità `public`.
  Test: nessuno.
- **GET-ATTACHMENTS-SCHEMA-INV-3** — Nella callback `afterStateUpdated` uno stato vuoto non viene toccato; uno stato valorizzato viene normalizzato in lista e riscritto nel campo con `Set`.
  Test: nessuno esplicito.

## Effetti collaterali

- Nessuno sul database. La callback scrive lo stato del form Filament, non il record.

## Errori

- `Assert::string` nella callback: lancia se il nome dell'allegato non è stringa (in pratica non accade con l'input tipizzato).

## Non fa

- Non salva né valida i file oltre le regole di `FileUpload`.
- Pur con `multiple(false)`, la callback memorizza lo stato come array.
