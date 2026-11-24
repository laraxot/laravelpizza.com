---
title: "PRD — Job Livewire"
type: prd
module: Job
related:
  - ./livewire-inventory.md
---

# PRD Job

### FR-J001 [MUST] `Broad.php` assente (contiene `dd`). **Verificato 2026-09-22:** file assente, alias `broad` assente da `_components.json`, `dd(` zero in `Http/Livewire`.
### FR-J002 [MUST] `Schedule\Status`/`Schedule\Crud` assenti: grep chiamanti vivi = zero (solo viste `admin/**` irraggiungibili). `Job\Status` ha un chiamante vivo (`job-monitor.blade.php:7`): ritiro subordinato al gemello `JobStatus` (Cluster B, FR-J005).
### FR-J003 [SHOULD] Se il prodotto vuole di nuovo queue monitor: pagina Filament, non widget KPI, auth super-admin.
### FR-J004 [MUST] Non copiare `putenv` / `queue:clear` in un widget scoperto in dashboard.
### FR-J005 [SHOULD] Cluster B: ritirare `Job\Status`+`JobMonitor` a favore della pagina nativa `JobStatus`, dopo decisione su `saveEnv`/`dummyAction`.
