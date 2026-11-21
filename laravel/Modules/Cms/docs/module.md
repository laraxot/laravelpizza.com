---
issues: []
discussions: []
title: "Cms Module — Doctrine"
type: doctrine
tags: [cms, content-management, module-doctrine]
created: 2026-09-05
updated: 2026-09-05
qmd: "Cms module doctrine BMAD analysis purpose religion philosophy policy why zen gap enhancements split merge"
related:
  - "../../Xot/docs/module.md"
  - "../../UI/docs/module.md"
---

# Cms Module — Doctrine

## Scope (Scopo)

Cms gestisce i contenuti web dinamici: pagine modulari, blocchi componibili, temi personalizzabili, versioning. Centralizza la gestione di contenuti strutturati con supporto multilingua e composizione di blocchi per costruire pagine senza codice.

## Religion (Religione)

**"Il contenuto è LEGO, le pagine sono costruzioni."** La convinzione non negoziabile è che i contenuti devono essere componibili: blocchi riutilizzabili che si assembrano in pagine complesse senza sviluppo custom. Ogni blocco è un mattoncino, ogni pagina è un progetto.

## Philosophy (Filosofia)

- **Block-based architecture**: pagine composte da blocchi riutilizzabili
- **Sushi pattern**: modelli in memoria veloci per dati statici
- **HasBlocks trait**: gestione contenuti strutturati in JSON
- **DDD-lite**: modelli ricchi di comportamento
- **Versioning**: ogni modifica di pagina è versionata

## Policy (Politica)

- Slug unico per ogni pagina (accesso diretto)
- Supporto multilingua obbligatorio
- Blocchi serializzabili in JSON
- Temi gestiti tramite namespace di visualizzazione separati
- Provider estende XotBaseServiceProvider

## Why (Perché)

Cms esiste perché la gestione dei contenuti è una funzionalità trasversale che serve a Blog, Document, e altri moduli ma richiede logiche specifiche di strutturazione, versioning, e theming. Cms è il sistema di blocks che tutti usano.

## Zen

*"Blocchi come LEGO, pagine come architetture. Contenuto componibile, non fragile."*

## Gap

- Test unitari insufficienti
- Factory incomplete
- Policies di autorizzazione assenti
- Eventi di dominio non completamente implementati
- API resource limitata

## Add

- Policies di autorizzazione per Page, Section, Attachment
- Test coverage al 80%
- Eventi di dominio (PageCreated, PageUpdated, etc.)
- API resource esposte per consumatori frontend
- Caching strategico per menu e blocchi frequentati

## Split/Merge

**Mantenere come-is.** Cms ha responsabilità ben definita e coerente. Non ha sovrapposizioni significative con altri moduli. La complessità interna giustifica la mantenimento come unità separata.

## Future Enhancements

1. **Visual page builder**: drag-and-drop per costruire pagine da blocchi
2. **A/B testing**: testare varianti di blocchi
3. **Content scheduling**: pubblicazione automatica programmata
4. **Personalization engine**: contenuti diversi per segmento utente
5. **Multi-site CMS**: un CMS per più siti/brand
6. **Headless CMS API**: API GraphQL/REST per frontend decoupled
