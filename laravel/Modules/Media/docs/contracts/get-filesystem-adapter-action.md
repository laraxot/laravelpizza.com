---
title: "GetFilesystemAdapterAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\Storage\\GetFilesystemAdapterAction"
qmd: "GetFilesystemAdapterAction FilesystemAdapter disco Storage cast tipo mimeType url temporaryUrl"
---

# GetFilesystemAdapterAction

Restituisce un disco come `FilesystemAdapter`, il tipo che espone `mimeType()`, `url()` e `temporaryUrl()`. Codice: `app/Actions/Storage/GetFilesystemAdapterAction.php:17-31`.

## Input

- `string $disk`: nome del disco.

## Output

- `FilesystemAdapter`: il disco richiesto.

## Invarianti

- **GET-FILESYSTEM-ADAPTER-INV-1** — Un disco che non è `FilesystemAdapter` lancia `RuntimeException`; un adapter valido è restituito così com'è.
  Test: nessuno.

## Effetti collaterali

- Nessuno.

## Errori

- `RuntimeException`: «Il disco [...] non e' un FilesystemAdapter.»
- Un nome di disco non configurato fa lanciare `Storage::disk()` prima del controllo di tipo.

## Non fa

- Non crea dischi né verifica che il disco sia raggiungibile.
