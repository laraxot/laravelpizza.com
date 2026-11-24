---
title: "Architecture — Job"
type: architecture
module: Job
related:
  - ./livewire-widget-prd.md
  - ./livewire-inventory.md
---

# Architecture Job

```
QueueListenWidget / ClockWidget → restano (XotBaseWidget, discoverWidgets)
JobStatus (Filament Page)      → gemello nativo di Job\Status (Cluster B)
Http/Livewire/*                → ritiro: Broad (dd), Schedule\*, Job\Status via 12.x
Futuro monitor Artisan         → Filament Page + policy, non discoverWidgets
```

Zero candidati Cluster A: vedi [livewire-inventory.md](./livewire-inventory.md).
