---
title: "Decision log — Media"
type: decision-log
module: Media
related:
  - ./livewire-inventory.md
---

# Decision log

## [2026-09-21] Clip is FO card

Docs only.

## [2026-09-21] Correzione diagnosi: Clip era orfano, non "FO in uso"

La verifica repo-wide ([livewire-inventory.md](./livewire-inventory.md)) non trovava alcun montaggio di `card.video.clip` — né hook Filament, né tag/direttiva blade, né rotta; mancava anche la vista che `render()` avrebbe risolto.

## [2026-09-21] Clip rimosso come dead code

`Modules/Media/app/Http/Livewire/Card/Video/Clip.php` cancellato (file mai tracciato in git; task `12.1-retire-media-clip-livewire`). `_components.json` ora `[]`. Il modulo non ha più classi Livewire HTTP. Nessun widget creato — il verdetto "non convertire" resta il riferimento.
