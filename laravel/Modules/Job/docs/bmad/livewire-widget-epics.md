---
title: "Epics — Job Livewire"
type: epics
module: Job
related:
  - ../stories/12.1.retire-job-http-livewire.story.md
  - ./livewire-inventory.md
---

# Epic 12

Nessuna story di conversione: zero candidati Cluster A (vedi [livewire-inventory.md](./livewire-inventory.md)).

| ID | Intent | Status |
|----|--------|--------|
| 12.1 | Ritiro Broad + gate orfani Status/Crud | **done (ri-verificato 2026-09-22):** `Broad.php` assente, `_components.json` senza `broad`, `dd(` zero in Livewire |
| 12.2 (proposta, docs only) | Ritiro Cluster B: `Job\Status` + `JobMonitor`/`job-monitor.blade.php` → pagina nativa `JobStatus` (decidere gap `saveEnv`/`dummyAction`) | candidate |
| 12.3 | Marker conflitto README + igiene root | **done** — [story](./stories/12.3.root-hygiene-conflict-markers.story.md) |
