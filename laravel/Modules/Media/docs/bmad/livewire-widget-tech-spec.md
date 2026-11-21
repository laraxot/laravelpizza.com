---
title: "Tech spec — Media"
type: tech-spec
module: Media
related:
  - ./livewire-inventory.md
  - ./livewire-widget-prd.md
---

# Tech spec Media

Nessun PHP in questa campagna. Verifica eseguita prima della rimozione (citazioni in [livewire-inventory.md](./livewire-inventory.md)):

```bash
grep -rn "card\.video\.clip\|Card\\\\Video\\\\Clip" --include="*.php" --include="*.blade.php" .   # 0 hit attivi
cat Modules/Media/app/Providers/Filament/AdminPanelProvider.php                                 # 20 righe, 0 renderHook
find Modules/Media/resources/views -path "*card/video/clip*"                                    # vista assente
```

Esito: `Clip.php` rimosso il 21/09/2026 (file untracked), `_components.json` → `[]`, directory `Card/Video/` eliminata. Modulo senza classi Livewire HTTP.
