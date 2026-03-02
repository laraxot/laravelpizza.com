# Roadmap Modulo Lang

## 🎯 Visione
Trasformare la gestione linguistica in un servizio intelligente e universale, capace non solo di fornire traduzioni statiche ma di generare e gestire contenuti multilingue on-the-fly tramite AI, mantenendo la coerenza del brand.

## 🏗️ Fasi di Sviluppo

### Fase 1: Stabilità e Pulizia (In Corso)
- [x] PHPStan Level 10 Compliance.
- [ ] Rimozione sistematica di file obsoleti e ridondanti.
- [ ] Centralizzazione della gestione dei file di lingua dei moduli.
- [ ] Automazione completa della pubblicazione delle traduzioni (`lang:publish`).

### Fase 2: Developer Experience (Pianificato)
- [ ] CLI interattiva per la gestione rapida delle chiavi di traduzione.
- [ ] Sistema di warning durante la build per chiavi mancanti.
- [ ] Integrazione con i Cluster di Filament per la gestione dei permessi lingua.

### Fase 3: Ottimizzazione e AI (Futuro)
- [ ] **AI-AutoTranslate**: Traduzione basata su contesto tramite LLM preservando le chiavi.
- [ ] **Translation Memory**: Database condiviso delle traduzioni approvate per uniformità terminologica.
- [ ] Supporto avanzato per la pluralizzazione in lingue complesse.

## ✅ Checklist Qualità
- [x] PHPStan Level 10.
- [ ] Assenza di hardcoded strings nei layout Blade.
- [ ] Test di risoluzione delle chiavi multilingue per ogni modulo.
- [ ] Documentazione centralizzata in `docs/`.
