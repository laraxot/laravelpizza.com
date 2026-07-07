# Design Comuni Italia - Master Documentation Index

## Panoramica Progetto

Replicazione delle 38 pagine statiche del progetto [Design Comuni Italia](https://github.com/italia/design-comuni-pagine-statiche) utilizzando:
- **Tailwind CSS** (NO Bootstrap Italia)
- **Alpine.js** (per interattività)
- **Laravel Folio + Volt** (routing e componenti)
- **JSON-driven content blocks** (CMS-driven)

## Stato Globale

| Pagina | HTML | CSS | JS | Docs | Totale |
|--------|------|-----|----|------|--------|
| **Domande Frequenti** | ✅ 87.5% | ✅ 90% | ⏳ 20% | ✅ Complete | **✅ 85%** |
| Homepage | ✅ 95% | ✅ 95% | ✅ 80% | ✅ Complete | ✅ 90% |
| Argomenti | ⏳ 60% | ⏳ 50% | ⏳ 0% | ⏳ Parziali | ⏳ 37% |
| Altre 35 pagine | ❌ 0% | ❌ 0% | ❌ 0% | ❌ Assenti | ❌ 0% |

---

## 📚 Documentazione per Modulo/Tema

### 🎨 Tema Sixteen

**Directory**: `laravel/Themes/Sixteen/docs/design-comuni/`

| Documento | File | Descrizione |
|-----------|------|-------------|
| **Index** | [00-index.md](../laravel/Themes/Sixteen/docs/design-comuni/00-index.md) | Indice principale Design Comuni |
| **Analisi HTML** | [DOMANDE_FREQUENTI_HTML_ANALYSIS.md](../laravel/Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_HTML_ANALYSIS.md) | Confronto struttura HTML reference vs local |
| **Implementazione** | [DOMANDE_FREQUENTI_IMPLEMENTAZIONE.md](../laravel/Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_IMPLEMENTAZIONE.md) | Report implementazione completo |
| **Analisi Visiva** | [DOMANDE_FREQUENTI_ANALISI_VISIVA.md](../laravel/Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_ANALISI_VISIVA.md) | Analisi screenshots comparativi |
| **Report Finale** | [DOMANDE_FREQUENTI_REPORT_FINALE.md](../laravel/Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_REPORT_FINALE.md) | Stato finale e prossimi passi |
| **Stato Attuale** | [STATO_ATTUALE_FAQ.md](../laravel/Themes/Sixteen/docs/design-comuni/STATO_ATTUALE_FAQ.md) | Analisi problemi e piano di fix |
| **Fix Parity JS** | [FIX_ACCORDION_PARITY_JS.md](../laravel/Themes/Sixteen/docs/design-comuni/FIX_ACCORDION_PARITY_JS.md) | Rimozione domande-frequenti-parity.js |
| **Fix Accordion Finale** | [FIX_ACCORDION_FINALE.md](../laravel/Themes/Sixteen/docs/design-comuni/FIX_ACCORDION_FINALE.md) | Report fix accordion completo |
| **Analisi Struttura** | [ANALISI_STRUTTURA_HTML_FAQ.md](../laravel/Themes/Sixteen/docs/design-comuni/ANALISI_STRUTTURA_HTML_FAQ.md) | Analisi dettagliata struttura HTML |
| **Alpine.js Accordion** | [ALPINE_JS_ACCORDION_IMPLEMENTAZIONE.md](../laravel/Themes/Sixteen/docs/design-comuni/ALPINE_JS_ACCORDION_IMPLEMENTAZIONE.md) | Implementazione Alpine.js |
| **Report Fix Completo** | [REPORT_FIX_COMPLETO_FAQ.md](../laravel/Themes/Sixteen/docs/design-comuni/REPORT_FIX_COMPLETO_FAQ.md) | Report finale tutti i fix |
| **Risultati Ricerca Analisi** | [RISULTATI_RICERCA_ANALISI.md](../laravel/Themes/Sixteen/docs/design-comuni/RISULTATI_RICERCA_ANALISI.md) | Analisi struttura risultati ricerca |
| **Risultati Ricerca Report** | [RISULTATI_RICERCA_REPORT.md](../laravel/Themes/Sixteen/docs/design-comuni/RISULTATI_RICERCA_REPORT.md) | Report implementazione risultati ricerca |
| **Risultati Ricerca Report Finale** | [RISULTATI_RICERCA_REPORT_FINALE.md](../laravel/Themes/Sixteen/docs/design-comuni/RISULTATI_RICERCA_REPORT_FINALE.md) | Report finale completo |
| **Argomenti Analisi** | [ARGOMENTI_ANALISI.md](../laravel/Themes/Sixteen/docs/design-comuni/ARGOMENTI_ANALISI.md) | Analisi struttura argomenti |
| **Argomenti Report Finale** | [ARGOMENTI_REPORT_FINALE.md](../laravel/Themes/Sixteen/docs/design-comuni/ARGOMENTI_REPORT_FINALE.md) | Report finale argomenti |
| **Argomenti Report Aggiornato** | [ARGOMENTI_REPORT_AGGIORNATO.md](../laravel/Themes/Sixteen/docs/design-comuni/ARGOMENTI_REPORT_AGGIORNATO.md) | Report aggiornato post-cache clear |
| **Screenshots FAQ** | [screenshots/](../laravel/Themes/Sixteen/docs/design-comuni/screenshots/) | 150+ files comparativi FAQ |
| **Screenshots Ricerca** | [screenshots/risultati-ricerca/](../laravel/Themes/Sixteen/docs/design-comuni/screenshots/risultati-ricerca/) | Screenshots risultati ricerca |
| **Screenshots Argomenti** | [screenshots/argomenti/](../laravel/Themes/Sixteen/docs/design-comuni/screenshots/argomenti/) | Screenshots argomenti |
| **Screenshots All Pages** | [screenshots/all-pages/](../laravel/Themes/Sixteen/docs/design-comuni/screenshots/all-pages/) | Screenshots tutte 54 pagine |
| **All Pages Analysis** | [ALL_PAGES_ANALYSIS.md](../laravel/Themes/Sixteen/docs/design-comuni/ALL_PAGES_ANALYSIS.md) | Analisi completa 54 pagine |
| **Progress Report** | [PROGRESS_REPORT.md](../laravel/Themes/Sixteen/docs/design-comuni/PROGRESS_REPORT.md) | Report progresso aggiornato |
| **Fail Pages Analysis** | [FAIL_PAGES_ANALYSIS.md](../laravel/Themes/Sixteen/docs/design-comuni/FAIL_PAGES_ANALYSIS.md) | Analisi pagine fail |
| **Skills & Rules** | [SKILLS_RULES.md](../laravel/Themes/Sixteen/docs/design-comuni/SKILLS_RULES.md) | Skills, rules e best practices |
| **Segnalazioni Elenco Analisi** | [SEGNALAZIONI_ELENCO_ANALISI.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_ANALISI.md) | Analisi segnalazioni elenco (95.7%) |
| **Segnalazioni Elenco Report** | [SEGNALAZIONI_ELENCO_REPORT.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_REPORT.md) | Report segnalazioni elenco - TARGET RAGGIUNTO |
| **Segnalazioni Elenco Visual** | [SEGNALAZIONI_ELENCO_VISUAL_ANALYSIS.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_VISUAL_ANALYSIS.md) | Analisi visiva dettagliata |
| **Segnalazioni Elenco CSS** | [SEGNALAZIONI_ELENCO_CSS_REPORT.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_CSS_REPORT.md) | Report CSS fix (+327 lines) |
| **Segnalazioni Elenco Layout Fix** | [SEGNALAZIONI_ELENCO_LAYOUT_FIX.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_LAYOUT_FIX.md) | Fix layout mappa/filtri (101.1%) |
| **Segnalazioni Elenco Rating Fix** | [SEGNALAZIONI_ELENCO_RATING_FIX.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_RATING_FIX.md) | Fix rating duplicato (99.1%) |
| **Segnalazioni Elenco Tabs Analysis** | [SEGNALAZIONI_ELENCO_TABS_ANALYSIS.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_TABS_ANALYSIS.md) | Analisi tabs e bottoni |
| **Segnalazioni Elenco Elementi Analisi** | [SEGNALAZIONI_ELENCO_ELEMENTI_ANALISI.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_ELEMENTI_ANALISI.md) | Analisi completa elementi e fix modal |
| **Segnalazioni Elenco Fix Completi** | [SEGNALAZIONI_ELENCO_FIX_COMPLETI.md](../laravel/Themes/Sixteen/docs/design-comuni/SEGNALAZIONI_ELENCO_FIX_COMPLETI.md) | Fix completi e analisi elementi (92.5%) |
| **Batch Pages Analysis** | [BATCH_PAGES_ANALYSIS.md](../laravel/Themes/Sixteen/docs/design-comuni/BATCH_PAGES_ANALYSIS.md) | Analisi completa 49 pagine |
| **Batch Progress Report** | [BATCH_PROGRESS_REPORT.md](../laravel/Themes/Sixteen/docs/design-comuni/BATCH_PROGRESS_REPORT.md) | Report progresso batch |
| **Fail Pages Detail** | [FAIL_PAGES_DETAIL_REPORT.md](../laravel/Themes/Sixteen/docs/design-comuni/FAIL_PAGES_DETAIL_REPORT.md) | Analisi dettagliata 3 pagine fail |
| **Fail Pages Fix Report** | [FAIL_PAGES_FIX_REPORT.md](../laravel/Themes/Sixteen/docs/design-comuni/FAIL_PAGES_FIX_REPORT.md) | Report fix pagine fail |

### 🐙 GitHub Integration

| Documento | File | Descrizione |
|-----------|------|-------------|
| **GitHub Issues Docs** | [GITHUB_ISSUES_DISCUSSIONS.md](../bashscripts/docs/GITHUB_ISSUES_DISCUSSIONS.md) | Documentazione issues e discussions |
| **GitHub Issues Template** | [GITHUB_ISSUES_TEMPLATE.md](../bashscripts/docs/GITHUB_ISSUES_TEMPLATE.md) | Template completo per 54 issues |
| **GitHub Issues Batch JSON** | [github-issues-batch.json](../bashscripts/design-comuni/github-issues-batch.json) | 54 issues pre-configurate |
| **Create Issues Batch** | [create-github-issues-batch.sh](../bashscripts/design-comuni/create-github-issues-batch.sh) | Script batch (CONSIGLIATO) |
| **Create Issues Script** | [create-github-issues.sh](../bashscripts/design-comuni/create-github-issues.sh) | Script per creare 54 issues |
| **Create Discussions Script** | [create-github-discussions.sh](../bashscripts/design-comuni/create-github-discussions.sh) | Script per creare discussions |

### 📦 Modulo Cms

**Directory**: `laravel/Modules/Cms/docs/`

| Documento | File | Descrizione |
|-----------|------|-------------|
| **Cms Design Comuni Index** | [DESIGN_COMUNI_INDEX.md](../laravel/Modules/Cms/docs/DESIGN_COMUNI_INDEX.md) | **INDEX COMPLETO** modulo Cms |
| **FAQ Architecture** | [design-comuni-faq.md](../laravel/Modules/Cms/docs/design-comuni-faq.md) | Architettura pagina FAQ |
| **Homepage Analysis** | [design-comuni-homepage.md](../laravel/Modules/Cms/docs/design-comuni-homepage.md) | Analisi homepage |
| **Argomenti** | [design-comuni-argomenti.md](../laravel/Modules/Cms/docs/design-comuni-argomenti.md) | Pagina argomenti |
| **Risultati Ricerca** | [design-comuni-risultati-ricerca.md](../laravel/Modules/Cms/docs/design-comuni-risultati-ricerca.md) | Pagina ricerca |
| **Index Modulo** | [00-index.md](../laravel/Modules/Cms/docs/00-index.md) | Indice completo modulo Cms |

### 🧩 Modulo UI

**Directory**: `laravel/Modules/UI/docs/`

| Documento | File | Descrizione |
|-----------|------|-------------|
| **FAQ Components** | [design-comuni-faq-components.md](../laravel/Modules/UI/docs/design-comuni-faq-components.md) | Componenti UI FAQ |
| **Blocks System** | [blocks-system.md](../laravel/Modules/UI/docs/blocks-system.md) | Sistema blocchi UI |
| **Design System** | [design-system.md](../laravel/Modules/UI/docs/design-system.md) | Design tokens e pattern |
| **Index Modulo** | [00-index.md](../laravel/Modules/UI/docs/00-index.md) | Indice completo modulo UI |

### 🛠️ Scripts & Tools

**Directory**: `bashscripts/`

| Script | File | Documentazione |
|--------|------|----------------|
| **Screenshot Capture** | [design-comuni/capture-faq-screenshots.js](../bashscripts/design-comuni/capture-faq-screenshots.js) | [DESIGN_COMUNI_SCREENSHOT_SCRIPT.md](../bashscripts/docs/DESIGN_COMUNI_SCREENSHOT_SCRIPT.md) |

---

## 🔗 Link Bidirezionali Completi

### FAQ Page → Tutti i Documenti Correlati

```
FAQ Page (/it/tests/domande-frequenti)
│
├─ JSON Content
│  └─ laravel/config/local/fixcity/database/content/pages/tests.domande-frequenti.json
│
├─ Blade Templates (Tema Sixteen)
│  ├─ components/blocks/accordion/default.blade.php
│  ├─ components/blocks/hero/default.blade.php
│  ├─ components/blocks/breadcrumb/default.blade.php
│  └─ components/blocks/search/input.blade.php
│
├─ CSS Styles
│  └─ laravel/Themes/Sixteen/resources/css/components/design-comuni.css
│
├─ Documentazione Tema Sixteen
│  ├─ Analisi HTML
│  ├─ Implementazione
│  ├─ Analisi Visiva
│  ├─ Report Finale
│  └─ Index Design Comuni
│
├─ Documentazione Modulo Cms
│  ├─ FAQ Architecture
│  ├─ Content Blocks
│  └─ Index Modulo
│
├─ Documentazione Modulo UI
│  ├─ FAQ Components
│  ├─ Blocks System
│  ├─ Design System
│  └─ Index Modulo
│
└─ Scripts & Tools
   ├─ Screenshot Capture
   └─ Script Docs
```

---

## 📊 Metriche Documentazione

### Totale Files

| Categoria | Count | Size Totale |
|-----------|-------|-------------|
| Documenti Tema Sixteen | 4 docs + 146 screenshots | ~15 MB |
| Documenti Modulo Cms | 1 doc | ~8 KB |
| Documenti Modulo UI | 1 doc | ~12 KB |
| Scripts | 1 script + 1 doc | ~10 KB |
| **Totale** | **153 files** | **~15 MB** |

### Link Bidirezionali

Ogni documento contiene:
- ✅ Link ai documenti correlati
- ✅ Link ai moduli/temi coinvolti
- ✅ Link agli scripts utilizzati
- ✅ Link agli screenshots di riferimento

**Totale link bidirezionali**: ~50+ links

---

## 🎯 Prossimi Passi per Documentazione

### Priorità 1: Completare FAQ
- [ ] Documentare implementazione Alpine.js (quando pronta)
- [ ] Aggiungere screenshots responsive (mobile, tablet)
- [ ] Documentare test accessibilità WCAG 2.1 AA

### Priorità 2: Altre Pagine
- [ ] Creare documentazione per Homepage (simile a FAQ)
- [ ] Creare documentazione per Argomenti
- [ ] Estendere pattern per altre 35 pagine

### Priorità 3: Master Documentation
- [ ] Creare script per verificare link bidirezionali
- [ ] Generare automaticamente cross-reference matrix
- [ ] Mantenere documentazione sincronizzata con codice

---

## 📖 Come Utilizzare Questa Documentazione

### Per Sviluppatori

1. **Iniziare da qui**: [Index Design Comuni](../laravel/Themes/Sixteen/docs/design-comuni/00-index.md)
2. **Capire architettura**: [FAQ Architecture (Cms)](../laravel/Modules/Cms/docs/design-comuni-faq.md)
3. **Vedere componenti**: [FAQ Components (UI)](../laravel/Modules/UI/docs/design-comuni-faq-components.md)
4. **Analizzare differenze**: [Analisi HTML (Sixteen)](../laravel/Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_HTML_ANALYSIS.md)
5. **Testare visivamente**: [Screenshots](../laravel/Themes/Sixteen/docs/design-comuni/screenshots/)

### Per AI Agents

1. **Mappare codebase**: [Index Modulo Cms](../laravel/Modules/Cms/docs/00-index.md)
2. **Capire blocchi**: [Content Blocks System](../laravel/Modules/Cms/docs/content-blocks-system.md)
3. **Vedere componenti UI**: [Blocks System UI](../laravel/Modules/UI/docs/blocks-system.md)
4. **Eseguire tests**: [Screenshot Script](../bashscripts/design-comuni/capture-faq-screenshots.js)

### Per Project Managers

1. **Stato progetto**: Questo file (master index)
2. **Dettaglio implementazione**: [Report Finale FAQ](../laravel/Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_REPORT_FINALE.md)
3. **Analisi visiva**: [Analisi Visiva](../laravel/Themes/Sixteen/docs/design-comuni/DOMANDE_FREQUENTI_ANALISI_VISIVA.md)

---

## 🏗️ Architettura Documentazione

```
Master Index (questo file - docs/design-comuni/MASTER_INDEX.md)
│
├─ Tema Sixteen (laravel/Themes/Sixteen/docs/design-comuni/)
│  ├─ 00-index.md (indice locale)
│  ├─ DOMANDE_FREQUENTI_*.md (4 docs FAQ)
│  └─ screenshots/ (146 files)
│
├─ Modulo Cms (laravel/Modules/Cms/docs/)
│  ├─ 00-index.md (indice modulo)
│  └─ design-comuni-faq.md (doc FAQ)
│
├─ Modulo UI (laravel/Modules/UI/docs/)
│  ├─ 00-index.md (indice modulo)
│  └─ design-comuni-faq-components.md (doc componenti)
│
└─ Bash Scripts (bashscripts/)
   ├─ design-comuni/ (scripts)
   └─ docs/ (documentazione scripts)
```

---

## 📞 Contatti e Responsabilità

| Ruolo | Responsabilità | Dove Documentare |
|-------|---------------|------------------|
| **Frontend Dev** | CSS/HTML componenti | Tema Sixteen docs |
| **Backend Dev** | JSON content, routing | Modulo Cms docs |
| **UI Dev** | Componenti Blade | Modulo UI docs |
| **QA/Test** | Screenshots, analisi | Tema Sixteen screenshots |
| **AI Agent** | Automazione, scripts | Bashscripts docs |

---

**Ultimo Aggiornamento**: 2026-04-03  
**Versione**: 1.0  
**Stato**: ✅ Documentazione FAQ Completa  
**Manutenitore**: AI Agent Team
