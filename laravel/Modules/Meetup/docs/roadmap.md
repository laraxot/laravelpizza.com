# Roadmap Modulo Meetup

## 🎯 Obiettivo
Replicare laravelpizza.com all'interno del framework Laraxot con frontend Tailwind/Vite, backend modulare e integrazione MCP.

---
## Fase 1 · Fondamenta Backend (Settimana 1)
1. **Struttura Database**
   - [ ] Creare migrazioni per tabelle `meetup_*`
   - [ ] Popolare seeders demo (pizze, categorie, ordini)
   - [ ] Factory per testing rapido
2. **Modelli & Servizi**
   - [ ] Implementare modelli Eloquent (Pizza, Category, Ingredient, Order, OrderItem)
   - [ ] Codificare `PizzaService`, `OrderService`, `CartService`
   - [ ] Unit test per servizi core

### Deliverable
- Schema dati attivo
- Seed demo
- Servizi funzionanti
- Test unitari base

---
## Fase 2 · Interfaccia Pubblica (Settimana 2)
1. **Blade Views**
   - [ ] Portare HTML Tailwind in Blade riutilizzabili (`layouts/app`, `components/*`)
   - [ ] Collegare dati reali (pizze, categorie, ordini)
2. **Routing & Controller**
   - [ ] Rotte pubbliche (home, menu, contatti, carrello)
   - [ ] Controller dedicati + binding servizi
3. **Componenti Interattivi**
   - [ ] Livewire/Volt per carrello, filtri, form ordine
   - [ ] Validazioni e feedback utente

### Deliverable
- Tema Laravel funzionante
- Carrello dinamico
- UX coerente con HTML statico

---
## Fase 3 · Admin & Gestione (Settimana 3)
1. **Filament**
   - [ ] `PizzaResource`, `CategoryResource`, `OrderResource`
   - [ ] Widget statistiche (ordini giorno, top pizze)
2. **Notifiche & Workflow**
   - [ ] Integrazione Notify per conferme ordine
   - [ ] Stato ordine (pending → delivered)
3. **Testing**
   - [ ] Feature test rotte pubbliche
   - [ ] Filament resource test
   - [ ] Browser test (puppeteer MCP)

### Deliverable
- Backoffice completo
- Workflow ordini
- Suite test base

---
## Fase 4 · Rifinitura & Documentazione (Settimana 4)
1. **Docs & Guide**
   - [ ] Guida installazione modulo/tema
   - [ ] Style guide UI (palette, componenti)
   - [ ] Workflow MCP (filesystem, puppeteer, sequential-thinking)
2. **Performance & Accessibilità**
   - [ ] Ottimizzazione immagini/assets
   - [ ] Lighthouse audit
   - [ ] Accessibilità (focus, aria-labels)
3. **Deployment Ready**
   - [ ] Build Vite + versionamento
   - [ ] Configurare env per produzione (cache, queue)
   - [ ] Changelog iniziale

### Deliverable
- Documentazione completa
- UI/UX rifinita
- Build pronta al deploy

---
## Checklist Trasversale
- [ ] **Strict Compliance**: No Controllers, No property_exists, Folio+Volt for Front, Filament+XotBase for Back.
- [ ] Traduzioni (`lang/it/meetup.php`)
- [ ] Logica multi-tenant (config `local/laravelpizza`)
- [ ] Integrazione MCP (filesystem, memory, fetch, sequential-thinking, puppeteer)
- [ ] Monitoraggio (eventuale Sentry/Log)

---
## Metriche di Successo
- Tempo medio ordine < 30s (UX)
- Copertura test ≥ 60% sui servizi core
- Lighthouse: Performance ≥ 90, Accessibilità ≥ 90
- Documentazione aggiornata (docs modulo + tema)

---
## Prossimi Step Immediati
1. Approvare roadmap
2. Assegnare owner per ogni fase
3. Creare branch dedicato (`feature/meetup-phase1`)
4. Avviare fase 1 (migrazioni + seeders)
