# 📚 **Indice Documentazione Modulo UI**

**Status**: ✅ PHPStan Level 10 Compliant
**Module Version**: 2.3.0

## 🎯 **Lettura Essenziale**
1. [README.md](./readme.md) - Design System e overview componenti.
2. [roadmap.md](./roadmap.md) - Evoluzione 2026: Tailwind v4 e Flux UI integration.
3. [philosophy.md](./philosophy.md) - "La Bellezza è Funzionale": filosofia del design in Laraxot.

## 🏗️ **Core Design System**
- 🎨 **[Layouts & Themes](./layouts-and-themes.md)** - Gestione dei temi per tenant e dark mode.
- 📐 **[Architecture Rules](./architecture.md)** - Regole per la creazione di nuovi componenti UI.
- 🖋️ **[Icon System](./icon-system.md)** - Integrazione di Blade Icons e set personalizzati.

## 🧱 **Componenti & Widget**
- 🧩 **[Blade Components](./blade-components.md)** - Libreria di componenti atomici riutilizzabili.
- ⚡ **[Filament Components](./filament-components-usage.md)** - Custom columns, fields e widgets per l'Admin Panel.
- 📍 **[Location Selector](./filament-components-location-studio.md)** - Componente avanzato per la selezione geografica.
- 🏛️ **[Design Comuni FAQ Components](./design-comuni-faq-components.md)** - Componenti UI per pagina FAQ (Accordion, Hero, Breadcrumb, Search) ✅ 90%

## 🏛️ **Design Comuni Italia - Replication**

### Documentazione UI
- [FAQ Components](./design-comuni-faq-components.md) - Componenti UI per pagina FAQ
- [Blocks System](./blocks-system.md) - Sistema blocchi universali
- [Design System](./design-system.md) - Design tokens e pattern

### Link Bidirezionali - Tema Sixteen
- [All Pages Analysis](../../Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md) - Analisi 54 pagine
- [Progress Report](../../Themes/Sixteen/docs/design-comuni/PROGRESS_REPORT.md) - Report progresso
- [Argomenti Analisi](../../Themes/Sixteen/docs/design-comuni/ARGOMENTI_ANALISI.md) - Analisi argomenti
- [Risultati Ricerca](../../Themes/Sixteen/docs/design-comuni/RISULTATI_RICERCA_ANALISI.md) - Analisi ricerca
- [FAQ HTML Analysis](../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_HTML_ANALYSIS.md) - Analisi HTML FAQ
- [Master Index Tema](../../Themes/Sixteen/docs/design-comuni/00-index.md) - Index tema Sixteen

### Link Bidirezionali - Modulo Cms
- [Cms Design Comuni Index](../Cms/docs/DESIGN_COMUNI_INDEX.md) - Index completo modulo Cms
- [Cms FAQ](../Cms/docs/design-comuni-faq.md) - Architettura pagina FAQ
- [Cms Homepage](../Cms/docs/design-comuni-homepage.md) - Analisi homepage

### Link Bidirezionali - Master Index
- [Master Index Globale](../../../docs/design-comuni/MASTER_INDEX.md) - Index globale progetto

### Stato Implementazione
| Componente | HTML | CSS | JS | Totale |
|-----------|------|-----|----|--------|
| Accordion | ✅ 95% | ✅ 90% | ✅ 90% | ✅ 92% |
| Hero | ✅ 100% | ✅ 95% | N/A | ✅ 98% |
| Breadcrumb | ✅ 100% | ✅ 100% | N/A | ✅ 100% |
| Search | ✅ 100% | ✅ 90% | ⏳ 0% | ⏳ 65% |

## 🛠️ **Integrazioni Tecniche**
- 🏗️ **[Tailwind v4 Upgrade](./filament-v4-theme-upgrade.md)** - Guida alla migrazione verso l'ultima versione di Tailwind.
- 🛣️ **[Folio & Volt Themes](./struttura-themes-folio.md)** - Gestione dei temi nelle pagine Folio.
- 🧪 **[Table Layout Enum](./table-layout-enum-complete-guide.md)** - Standardizzazione dei layout tabelle.

## 🧪 **Qualità e Sviluppo**
- ✅ **[PHPStan Analysis](./phpstan-level-10-cleanup.md)** - Report di conformità Level 10.
- 🔬 **[Testing UI](./testing.md)** - Test di regressione visuale e componenti.

## 🧹 **Manutenzione**
- 🗑️ **[Cleanup Plan](./consolidation-plan.md)** - Strategia per ridurre i 280+ file di documentazione.

## 📦 **Pacchetti Composer**
- [Riferimento completo](../../../../docs/composer-packages-reference.md) | [Inventario 312 pacchetti](../../../../docs/architecture/composer-packages-full-inventory.md)
- `owenvoke/blade-fontawesome` - Icone FontAwesome

## 🔗 **Moduli Correlati**
- [Xot](../../xot/docs/readme.md) - Base framework per i widget.
- [Cms](../../cms/docs/readme.md) - Layout dei contenuti e blocchi.

---

## 🏛️ **Design Comuni Italia - Replication**

### Documentazione FAQ
- [FAQ Components](./design-comuni-faq-components.md) - Componenti UI per pagina FAQ (Accordion, Hero, Breadcrumb, Search)
- [Blocks System](./blocks-system.md) - Sistema blocchi universali
- [Design System](./design-system.md) - Design tokens e pattern

### Link Bidirezionali
- **Modulo Cms**: [FAQ Page Architecture](../../Cms/docs/design-comuni-faq.md)
- **Tema Sixteen**:
  - [Analisi HTML](../../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_HTML_ANALYSIS.md)
  - [Implementazione](../../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_IMPLEMENTAZIONE.md)
  - [Analisi Visiva](../../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_ANALISI_VISIVA.md)
  - [Report Finale](../../../Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_REPORT_FINALE.md)
  - [Design Comuni Index](../../../Themes/Sixteen/docs/design-comuni/00-index.md)
- **Scripts**: [Screenshot Script](../../../bashscripts/design-comuni/capture-faq-screenshots.js)

### Stato Implementazione
| Componente | HTML | CSS | JS | Totale |
|-----------|------|-----|----|--------|
| Accordion | ✅ 95% | ✅ 90% | ⏳ 0% | ⏳ 62% |
| Hero | ✅ 100% | ✅ 95% | N/A | ✅ 98% |
| Breadcrumb | ✅ 100% | ✅ 100% | N/A | ✅ 100% |
| Search | ✅ 100% | ✅ 90% | ⏳ 0% | ⏳ 65% |

---
*Documentazione conforme agli standard Laraxot - DRY + KISS + SOLID*

## Dependency Intelligence

- [Dependency intelligence](dependency-intelligence.md)
