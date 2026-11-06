---
id: IM-CMS-001
title: "Hub risorse per bisogno civico"
type: story
module: Cms
epic: "II Contenuti pilota"
status: blocked
priority: P1
owner: module:Cms
scope: "laravel/Modules/Cms/docs/, laravel/config/local/fixcity/database/content/"
created: 2026-10-15
updated: 2026-10-15
tags: [bmad, cms, resource-hub]
qmd: "hub risorse guide checklist blog eventi JSON CMS"
related: [IM-BLOG-004, IM-SIXTEEN-001]
issues: []
discussions: []
---
# Hub risorse per bisogno civico

## Richiesta / scopo
Come cittadino o ente voglio trovare guide, articoli ed eventi partendo dal bisogno, non da un archivio cronologico.

## Perché
Il pattern utile osservato nei siti studiati è problema → metodo → strumento → CTA. CMS deve comporre il percorso, mentre Blog resta owner dei contenuti.

## Acceptance Criteria
- [ ] L'hub usa contenuti Blog pubblicati e non copia i record.
- [ ] Le sezioni JSON restano la fonte di slogan, link e ordine dove previsto.
- [ ] Il percorso è localizzato e accessibile da tastiera e screen reader.
- [ ] Empty state e contenuto non pubblicato sono gestiti senza errori.

## Tasks / Subtasks
- [ ] Definire struttura JSON minima compatibile con sezioni esistenti.
- [ ] Collegare solo route/slug canonici.
- [ ] Preparare smoke responsive e accessibilità.

## Owned File / Module Scope
CMS sections/content e docs; presentazione demandata a Sixteen.

## Testing / Verifica
PHPStan/Pest CMS, rendering JSON, link check, audit WCAG.

## Dipendenze
IM-BLOG-005; IM-SIXTEEN-001.

## Design Comuni (gate)

Hub risorse segue `lista-risorse.html` / `lista-risorse-categorie.html` e
aggregazione tema da `argomento.html`. Studio:
[design-comuni-static-pages-study.md](../../../Fixcity/docs/bmad/design-comuni-static-pages-study.md).
