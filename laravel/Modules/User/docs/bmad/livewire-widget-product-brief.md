---
title: "Product brief: solo Filament widget"
type: product-brief
module: User
status: approved
version: "1.0"
related:
  - ./livewire-widget-prd.md
  - ./livewire-widget-project-context.md
  - ./livewire-inventory.md
  - ./product-brief.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "product brief: un solo stack ui per identità user"
---

# Product brief: un solo stack UI per identità

## 1. Executive summary

Chi entra nel panel o nelle pagine auth User deve usare **solo widget Filament** (`XotBase*`). I 14 `Http\Livewire` sono o chrome nel posto sbagliato, o gemelli morti, o leftover Gdpr. SuperAdmin (Epic 9) è il primo taglio; il resto è Epic 10.

**Punti:**
- Problema: due UI per lo stesso bisogno; `/admin` dipende da alias Livewire.
- Soluzione: hook su FQCN widget; ritiro HTTP; niente nuova business logic.
- Metrica: grep `Http/Livewire` vuoto; provider senza alias; `/admin` 200.

## 2. Problem statement

### Il problema

Filament 5 è il prodotto admin. Livewire HTTP è un secondo prodotto nello stesso processo. Alias stringa + namespace vista ereditati da Jet = 500 globale. Auth ha già i widget; gli HTTP copiano ancora file nel tema a ogni hit.

### Chi lo vive

Ogni operatore su `/admin`. Ogni sviluppatore che bumpa Filament. Ogni utente auth che paga il `ViewCopyAction`.

### Se non si converte

Il prossimo hint path, il prossimo `dddx`, il prossimo form login divergente (HTTP vs widget) è un incidente di identità. Non è refactor estetico.

### Perché ora

`gh` autenticato, inventario chiuso, Epic 9 già `ready-for-dev`. Convertire **dopo** aver documentato: questa sessione non tocca PHP.

## 3. Target users

| Ruolo | Bisogno |
|-------|---------|
| Super-admin / negate | Toggle invariato (Epic 9) |
| Utente multi-team | Switch team nel menu (10.1) |
| Login panel | Bottoni social dal widget già esistente (10.2) |
| Maintainer | Una famiglia UI, un PHPStan |

## 4. Value

Meno superficie, meno 500, meno copie disco, confine Gdpr rispettato.

## 5. Success

Vedi checklist in [livewire-inventory.md](./livewire-inventory.md#successo-campagna-docs--poi-codice).
