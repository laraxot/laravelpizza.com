---
title: "Design Comuni HTML Replication - Master Epic"
labels: ["epic", "design-comuni", "priority-high"]
assignees: []
projects: ["Design Comuni Replication"]
---

# 🎯 Epic: Design Comuni HTML Replication

**Obiettivo:** Replicare le 38 pagine statiche di [Design Comuni](https://italia.github.io/design-comuni-pagine-statiche/) con HTML identico dentro il tag `<body>` (esclusi scripts).

**Riferimenti:**
- Source: https://italia.github.io/design-comuni-pagine-statiche/
- Target: http://fixcity.local/it/tests/*
- Master Plan: `.planning/DESIGN_COMUNI_MASTER_PLAN.md`

---

## 📋 Checklist Pagine (38 totali)

### Homepage (1 pagina)
- [ ] `homepage.html` → `tests.homepage.json`

### Amministrazione (4 pagine)
- [ ] `amministrazione.html`
- [ ] `amministrazione-aree.html`
- [ ] `amministrazione-organi.html`
- [ ] `amministrazione-uffici.html`

### Argomenti (2 pagine)
- [ ] `argomenti.html`
- [ ] `argomento-dettaglio.html`

### Novità (2 pagine)
- [ ] `novita.html`
- [ ] `novita-dettaglio.html`

### Appuntamenti (6 pagine)
- [ ] `appuntamento-01-dati.html`
- [ ] `appuntamento-02-privacy.html`
- [ ] `appuntamento-03-riepilogo.html`
- [ ] `appuntamento-04-conferma.html`
- [ ] `appuntamento-05-area-personale.html`
- [ ] `appuntamento-06-dettaglio.html`

### Documenti (2 pagine)
- [ ] `documenti.html`
- [ ] `documenti-dati.html`

### Servizi (2 pagine)
- [ ] `servizi.html`
- [ ] `servizi-dettaglio.html`

### Segnalazioni (7 pagine)
- [ ] `segnalazione-01-privacy.html`
- [ ] `segnalazione-02-dati.html`
- [ ] `segnalazione-03-riepilogo.html`
- [ ] `segnalazione-04-conferma.html`
- [ ] `segnalazione-area-personale.html`
- [ ] `segnalazione-dettaglio.html`
- [ ] `segnalazioni-elenco.html`

### Altre Pagine (12 pagine)
- [ ] `cultura.html`
- [ ] `eventi.html`
- [ ] `famiglia.html`
- [ ] `lavoro.html`
- [ ] `mobilita.html`
- [ ] `salute.html`
- [ ] `sport.html`
- [ ] `turismo.html`

---

## ✅ Definition of Done (Per Pagina)

- [ ] JSON content block creato in `laravel/config/local/fixcity/database/content/pages/`
- [ ] HTML dentro `<body>` (esclusi scripts) IDENTICO al source
- [ ] Screenshot comparison salvato in docs
- [ ] Analisi differenze documentata
- [ ] Fix applicati e verificati
- [ ] Componenti bloccati universali (NON specifici per pagina)

---

## 🔧 Fix Tecnici Richiesti

### 1. Header Structure
- [ ] Skip links corretti
- [ ] Header slim identico
- [ ] Header main identico
- [ ] Logo visibile e corretto
- [ ] Colori Bootstrap Italia

### 2. Footer Structure
- [ ] Footer completo identico
- [ ] Footer slim (se necessario)
- [ ] Link istituzionali
- [ ] Social icons (Filament way)

### 3. Content Blocks
- [ ] Hero block universale
- [ ] Card block universale
- [ ] Navigation block universale
- [ ] Topics grid universale
- [ ] News carousel universale

---

## 📚 Documentazione

- [ ] `laravel/Themes/Sixteen/docs/design-comuni/HTML_REPLICATION_GUIDE.md`
- [ ] `laravel/Themes/Sixteen/docs/design-comuni/BLOCKS_CATALOG.md`
- [ ] `laravel/Themes/Sixteen/docs/design-comuni/SCREENSHOTS/` (analisi)
- [ ] `laravel/Modules/Cms/docs/PAGE_COMPONENT_ARCHITECTURE.md`
- [ ] `laravel/Modules/Cms/docs/JSON_CONTENT_BLOCKS.md`
- [ ] `docs/project/DESIGN_COMUNI_REPLICATION_STATUS.md`

---

## 🚀 Phases

### Phase 1: Foundation ✅ COMPLETO
- [x] Setup `[slug].blade.php` pattern
- [x] Register `pub_theme` namespace
- [x] Fix Vite configuration
- [x] Create basic JSON blocks

### Phase 2: Header/Footer Parity 🔄 IN CORSO
- [ ] HTML structure identical within `<body>`
- [ ] Skip links corretti
- [ ] Header slim identico
- [ ] Header main identico
- [ ] Footer identico
- [ ] Screenshot analysis + docs

### Phase 3: Content Blocks ⏳ PENDENTE
- [ ] Hero block universale
- [ ] Card block universale
- [ ] Navigation block universale
- [ ] Topics grid universale
- [ ] News carousel universale

### Phase 4: All 38 Pages ⏳ PENDENTE
- [ ] Create JSON for each page
- [ ] Verify HTML parity
- [ ] Screenshot analysis
- [ ] Documentation

### Phase 5: Polish & Docs ⏳ PENDENTE
- [ ] Update all docs folders
- [ ] Update rules, memories, skills
- [ ] Create blocks catalog
- [ ] Final verification

---

## 🔗 Related Issues

- #1 - Fix header HTML structure
- #2 - Fix footer HTML structure
- #3 - Create universal hero block
- #4 - Create universal card block
- #5 - Create universal navigation block

---

**Data Creazione:** 2026-04-01  
**Data Scadenza:** 2026-04-15  
**Stato:** 🔄 In Progress  
