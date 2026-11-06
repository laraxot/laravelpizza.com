---
title: "Story: conversione residui Livewire Cluster C a Filament"
type: story
module: User
epic: "10"
story_id: "10.4-residual-livewire"
status: blocked
track: feature/filament-widgets
qmd: "DeleteAccount TermsOfService PrivacyPolicy Logout Livewire conversione Filament widget Cluster C residui"
related:
  - ../livewire-inventory.md
  - ../advantages-filament-only.md
  - ../livewire-widget-admin-panel-provider.md
updated: 2026-10-13
tags: [docs, user, bmad]
---

# 10.4: residui Livewire Cluster C

## Perche'

Epic 9 done (SuperAdmin widget ecc.), ma restano componenti HTTP Livewire
da convertire/eliminare verso il target "solo Filament widget": vantaggi
documentati in `advantages-filament-only.md` (SPOF 500 su /admin, doppia
manutenzione, no `canView()`/lazy).

## Residui in User

- `Livewire/Profile/DeleteAccount` (o equivalente): flusso distruttivo,
  richiede conferma password: candidato a Filament Action con modal, non widget
- `TermsOfService`, `PrivacyPolicy`: pagine blade statiche: valutare
  `XotBasePage` semplice o route blade puro (forse NON Filament: sono pubbliche)
- `Livewire/Logout`: verificare se sostituibile da route POST semplice

## Task

- [ ] Inventario aggiornato: per ogni residuo decidere widget | action | pagina | elimina
- [ ] Story figlia per ogni conversione decisa
- [ ] Aggiornare `livewire-inventory.md` con esito

## AC

- [ ] Zero componenti Livewire "chrome admin" residui in User
- [ ] `AdminPanelProvider` resta unico punto di mount widget

## Nota

Status blocked: attendere esito lock peer `user-9.8-icons` + priorità utente.
