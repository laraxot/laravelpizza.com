---
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "livewire widget tech spec"
issues: []
discussions: []
title: "Tech spec — Notify FQCN"
type: tech-spec
module: Notify
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
---

# Tech spec Notify

Gate verificato: `find Modules/Notify/app/Http/Livewire -name '*.php'` = 0 file reali (solo `_components.json` `[]` + 2 `.fila2` inerti).

Blocco hook `AdminPanelProvider.php:32-39`: **già** `Blade::render('@livewire(\'' . DatabaseNotifications::class . '\')')` con `use` a riga 7. Trigger `notify::livewire.database-notifications-trigger` (riga 33) → `resources/views/livewire/database-notifications-trigger.blade.php`. Polling `60s` (riga 35).

Nessun PHP da committare: il target FQCN è già lo stato attuale. Test di regressione: `/admin` autenticato mostra la campanella solo se `disable_database_notifications = false` (default `true` → hook assente, nessun errore).
