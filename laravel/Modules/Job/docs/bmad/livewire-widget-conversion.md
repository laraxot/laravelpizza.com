---
title: "Conversione Livewire → widget — Job"
type: pointer
module: Job
related:
  - ./livewire-inventory.md
---

# Job — canone

SSoT: [livewire-inventory.md](./livewire-inventory.md). Verdetto audit 2026-09-21: **zero candidati Cluster A** — nessun componente Job è montato in uno slot widget del chrome Filament. `Job\Status` è Cluster B (gemello parziale: Filament Page `JobStatus`, non widget). `Broad` è di nuovo presente su disco con `dd('fine')` (regressione story 12.1). Non montare Artisan `queue:clear` in un widget scoperto.
