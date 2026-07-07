# Cms Module Documentation

## Overview

Il modulo Cms gestisce contenuti, composizione pagina e rendering CMS-driven dei blocchi. Nel lavoro corrente sulla parity Design Comuni, il Cms governa la struttura della homepage di test, mentre la resa visuale viene rifinita nel tema Sixteen.

## 📚 Design Comuni - Index Completo

- **[DESIGN_COMUNI_INDEX.md](./DESIGN_COMUNI_INDEX.md)** - **INDEX COMPLETO** con tutti i link bidirezionali

## Active design-comuni references

- [design-comuni-homepage.md](./design-comuni-homepage.md) - Coordinamento Cms per la homepage parity
- [design-comuni-faq.md](./design-comuni-faq.md) - Pagina FAQ ✅ 90%
- [design-comuni-argomenti.md](./design-comuni-argomenti.md) - Pagina argomenti
- [design-comuni-risultati-ricerca.md](./design-comuni-risultati-ricerca.md) - Pagina risultati ricerca
- [design-comuni-page-census.md](./design-comuni-page-census.md) - Censimento 38 pagine
- [design-comuni-services-implementation.md](./design-comuni-services-implementation.md) - Implementazione servizi
- [design-comuni-batch-audit.md](./design-comuni-batch-audit.md) - Audit batch pagine
- [design-comuni-batch-parity.md](./design-comuni-batch-parity.md) - Verifica parity
- [architecture/homepage-structure.md](./architecture/homepage-structure.md) - Flusso runtime aggiornato della homepage di test
- [PAGE_COMPONENT_ARCHITECTURE.md](./PAGE_COMPONENT_ARCHITECTURE.md) - Architettura generale componenti pagina

## Theme cross links

- [../../../Themes/Sixteen/docs/00-index.md](../../../Themes/Sixteen/docs/00-index.md) - Indice docs del tema
- [../../../Themes/Sixteen/docs/design-comuni/00-index.md](../../../Themes/Sixteen/docs/design-comuni/00-index.md) - Workspace attivo parity homepage
- [../../../Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md](../../../Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md) - Analisi 54 pagine
- [../../../Themes/Sixteen/docs/design-comuni/PROGRESS_REPORT.md](../../../Themes/Sixteen/docs/design-comuni/PROGRESS_REPORT.md) - Report progresso
- [../../../docs/design-comuni/MASTER_INDEX.md](../../../docs/design-comuni/MASTER_INDEX.md) - Master Index globale

## Runtime architecture

- La pagina di test e' servita da `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`.
- Il contenuto locale della homepage arriva da `config/local/fixcity/database/content/pages/tests.homepage.json`.
- Il Cms mantiene il contratto dati e la struttura dei blocchi.
- Il tema Sixteen mantiene layout, CSS e JS di parity visuale.

## Operational rule for this workstream

- Se il problema e' strutturale, verificare prima Cms JSON + routing.
- Se il problema e' visivo, lavorare nel tema e documentare i risultati anche qui.
- Mantenere collegamenti bidirezionali tra docs di modulo e docs di tema.
