---
title: "Product brief: SuperAdmin user-menu widget"
type: product-brief
module: User
status: approved
version: "1.0"
related:
  - ./prd.md
  - ./project-context.md
  - ./livewire-widget-product-brief.md
  - ./livewire-inventory.md
updated: 2026-10-07
tags: [docs, user, bmad]
qmd: "product brief: superadmin nel menu filament user"
---

# Product brief: SuperAdmin nel menu Filament

## 1. Executive summary

L’operatore che *è già* super-admin (o in stato “negato”) deve poter invertire quel privilegio dal menu utente del panel, con un click. Oggi il controllo è un Livewire `Http/Livewire/Profile/SuperAdmin` agganciato a un render hook. Va portato a **Filament widget** (`XotBaseWidget`) perché il chrome del panel appartiene a Filament, non al namespace Livewire “generico”.

**Punti:**
- Problema: UI admin in un contenitore sbagliato (Livewire HTTP), fragile rispetto al panel.
- Soluzione: stesso comportamento, widget Filament montato nello stesso hook.
- Utenti: operatori del panel `admin` con quei due ruoli.
- Metrica: `/admin` mostra l’icona corona; un click inverte il ruolo e ricarica la pagina.

## 2. Problem statement

### Il problema

Il panel è Filament 5. Il toggle SuperAdmin è un `Livewire\Component` sotto `Http/Livewire`, scoperto come alias `profile.super-admin`. Non è un widget, non segue `XotBase*`, non ha lang strutturata (tooltip in inglese hardcoded). Ha già causato un 500 quando la vista puntava a `filament-jet::`.

### Chi lo vive

Operatore autenticato su `/admin`. Chi sviluppa il modulo User (ogni regressione del menu è un 500 su tutto il panel).

### Situazione attuale

`AdminPanelProvider` fa `Blade::render("@livewire('profile.super-admin')")` su `panels::user-menu.before`. Il componente legge il profilo e chiama `toggleSuperAdmin()`.

### Impatto se non si converte

Ogni nuova versione Filament/Livewire sul user-menu rompe `/admin`. Due stili (widget auth vs Livewire HTTP) nello stesso modulo.

### Perché ora

Il 500 `filament-jet` ha dimostrato che questo pezzo vive ancora nel mondo Jet/FilamentJet. La conversione va **documentata** prima di toccare il provider.

## 3. Target users

| Ruolo | Bisogno |
|-------|---------|
| Super-admin | Vedere l’icona corona; un click passa a `negate-super-admin` |
| Negate-super-admin | Vedere l’icona ruotata; un click torna `super-admin` |
| Altri utenti panel | Nessun controllo, menu invariato |

## 4. Value

Un solo punto UI allineato a Filament. Comportamento identico. Meno superficie `Http/Livewire`.

## 5. Success

- Icona e toggle invariati per chi ha i ruoli.
- Nessun widget extra sulla dashboard.
- Livewire `SuperAdmin` rimosso dopo lo switch dell’hook.
- PHPStan max verde sui file dello slice.
