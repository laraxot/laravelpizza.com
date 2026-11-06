---
title: "Product Strategy: User Module"
type: concept
tags: [strategy]
created: 2026-07-14
updated: 2026-07-14
qmd: "strategy product strategy: user module"
issues: ["https://github.com/provtv/base_ptv_fila5/issues/124"]
discussions: ["https://github.com/provtv/base_ptv_fila5/discussions/1"]
related:
  - "./00-index.md"
  - "./00-index-indice-documentazione-modulo-user.md"
  - "./00-index.md"
  - "./2fa-guide.md"
  - "./2fa.md"
  - "./accessor-delegation-pattern.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention.md"
  - "./actions-path-convention-convenzione-percorsi.md"
  - "./actions-path-convention.md"
status: draft
---

# Product Strategy: User Module

## 🌍 Market Context
Identity is the core of every system. PTVX needs a "plug-and-play" auth module that can handle complex PA roles.

## 💎 Unique Value Proposition
Native integration with XotBase classes ensuring that permissions are automatically respected in Filament resources.

## 🏛️ Strategic Pillars
1. **Security First:** Standard Laravel security patterns (Fortify, Spatie).
2. **Scalability:** Optimized DB queries for permission checking.
3. **Modular Ready:** Each module can define its own permissions without core modifications.

## 🗺️ Strategic Roadmap (1-2 Years)
Transition to an OAuth2/OIDC provider role to allow external applications to authenticate via the User module.
