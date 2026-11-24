---
title: "Decision log — Job"
type: decision-log
module: Job
related:
  - ./livewire-inventory.md
---

# Decision log

## [2026-09-21] Ritiro Broad per `dd`

Docs only.

## [2026-09-21] Audit inventario: zero Cluster A, Broad regredito

Verifica repo-wide ([livewire-inventory.md](./livewire-inventory.md)): `Job\Status` montato solo nel body di `JobMonitor` (gemello pagina `JobStatus` → Cluster B); `Schedule\Status`/`Schedule\Crud` solo in viste `admin/**` irraggiungibili (Cluster C); `Broad` presente su disco nonostante story 12.1 `done`. Nessuna conversione in widget: Artisan-runner + scrittura `.env` non sono materiale da `XotBaseWidget`.
