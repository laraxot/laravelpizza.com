---
title: "UX — Job"
type: ux-design
module: Job
related:
  - ./livewire-inventory.md
---

# UX

Unico impatto visivo possibile: `job.status` è il body della pagina `JobMonitor` (`job::admin`). Il ritiro Cluster B sostituisce quel contenuto con la pagina nativa `JobStatus` (stessa tabella acts `queue:*`, stesso chrome Filament) → nessuna regressione percepita. `Schedule\*` e `Broad` non sono montati in nessuna UI raggiungibile: rimozione invisibile. Queue UI resta `QueueListenWidget`/`ClockWidget`.
