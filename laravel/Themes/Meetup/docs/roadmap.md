# Roadmap Tema Meetup (Tailwind + Vite)

## 🎯 Obiettivo
Trasformare la versione HTML statica in un tema Laravel completo, mantenendo stile Tailwind, build Vite e integrazione MCP.

---
## Fase 1 · Consolidare risorse HTML (Settimana 1)
- [ ] Completare pagine mancanti (`about.html`, `components.html` → Blade)
- [ ] Estrarre componenti riutilizzabili (card pizza, CTA, form)
- [ ] Definire style guide (palette, tipografia, spacing)
- [ ] Documentare best practices Tailwind

### Output
- Cartella `resources/html/` completa
- `components.html` con snippet riusabili
- Documentazione UI aggiornata

---
## Fase 2 · Integrazione Vite & Tailwind (Settimana 2)
- [ ] Configurare build dedicata (`build-meetup`)
- [ ] Alias percorsi (`@theme`) per assets
- [ ] Configurare Tailwind content paths per Blade + HTML
- [ ] Setup script npm (`dev`, `build`, `preview`)

### Output
- `vite.config.js` stabilizzato
- `tailwind.config.js` con palette Meetup
- Pipeline pronta per `npm run dev/build`

---
## Fase 3 · Porting in Blade (Settimana 3)
- [ ] Layout base (`layouts/app.blade.php`)
- [ ] Partials (header, footer, hero, CTA)
- [ ] Pagine dinamiche (`home`, `menu`, `contact`, `cart`)
- [ ] Collegamento con dati reali (componenti Livewire/Volt)

### Output
- Tema attivabile via `XotData::make()->pub_theme`
- Carrello dinamico + filtri
- Supporto multi-lingua (stringhe in `lang/it/`)

---
## Fase 4 · UX & Accessibilità (Settimana 4)
- [ ] Test responsive con puppeteer MCP
- [ ] Verifica contrasto e focus states
- [ ] Migliorare micro-animazioni e feedback utente
- [ ] Documentare pattern UI (notes.md → style guide ufficiale)

### Output
- UI conforme a WCAG AA
- Report screenshot devices principali
- Style guide consolidata

---
## Fase 5 · Deployment & Manutenzione
- [ ] Build produzione e versionamento assets
- [ ] Script publish tema (separare assets dal core)
- [ ] Changelog tema
- [ ] Monitoraggio performance (Lighthouse + analitiche)

---
## Checklist Trasversale
- [ ] Favicon e meta tags aggiornati
- [ ] Placeholder immagini sostituiti con assets reali
- [ ] Script carrello integrato con backend
- [ ] Supporto Dark Mode (opzionale)
- [ ] Documentazione setup (`resources/html/README.md`, `notes.md`)

---
## Prossimi Step
1. Validare roadmap con team backend
2. Avviare Phase 1 → completamento HTML/Blade
3. Assegnare owner per Tailwind/Vite vs Blade/Livewire
4. Integrare risultati in docs modulo meetup (collegamenti incrociati)
