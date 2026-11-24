---
title: "AttachMediaAction — contratto"
type: contract
owner: Media
status: accepted
updated: 2026-11-24
action: "Modules\\Media\\Actions\\AttachMediaAction"
qmd: "AttachMediaAction stub vuoto nessun execute media allegato trait QueueableAction"
---

# AttachMediaAction

Classe vuota che usa solo il trait `QueueableAction`. Codice: `app/Actions/AttachMediaAction.php:12-15`.

## Input

- Nessuno: la classe non dichiara `execute()`.

## Output

- Nessuno.

## Invarianti

- **ATTACH-MEDIA-INV-1** — La classe non espone `execute()`: una chiamata diretta fallisce con `Call to undefined method`, perché il trait definisce `execute()` solo sul proxy restituito da `onQueue()`.
  Test: `tests/Unit/Actions/AttachMediaActionTest.php:24-26` verifica solo che l'istanza sia creata.

## Effetti collaterali

- Nessuno.

## Errori

- `Error` di PHP (metodo inesistente) alla chiamata diretta di `execute()`.

## Non fa

- Non allega nulla a un modello. L'associazione reale tra file e record avviene in `SaveAttachmentsAction` (`addMedia()`).
- Nessun chiamante in `app/`, `Modules/` o `config/` (verificato con grep).
- Il docblock di file rimanda a laravel-ffmpeg, ma la classe non usa FFmpeg.
