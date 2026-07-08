---
title: "ridondanza e confini — tema Zero"
module: Zero
type: concept
tags: [redundancy, theme, blade, auth]
created: "2026-05-26"
updated: "2026-05-26"
related:
  - ../../../../Modules/Xot/docs/wiki/concepts/code-redundancy-philosophy.md
  - ../../../One/docs/wiki/concepts/code-redundancy-theme.md
  - ../../../../Modules/User/docs/wiki/concepts/code-redundancy-user.md
---

# Ridondanza — Theme Zero

## Scopo

Stesso ruolo di **One**: presentazione e wiring Livewire verso **User**. Zero non è owner di notifiche, performance o PTV.

## Zen

Due temi non sono «duplicati sbagliati» se servono **brand/UX** diversi. Diventano debito solo quando il diff è zero e nessuno documenta perché esistono due cartelle.

## P1 — login blade

Allineamento con One: stesso `@livewire` su `Auth\LoginWidget`. Estrarre partial comune se il markup converge.

## Attenzione commenti

Verificare che i commenti Blade non dicano «tema Zero» dentro file One (confusione agent).

## Collegamenti

- [One](code-redundancy-theme.md)
- [Filosofia](../../../../Modules/Xot/docs/wiki/concepts/code-redundancy-philosophy.md)
