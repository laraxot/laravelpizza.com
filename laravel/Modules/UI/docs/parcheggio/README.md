---
title: "File parcheggiati — UI"
slug: parcheggio
module: UI
document_type: index
category: documentation
type: index
status: active
language: it-IT
created: 2026-11-18
updated: 2026-11-18
tags: [parcheggio, debito-tecnico]
description: "File con estensione finta spostati fuori da app/ in UI, con il motivo per ciascuna famiglia."
qmd: "parcheggiati"
---

# File parcheggiati — UI

File spostati qui da `app/` il 2026-11-18. In `app/` sta solo codice che gira.

Un'estensione finta — `.boh`, `.up`, `.test`, `.disabled`, `.to_migra` — non
tiene un file fuori dal codice: lo rende invisibile a chi cerca e vivo per chi
lo trova. Il percorso dentro `parcheggio/` e' quello d'origine, quindi si sa
sempre da dove veniva.

| File (percorso d'origine sotto `app/`) | Byte |
|---|---|
| `app/Actions/Panel/ApplyCalendarToPanelAction.php.disabled` | 1538 |
| `app/Filament/Widgets/UserCalendarWidget.php.disabled` | 5973 |
| `app/Traits/TableLayoutTrait.php.zero_used` | 1185 |


## Prima di riprenderne uno

Questi file **non sono stati esaminati riga per riga**: sono stati spostati,
non giudicati. Prima di copiarne uno nel codice vivo, confrontalo con quello
che c'e' adesso: in uno di questi, a ottobre, c'erano 135 righe di lavoro non
fuso che per poco non sono state cancellate. Quando il lavoro e' finito,
cancella il file parcheggiato.

## `TableLayoutTrait` legacy: ritirato, esaminato

`Modules\UI\Traits\TableLayoutTrait` (sessione `table_layout`, default GRID, con `refreshTable()` e
`resetTable()`) e' stato spostato qui da `app/Traits/` il 2026-11-24. A differenza dei file sopra, questo
**e' stato esaminato**:

- nessun riferimento per nome completo in PHP, Blade o test di questo progetto (ricerca con `grep -F` e `rg -F`,
  anche nella forma `use Modules\UI\Traits\{...}`);
- il trait vivo e' `Modules\UI\Filament\Actions\Table\TableLayoutTrait` (sessione `table_layout_{id}`, default
  LIST), usato da `HasTableLayoutPage` e `TableLayoutToggleTableAction`; i due test del modulo
  (`UiGapCloser100Test`, `UiHighestMissCoverageTest`) importano quello;
- il file e' identico byte per byte al blob di `dd46996a4` (sha1 `bc73959cc8aa70abd87c682c56ce975b54bfef7f`);
- attenzione ai progetti fratelli: le loro copie piu' vecchie di quei due test (21/11) importano ancora il trait
  legacy. Finche' non si allineano a questo modulo vanno corrette allo stesso modo, altrimenti falliscono con
  `Trait not found`.

Per riprenderlo: copiarlo in `app/Traits/TableLayoutTrait.php` senza `.zero_used`, dopo aver verificato che chi lo
vuole non possa usare il trait vivo. Contesto completo:
[risoluzione-conflitti-tablelayouttrait](../risoluzione-conflitti-tablelayouttrait.md).

Tracciato in
[module_quaeris_fila5#61](https://github.com/laraxot/module_quaeris_fila5/issues/61).
