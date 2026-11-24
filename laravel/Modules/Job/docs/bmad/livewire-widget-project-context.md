---
title: "Project context — Job Livewire"
type: constitution
module: Job
related:
  - ./livewire-inventory.md
---

# Context Job

Job è code asincrono. L’UI admin è Filament (code, schedule). HTTP che lancia Artisan è un admin tool, non un fragment menu. `dd()` in Broad è un incidente in attesa — ed è di nuovo su disco (regressione 12.1, vedi [livewire-inventory.md](./livewire-inventory.md)). Registro alias Livewire piatto e globale (`XotBaseServiceProvider::registerLivewireComponents`, prefix `''`): un file in `Http/Livewire` è sempre esposto anche senza mount.
