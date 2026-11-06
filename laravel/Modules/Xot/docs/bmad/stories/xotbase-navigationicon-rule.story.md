---
title: "Xot - xotbase-navigationicon-rule.story.md"
module: Xot
bmad: true
status: draft
updated: 2026-10-23
tags: [docs, xot, bmad]
qmd: "bmad story   xotbaseresource: rimuovere $navigationicon (traduzioni gestiscono) xot"
---

# BMAD Story: XotBaseResource: rimuovere $navigationIcon (traduzioni gestiscono)

## Epic
XOT-ARCH-001

## AC
- [ ] Chi estende `XotBaseResource` NON dichiara `protected static string|\BackedEnum|null $navigationIcon`
- [ ] Icone gestite via traduzioni (`Lang` module) / `PanelModuleAdapter`
- [ ] Moduli controllati: `IndennitaCondizioniLavoro`, `Incentivi`, `Ptv`, `Performance`, `Progressioni`
- [ ] Nessuna modifica a `docs/` oltre questa story

## Task
1. Rimuovere dichiarazione da `AssenzaResource`, `CondizioniLavoroResource`, `UploadResource`
2. Idem `PhaseResource`, `DefaultActivityResource`
3. Idem `BaseCategoriaProproResource`, `BaseMessageResource`, `BaseCriteriOptionResource`
4. Registrare regola in memoria / second-brain

## Status
Todo