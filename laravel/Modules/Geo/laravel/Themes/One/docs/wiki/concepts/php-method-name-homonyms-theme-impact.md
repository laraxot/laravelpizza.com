---
title: "omonimi metodi php — impatto temi"
module: One
type: concept
tags: [php, methods, theme, blade, homonym]
created: 2026-06-15
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/analysis/method-name-homonym-census.md
  - ../../../../Modules/Sigma/docs/wiki/concepts/method-name-homonyms.md
  - ./code-redundancy-theme.md
---

# Omonimi metodi PHP — impatto temi

## Perimetro

I temi **One**, **Zero**, **Three** non definiscono model Eloquent dominio HR/PA. L’omonimia metodi riguarda i temi solo come **consumatori** in Blade/Livewire.

## Dove compare

```blade
@foreach ($row->qua00fDaterange as $qua00f)
```

Viste in `IndennitaCondizioniLavoro` (path theme-agnostiche) chiamano relazioni con spelling **esatto** del modello. Se si rinomina una relazione (es. `Qua00f` → `qua00fRetribuzioneDateRange`), le view vanno aggiornate in parallelo.

## Regole per agenti tema

| OK | Vietato |
|----|---------|
| Usare relazioni esposte dal modello modulo | Definire `function qua00f()` in PHP tema |
| Documentare dipendenza da nome relazione | Introduce PascalCase in metodi tema |
| Cercare in censimento prima di rinominare | Rinominare solo case senza verificare PHP |

## Case-insensitive in Blade

`$row->qua00fDaterange` e `$row->qua00fDateRange` invocano lo **stesso** metodo PHP. In refactor non basta cambiare maiuscole in Blade: serve un nome semanticamente nuovo.

## Riflessione

Il tema è pelle; la semantica dei metodi vive nei moduli. Il censimento canon resta in [method-name-homonym-census](../../../../../../docs/wiki/analysis/method-name-homonym-census.md). Temi Zero/Three: stesso contratto (backlink qui).

## Collegamenti

- [censimento root](../../../../../../docs/wiki/analysis/method-name-homonym-census.md)
- [ridondanza tema](./code-redundancy-theme.md)
