---
id: user-codebase-overview
slug: codebase-overview
title: "Panoramica codebase User"
description: "Autenticazione, utenti, ruoli, team, tenant e OAuth."
document_type: architecture
type: architecture
category: module
status: stable
version: 1.0.0
language: it-IT
related:
  - architecture.md
  - index.md
  - module.md
  - philosophy.md
  - README.md
tags: [codebase, architecture, user, documentation]
qmd: "user codebase architecture actions models tests documentation boundaries"
issues:
  - https://github.com/laraxot/base_quaeris_fila5/issues/123
discussions:
  - https://github.com/laraxot/base_quaeris_fila5/discussions/124
github:
  repo: laraxot/base_quaeris_fila5
  issues:
    - https://github.com/laraxot/base_quaeris_fila5/issues/123
  discussions:
    - https://github.com/laraxot/base_quaeris_fila5/discussions/124
created_at: '2026-07-20'
updated_at: '2026-07-20'
created: 2026-07-20
updated: 2026-07-20
---

# Panoramica codebase User

## Responsabilità

Autenticazione, utenti, ruoli, team, tenant e OAuth.

## Fotografia verificata

- File PHP applicativi: **642**
- Queueable Actions: **48**
- Modelli: **104**
- Test PHP: **148**
- Documenti Markdown rilevati: **1690**

Directory e contesti principali: Actions, Application, Contracts, Datas, Events, Filament, Livewire, Models, Notifications e Providers.

I conteggi sono una fotografia del repository, non obiettivi architetturali. Prima di aggiungere codice va cercata e riusata l'implementazione già presente, soprattutto nelle Actions e nelle classi base Xot.

## Confini

- Il componente resta nel proprio dominio e dipende dalle astrazioni condivise già presenti.
- La logica applicativa riusabile vive in Queueable Actions invocate con app(Classe::class)->execute(...).
- La documentazione storica è materiale di contesto; codice, test e configurazione corrente prevalgono in caso di divergenza.

## Collegamenti

- [architecture](./architecture.md)
- [index](./index.md)
- [module](./module.md)
- [philosophy](./philosophy.md)
- [README](./README.md)
