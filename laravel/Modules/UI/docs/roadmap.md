---
title: "roadmap"
type: note
tags: [documentation, roadmap]
created: 2026-09-26
updated: 2026-10-07
qmd: "roadmap"
issues: []
discussions: []
status: draft
---

# Roadmap del modulo UI

**Modulo**: UI (componenti di interfaccia e design system)
**Priorita'**: alta
**PHPStan**: livello 10, `phpstan analyse Modules` a zero errori (verifica del 2026-10-07)
**Filament**: la roadmap 2025 fu scritta per 4.x; il modulo oggi e' su Filament 5 (vedi [README](../README.md))

Questo file unisce due versioni della roadmap che il merge `HEAD` vs `laraxot/dev` aveva concatenato: la direzione 2026 (Tailwind v4, Flux UI) e il piano 2025 (AGID, mobile, qualita'). Il piano 2025 e' storico e non e' stato riallineato.

> "L'interfaccia e' l'essenza: rendere l'esperienza indimenticabile."

## Visione (evoluzione 2026)

Creare un ecosistema UI "Headless-first" che permetta di cambiare radicalmente il look-and-feel di un tenant tramite semplici configurazioni JSON, sfruttando Tailwind CSS v4 e le animazioni native del browser.

### Fasi di sviluppo

**Fase 1: Modernization (in corso)**
- [x] PHPStan Level 10 compliance
- [ ] Completamento migrazione a **Tailwind CSS v4**
- [ ] Implementazione di **Flux UI** per i componenti interattivi di base
- [ ] Rimozione definitiva dei 280+ file obsoleti

**Fase 2: Component Studio (pianificata)**
- [ ] "Gallery" live per testare i componenti UI isolati
- [ ] Sistema di **Design Tokens** centralizzato, esportabile in vari formati
- [ ] Nuovi componenti avanzati per **Data Visualization** (integrazione Chart)

**Fase 3: AI Design (futura)**
- [ ] **AI Theme Generator**: palette colori accessibili generate da un'immagine di brand
- [ ] **Dynamic Layout Optimization**: l'AI suggerisce layout migliori in base al contenuto
- [ ] **Predictive Prefetching**: caricamento anticipato delle risorse UI in base ai pattern di navigazione

### Checklist qualita'

- [x] PHPStan Level 10
- [ ] Accessibilita' WCAG 2.1 (AA) verificata su tutti i componenti core
- [ ] Performance Lighthouse > 90 su pagine UI intensive

## Panoramica del modulo

Il modulo **UI** e' il sistema di componenti e design system della piattaforma: una libreria di componenti riutilizzabili, conformi alle linee guida AGID e compatibili con Filament.

```
UI Module
├── Design System (core): componenti AGID, palette, tipografia, spaziatura
├── Component Library: form, layout, data, interattivi
├── Filament Integration: risorse, azioni, widget, personalizzazione tema
└── Responsive System: mobile, touch, breakpoint, orientamento
```

## Piano 2025 (storico)

### Funzionalita' completate

- **Design system**: componenti base AGID, palette AGID, tipografia, spaziatura, libreria icone, griglia responsive
- **Component library**: form (Input, Select, Checkbox, Radio, Textarea), layout (Header, Footer, Sidebar, Container), data (Table, List, Card, Badge), interattivi (Button, Modal, Dropdown, Tooltip), navigazione (Menu, Breadcrumb, Pagination), feedback (Alert, Notification, Loading)
- **Filament integration**: risorse, azioni e widget personalizzati, tema, componenti form e tabella
- **Responsive**: mobile-first, breakpoint, interfacce touch, gestione orientamento
- **Eccellenza tecnica**: PHPStan level 10 a zero errori, type hints completi, gestione errori, setup test, strumenti qualita' (PHPMD, PHPCS, Laravel Pint, Psalm, HTMLHint, Markdownlint, ESLint, Biome), pre-commit hooks e CI/CD

### In corso

**Completamento AGID** (priorita' critica, 85% completato, previsto Q1 2025)
- WCAG 2.1 AA completo: contrasto colori 4.5:1, indicatori di focus, ottimizzazione per screen reader, navigazione da tastiera, testi alternativi, associazione label dei form
- Libreria componenti AGID: header, footer, menu di navigazione, form, button, card
- Test di accessibilita': automatici, manuali, screen reader, solo tastiera, daltonismo, mobile
- Criteri di successo: WCAG 2.1 AA al 100%, tutti i componenti AGID implementati, test di accessibilita' superati

**Ottimizzazione mobile** (priorita' alta, 70% completato, previsto Q1 2025)
- Mobile-first: touch target minimo 44px, gesture, navigazione e form mobile, performance mobile
- Progressive Web App (media): manifest, service worker, offline, push, esperienza app-like
- Test cross-platform (media): iOS Safari, Android Chrome, responsive, performance
- Criteri di successo: usabilita' mobile > 90%, PWA completa, compatibilita' verificata

### Miglioramenti tecnici (priorita' alta)

- Copertura test: unit test per i model, feature test per le resource, integration test per le API, browser test per la UI
- Performance (media): ottimizzazione query, caching, memoria, tempi di risposta
- Obiettivi: copertura > 80%, risposta < 200ms, memoria < 50MB, zero problemi critici

### Metriche di successo

- Tecniche: PHPStan level 10 a zero errori (raggiunto), compatibilita' Filament 4.x (raggiunta), copertura 80%, risposta < 200ms, memoria < 50MB, uptime > 99.9%
- Business: adozione feature > 80%, soddisfazione utenti > 4.5/5, performance score > 90, error rate < 1%

### Piano trimestrale Q1 2025

- Gennaio: setup del modulo, funzionalita' di base, setup test
- Febbraio: funzionalita' avanzate, integration test, ottimizzazione, documentazione
- Marzo: test finali, deploy in produzione, formazione utenti, monitoraggio

### Obiettivi 2025

- Q1: funzionalita' core implementate, test di base completi, documentazione avviata, integrazioni funzionanti
- Fine anno: tutte le funzionalita' pianificate, copertura > 80%, performance ottimizzata, documentazione completa, pronto per la produzione, soddisfazione > 4.5/5

---

**Ultimo aggiornamento della sezione 2025**: 2025-10-01 (prossima revisione prevista 2025-11-01, stato "sviluppo attivo", confidenza 90%)
**Unione delle due versioni**: 2026-10-07

*Questa roadmap e' specifica per il modulo UI e va aggiornata in base ai progressi e alle nuove esigenze.*
