# 📚 OpenViking Context - FixCity Homepage Alignment

## Project: FixCity Fila5
## Component: Homepage Bootstrap Italia Alignment
## Date: 2026-03-31

---

## 🎯 Obiettivo

Allineare la homepage FixCity (`/it/tests/homepage`) al design Bootstrap Italia reference.

**Reference URL**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html  
**FixCity URL**: http://fixcity.local/it/tests/homepage

---

## 📊 Stato Attuale

### Conformità
- **HTML Structure**: 67%
- **CSS Classes**: 70%
- **Visual Design**: 65%
- **Accessibility**: TBD

### Componenti Analizzati
1. ✅ Header (60% conforme)
2. ✅ Hero Section (70% conforme)
3. ✅ Governance Cards (75% conforme)
4. ✅ Events Calendar (65% conforme)
5. ✅ Topics Grid (80% conforme)
6. ✅ Footer (50% conforme)

---

## 📁 Documentazione

### Cartelle Documentazione
```
docs/screenshots/homepage/
├── ANALISI_VISIVA.md          ← Analisi dettagliata
├── SCREENSHOT_ANALYSIS.md     ← Screenshot comparison
└── FIX_PLAN.md                ← Piano esecutivo

laravel/Themes/Sixteen/docs/screenshots/homepage/
├── (stessi file)

laravel/Modules/Cms/docs/screenshots/homepage/
├── (stessi file)
```

### File Correlati
- `Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- `Themes/Sixteen/resources/views/components/blocks/hero/homepage.blade.php`
- `Themes/Sixteen/resources/views/components/blocks/governance/cards.blade.php`
- `Themes/Sixteen/resources/views/components/blocks/events/calendar.blade.php`
- `Themes/Sixteen/resources/views/components/blocks/topics/highlight.blade.php`
- `Themes/Sixteen/resources/views/components/footer/full.blade.php`

---

## 🛠️ Fix Necessari

### Priorità Alta (🔴)
1. **Header Slim** - Aggiungere componente
2. **Hero Card-Teaser** - Usare classi Bootstrap Italia
3. **Events Calendar-List** - Implementare struttura calendar

### Priorità Media (🟡)
4. **Governance Grid** - Convertire a Bootstrap grid
5. **Topics Uppercase** - Fix titoli
6. **Footer Feedback** - Aggiungere modulo stelle

---

## 📋 CMS Integration

### JSON Configuration
File: `config/local/fixcity/database/content/pages/tests.homepage.json`

**Content Blocks**:
```json
{
  "content_blocks": {
    "it": [
      {
        "type": "hero",
        "data": {
          "view": "pub_theme::components.blocks.hero.homepage",
          "title": "Nome del Comune",
          "news": {...}
        }
      },
      {
        "type": "governance",
        "data": {
          "view": "pub_theme::components.blocks.governance.cards",
          "items": [...]
        }
      },
      {
        "type": "event",
        "data": {
          "view": "pub_theme::components.blocks.events.calendar",
          "items": [...]
        }
      },
      {
        "type": "topics",
        "data": {
          "view": "pub_theme::components.blocks.topics.highlight",
          "items": [...]
        }
      }
    ]
  }
}
```

---

## 🚀 Prossimi Passi

### Fase 1: Header & Hero
- [ ] Creare `header-slim.blade.php`
- [ ] Fixare `hero/homepage.blade.php`
- [ ] Testare responsive

### Fase 2: Governance & Events
- [ ] Convertire governance grid
- [ ] Implementare calendar-list
- [ ] Testare scroll orizzontale

### Fase 3: Topics & Footer
- [ ] Fixare topics uppercase
- [ ] Aggiungere feedback module
- [ ] Testare footer columns

---

## 📈 Metriche

| KPI | Target | Attuale | Delta |
|-----|--------|---------|-------|
| Conformità Bootstrap Italia | 95% | 67% | -28% |
| Numero Componenti Fixati | 6 | 0 | -6 |
| Testing Coverage | 90% | TBD | - |
| Performance Score | 90+ | TBD | - |

---

## 🔗 Link Utili

- [Bootstrap Italia Design System](https://italia.github.io/design-web-toolkit/)
- [Documentazione FixCity](docs/SESSIONE_COMPLETA.md)
- [CSS Architecture](docs/CSS_ARCHITECTURE.md)
- [Analisi Visiva](docs/screenshots/homepage/ANALISI_VISIVA.md)

---

## 👥 Team

- **Project Manager**: AI Agent
- **Developer**: Ralph Loop
- **QA**: GSD Verifier
- **Documentation**: NotebookLM

---

**Last Update**: 2026-03-31  
**Next Review**: Dopo Fase 1  
**Status**: 🟡 In Progress
