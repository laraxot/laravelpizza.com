---
title: "Sostenibilità: governance multi-tenant"
type: concept
module: Tenant
status: decision-input
updated: 2026-10-15
tags: [sustainability, tenant, isolation, bmad]
qmd: "governance tenant (ownership tenant) tenant"
---

# Governance tenant (ownership Tenant)

## Perché questo modulo

Il tenant è la **cartella di config per host**. Partner, CTA e copy di
sostenibilità devono poter variare (o spegnersi) per comune senza leak
cross-tenant.

## Scopo business

Un Comune che adotta FixCity deve restare padrone di cosa appare sul proprio
dominio: quali partner, se c’è «sostieni», se i loghi globali Laraxot appaiono.

## Regole proposte

1. **Opt-in esplicito** per blocco partner/CTA nel footer del tenant
2. Contenuto in `config/<tenant>/database/content/`: non in config globale
3. Vietato ereditare automaticamente sponsor da un altro tenant
4. Scadenze/revoche: record non pubblicabile resta fuori dalla proiezione FO
5. Tenant di demo può avere `enabled: false` senza UI vuota rumorosa

## Confini

- Tenant non definisce listino commerciale
- Tenant non sostituisce policy legale globale (ma può restringere)
- Isolation host → path: vedi [README.md](./README.md)

## Collegamenti

- Dossier: [project-sustainability](../../../../../../bmad-output/project-sustainability/README.md)
- Cms: [project-sustainability-content.md](../../Cms/docs/project-sustainability-content.md)
- Ownership map: [ownership-map](../../../../../../bmad-output/project-sustainability/ownership-map.md)
