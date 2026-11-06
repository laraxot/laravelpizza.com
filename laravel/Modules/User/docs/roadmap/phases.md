---
title: "Fasi di sviluppo - User Module"
type: concept
tags: [phases]
created: 2026-07-14
updated: 2026-07-14
qmd: "phases fasi di sviluppo - user module"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-roadmap-user.md"
  - "./00-index.md"
  - "./00-overview.md"
  - "./01-current-state.md"
  - "./01-now.md"
  - "./02-goals.md"
  - "./02-next.md"
  - "./03-later.md"
status: draft
---

# Fasi di sviluppo - User Module

## Fase 1: Stability & Security (In Progress)

- [x] PHPStan Level 10 Compliance
- [x] Standardizzazione del pattern ID (autoincrement) e UUID per i profili
- [ ] Rimozione definitiva dei 550+ file obsoleti
- [ ] Implementazione del **Security Cluster** in Filament v5
- [ ] Supporto completo per **Laravel 12 Authentication Features**

## Fase 2: Modern Identity (Planned)

- [ ] Integrazione **WebAuthn** per login biometrici (TouchID, FaceID)
- [ ] Socialite Cluster: aggiunta facile di nuovi provider OAuth (Google, Apple, etc.)
- [ ] Sistema di "Impersonation" sicuro per il supporto tecnico (SuperAdmin)

## Fase 3: AI Moderation (Future)

- [ ] **AI Identity Verification**: Verifica automatica dei documenti caricati (es. tesserini medici)
- [ ] **Anomaly Detection**: Rilevamento di tentativi di login sospetti basati su pattern comportamentali
- [ ] **Dynamic Permissions**: L'AI suggerisce i permessi minimi necessari in base all'uso effettivo dell'utente
