---
title: "Product brief — Job HTTP fuori"
type: product-brief
module: Job
related:
  - ./livewire-inventory.md
---

# Brief

Togliere `Broad` (di nuovo presente con `dd`) e gli HTTP orfani `Schedule\Status`/`Schedule\Crud`. `Job\Status` va ritirato verso la pagina Filament `JobStatus` già esistente (Cluster B), non convertito in widget. Queue live resta `QueueListenWidget`. Metrica: `Http/Livewire` vuoto; zero `dd(` nei componenti UI; zero tag `<livewire:*>` residui in viste `admin/**` morte.
