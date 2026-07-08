# 🚀 Fix Homepage Bootstrap Italia - Piano Esecutivo

## Panoramica
Allineare la homepage FixCity (`/it/tests/homepage`) al design Bootstrap Italia reference.

**Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/homepage.html  
**Target**: http://fixcity.local/it/tests/homepage

---

## Fase 1: Header & Hero (Settimana 1)

### Task 1.1: Header Slim Component
**File**: `components/layout/header-slim.blade.php`

```blade
<div class="header-slim bg-primary text-white py-2">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <span class="header-slim-region">Nome della Regione</span>
      <div class="header-slim-actions">
        <a href="#" class="btn btn-sm btn-light">Accedi</a>
      </div>
    </div>
  </div>
</div>
```

**Stima**: 1h  
**Priorità**: 🔴 Alta

### Task 1.2: Hero Bootstrap Italia
**File**: `components/blocks/hero/homepage.blade.php`

**Modifiche**:
- Rimuovere classi Tailwind
- Aggiungere `card card-teaser`
- Usare grid Bootstrap (`row`, `col-md-5`, `col-md-7`)

**Stima**: 30min  
**Priorità**: 🔴 Alta

---

## Fase 2: Governance & Events (Settimana 2)

### Task 2.1: Governance Grid Bootstrap
**File**: `components/blocks/governance/cards.blade.php`

**Modifiche**:
```blade
<!-- PRIMA -->
<div class="grid grid-cols-3 gap-4">

<!-- DOPO -->
<div class="row g-4">
  <div class="col-lg-4 col-md-6">
```

**Stima**: 30min  
**Priorità**: 🔴 Alta

### Task 2.2: Events Calendar List
**File**: `components/blocks/events/calendar.blade.php`

**Aggiungere**:
```blade
<div class="calendar-list">
  <div class="calendar-event">
    <span class="calendar-date">15</span>
    <span class="calendar-day">LUN</span>
```

**Stima**: 1h  
**Priorità**: 🔴 Alta

---

## Fase 3: Topics & Footer (Settimana 3)

### Task 3.1: Topics Uppercase Titles
**File**: `components/blocks/topics/highlight.blade.php`

**Modifiche**:
```blade
<h3 class="card-title h6 text-uppercase text-muted mb-3">
```

**Stima**: 15min  
**Priorità**: 🟡 Media

### Task 3.2: Footer Feedback Module
**File**: `components/footer/full.blade.php`

**Aggiungere**:
- Rating stelle (1-5)
- Form feedback
- Quick actions

**Stima**: 2h  
**Priorità**: 🟡 Media

---

## Testing & QA

### Checklist Testing
- [ ] Header slim visibile desktop
- [ ] Hero card allineata
- [ ] Governance cards same height
- [ ] Events calendar responsive
- [ ] Topics grid mobile-friendly
- [ ] Footer feedback funzionante
- [ ] Cross-browser test
- [ ] Accessibility WCAG 2.1 AA

### Browser Test
- [ ] Chrome (latest)
- [ ] Firefox (latest)
- [ ] Safari (latest)
- [ ] Edge (latest)

### Device Test
- [ ] Desktop (1920x1080)
- [ ] Laptop (1366x768)
- [ ] Tablet (768x1024)
- [ ] Mobile (375x667)

---

## Metriche di Successo

| Metrica | Target | Attuale | Status |
|---------|--------|---------|--------|
| Conformità HTML | 95% | 67% | 🟡 In corso |
| Conformità CSS | 100% | 70% | 🟡 In corso |
| Performance Lighthouse | 90+ | TBD | ⚪ Da testare |
| Accessibility Score | 95+ | TBD | ⚪ Da testare |

---

## Risorse

### Documentazione
- [Bootstrap Italia Docs](https://italia.github.io/design-web-toolkit/)
- [Analisi Visiva](docs/screenshots/homepage/ANALISI_VISIVA.md)
- [Screenshot Analysis](docs/screenshots/homepage/SCREENSHOT_ANALYSIS.md)

### File Correlati
- `Themes/Sixteen/resources/css/bootstrap-italia.css`
- `Themes/Sixteen/resources/views/components/layout/header.blade.php`
- `Themes/Sixteen/resources/views/components/blocks/hero/homepage.blade.php`

---

## Timeline

```
Settimana 1: Header & Hero     [████████░░] 80%
Settimana 2: Governance & Events [░░░░░░░░░░] 0%
Settimana 3: Topics & Footer    [░░░░░░░░░░] 0%
Settimana 4: Testing & QA       [░░░░░░░░░░] 0%
```

---

**Project Manager**: AI Agent  
**Start Date**: 2026-03-31  
**Estimated Completion**: 2026-04-21  
**Status**: 🟡 In Progress
