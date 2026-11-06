---
id: IM-TENANT-001
title: "Isolamento tenant dei contenuti editoriali"
type: story
module: Tenant
epic: "I Governance editoriale"
status: backlog
priority: P1
owner: module:Tenant
scope: "laravel/Modules/Tenant/docs/"
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, tenant, privacy, blog, event]
qmd: "tenant isolation Article blog event contenuti pubblici"
related: [IM-BLOG-002, IM-GDPR-001]
issues: []
discussions: []
---
# Isolamento tenant dei contenuti editoriali

## Richiesta / scopo
Come ente tenant voglio che articoli, eventi, media e iscrizioni siano visibili solo nel perimetro previsto dal contratto di pubblicazione.

## Acceptance Criteria
- [ ] Query, cache, feed e JSON-LD non espongono contenuti di un altro tenant.
- [ ] Il contenuto globale è distinto da quello tenant senza fallback silenziosi.
- [ ] Gli accessi editoriali rispettano policy e audit esistenti.
- [ ] Il test di isolamento copre blog, evento, media e follow-up.

## Tasks / Subtasks
- [ ] Verificare scope esistenti prima di modificare codice.
- [ ] Documentare modello globale/tenant.
- [ ] Aggiungere solo test mancanti quando readiness lo consente.

## Owned File / Module Scope
Contratti/docs Tenant; integrazioni nei moduli owner in story separate.

## Testing / Verifica
Pest di isolamento e review dei punti di lettura/cache.

## Dipendenze
IM-BLOG-002, IM-GDPR-001.
