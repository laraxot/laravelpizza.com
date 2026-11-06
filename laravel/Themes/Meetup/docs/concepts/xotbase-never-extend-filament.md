---
title: "Meetup — mai Filament\*, sempre XotBase*"
type: concept
theme: Meetup
tags: [meetup, filament, xotbase, architecture]
created: 2026-07-16
updated: 2026-07-16
qmd: "Meetup theme filament never extend Filament class XotBase mirror path"
related:
  - ../../../../docs/wiki/rules/xotbase-critical-rules.md
  - ../../../../docs/wiki/rules/xot-base-filament-widgets.md
  - ../../../../docs/wiki/memories/xotbase-never-extend-filament.md
---

# Mai `Filament\*` — sempre `Modules\Xot\Filament\...\XotBase*`

Bridge on-demand. Contenuto canonico: [docs/wiki/rules/xotbase-critical-rules.md](../../../../docs/wiki/rules/xotbase-critical-rules.md).

## Zen (riassunto)

Nessuna classe nel tema `Themes/Meetup` estende una classe `Filament\...` direttamente.
Si estende sempre lo "specchio" in `Modules\Xot\Filament\...` allo stesso
percorso relativo (es. `Filament\Tables\Columns\ViewColumn` ->
`Modules\Xot\Filament\Tables\Columns\XotBaseViewColumn`). Se manca il
mirror, va creato in Xot prima di usarlo qui, mai come scorciatoia nel tema.

Non pre-caricare questo file: leggi la fonte canonica solo quando il task lo richiede.
