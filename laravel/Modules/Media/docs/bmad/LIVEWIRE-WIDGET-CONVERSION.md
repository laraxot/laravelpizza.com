---
title: "Puntatore — Media Livewire → Filament widget"
canonical: ./livewire-inventory.md
superseded: true
related:
  - ./livewire-inventory.md
---

# Media module — Livewire → Filament widget (superato)

**Canone:** [livewire-inventory.md](./livewire-inventory.md).

Questo documento (2026-08-25) proponeva di convertire `Clip` (`Modules/Media/app/Http/Livewire/Card/Video/Clip.php`) in un `MediaVideoWidget` sotto `Media/Filament/Widgets/Videos/`, sulla base dell'unica considerazione "il componente gestisce la riproduzione di video nel modulo Media", senza verificare se e dove Clip fosse effettivamente montato.

Verifica successiva (21/09/2026, vedi [livewire-inventory.md](./livewire-inventory.md)): zero hook nel panel provider Filament del modulo (`Modules/Media/app/Providers/Filament/AdminPanelProvider.php`, 20 righe, nessun `renderHook`), zero `@livewire('card.video.clip')` o `<livewire:...>` in tutto il repository, zero rotta dedicata, zero vista di supporto per il `render()` del componente (che cercherebbe una vista `.../card.video.clip.edit` inesistente). `Clip` è codice orfano, non un componente da convertire in widget: costruire un widget nuovo per codice senza consumatori avrebbe aggiunto superficie invece di ridurla.

Non è stato scritto nessun `MediaVideoWidget`. Non seguire più i checkbox di questo file (`project-context.md`, `tech-spec-media-widgets.md`, `epics.md`, `10.1.media-video-widget.story.md`): sono stati sostituiti dalla story [`12.1.media-clip-not-widget.story.md`](../stories/12.1.media-clip-not-widget.story.md), che chiude la questione con verdetto negativo.
