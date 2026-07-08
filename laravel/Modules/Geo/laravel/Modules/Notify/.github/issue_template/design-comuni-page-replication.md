---
name: Design Comuni Page Replication
about: Replicate a static page from Design Comuni Italia
title: '[DESIGN COMUNI] Replicate [pagina-name].html'
labels: 'design-comuni, html-parity, enhancement'
assignees: ''
---

## 🎯 Obiettivo

Replicare la pagina **[pagina-name].html** da Design Comuni Italia.

**Source**: https://italia.github.io/design-comuni-pagine-statiche/sito/[pagina-name].html  
**Target**: http://fixcity.local/it/tests/[pagina-name]  
**HTML Parity**: 100% match dentro `<body>` (esclusi scripts)

---

## ✅ Checklist

### 1. JSON Content
- [ ] Creare `laravel/config/local/fixcity/database/content/pages/tests.[pagina-name].json`
- [ ] Definire blocchi con type generici (hero, card, navigation, etc.)
- [ ] Set weight per ordinamento
- [ ] Verificare nodo `"slug": "tests.[pagina-name]"`

### 2. Block Views
- [ ] Creare block views mancanti in `laravel/Themes/Sixteen/resources/views/components/blocks/<type>/`
- [ ] Usare classi Bootstrap Italia (replicate con Tailwind @apply)
- [ ] Assicurarsi che blocchi siano universali (NOT page-specific)

### 3. Test Pagina
- [ ] Visitare `http://fixcity.local/it/tests/[pagina-name]`
- [ ] Verificare rendering corretto
- [ ] Controllare header e footer

### 4. HTML Parity Verification
- [ ] Scaricare originale: `curl -s https://italia.github.io/design-comuni-pagine-statiche/sito/[pagina-name].html > /tmp/agid-[pagina-name].html`
- [ ] Confrontare body HTML (esclusi scripts)
- [ ] Verificare 95%+ match

### 5. Screenshot Comparison
- [ ] Screenshot originale
- [ ] Screenshot FixCity
- [ ] Analisi differenze
- [ ] Save in `laravel/Themes/Sixteen/docs/design-comuni/screenshots/[pagina-name]/`
- [ ] Creare `[pagina-name]-comparison.md` con analisi e fix

### 6. Documentation
- [ ] Aggiornare `MASTER_IMPLEMENTATION_PLAN.md` con status
- [ ] Aggiornare block index se nuovi blocchi
- [ ] Bidirectional links

---

## 📊 Block Analysis

### Blocchi Identificati

| # | Type | View | Weight | Status |
|---|------|------|--------|--------|
| 1 | header-slim | `pub_theme::components.blocks.header.slim` | 1 | ⏳ |
| 2 | header-main | `pub_theme::components.blocks.header.main` | 2 | ⏳ |
| 3 | navigation | `pub_theme::components.blocks.navigation.main` | 3 | ⏳ |
| ... | ... | ... | ... | ... |

### Blocchi da Creare

- [ ] `components/blocks/[type]/[blade].blade.php`
- [ ] ...

---

## 📸 Screenshot Analysis

### Header
- **Originale**: [Link]
- **FixCity**: [Link]
- **Differenze**:
  - Colori: ❌ Diversi
  - Logo: ❌ Non visibile
  - Spazi: ❌ Diversi
- **Fix Richiesti**: ...

### Footer
- **Originale**: [Link]
- **FixCity**: [Link]
- **Differenze**:
  - Layout: ❌ Diverso
  - Link: ❌ Mancanti
- **Fix Richiesti**: ...

### Content
- **Originale**: [Link]
- **FixCity**: [Link]
- **Differenze**: ...
- **Fix Richiesti**: ...

---

## 🔧 Fix Applicati

1. ...
2. ...

---

## ✅ Verification

- [ ] HTML Parity: 95%+
- [ ] Visual Parity: 95%+
- [ ] Header: ✅ Match
- [ ] Footer: ✅ Match
- [ ] Blocks: ✅ All created
- [ ] JSON: ✅ Valid
- [ ] Docs: ✅ Updated

---

## 📚 Related

- **Design Comuni**: https://italia.github.io/design-comuni-pagine-statiche/sito/[pagina-name].html
- **Block Analysis**: `_bmad-output/design-comuni-block-analysis.md`
- **Master Plan**: `Themes/Sixteen/docs/design-comuni/MASTER_IMPLEMENTATION_PLAN.md`
- **Architecture**: `Themes/Sixteen/docs/design-comuni/ARCHITECTURAL_DECISIONS.md`
