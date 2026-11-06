---
title: "Brainstorming: solo widget vs Livewire HTTP"
type: brainstorming
module: User
status: done
related:
  - ./brainstorming.md
  - ./livewire-inventory.md
  - ./decision-log.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "brainstorming: perché un solo contenitore user"
---

# Brainstorming: perché un solo contenitore

## Idea

Livewire è il motore. Filament widget è il **posto** in cui il panel si aspetta quel motore. `Http\Livewire` è il posto in cui viveva Jetstream/FilamentJet.

## Alternative scartate

| Idea | Perché no |
|------|-----------|
| Tenere entrambi “finché Volt non è chiaro” | Login HTTP non ha route. I widget sono già registrati. Tenere entrambi è il bug. |
| MenuItem Filament per SuperAdmin e team | Naviga, non toggle/switch con stato. |
| Badge Blade statico | Già commentato nel provider; niente click. |
| Convertire tutto in un epic | `AdminPanelProvider` contended; SuperAdmin è pathfinder (Epic 9). |
| Action nuova per ogni click | Trait/Action esistenti sono SSoT. |
| Pubblicare viste Filament | Breaking change ad ogni bump; gli hook esistono apposta. |
| Reinstallare filament-jet | Ownership duplicata; il 500 nasceva da quel namespace. |

## Scelta

Widget-only nel modulo identità. HTTP muore. Gdpr tiene i testi legali. Notify tiene le campanelle vendor.

## SuperAdmin vs campagna

Brainstorm dello slice re: [brainstorming.md](./brainstorming.md). Questa pagina è il **perché della campagna**, non il markup dell’icona.
