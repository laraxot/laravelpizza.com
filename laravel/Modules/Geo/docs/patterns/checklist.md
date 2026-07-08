# 📋 Checklist Pattern

> **CHECKLIST PATTERN**: Liste di controllo standardizzate per garantire la qualità del codice.

## 🎯 Scopo

Le checklist servono a:
- ✅ Ridurre errori umani
- ✅ Garantire consistenza
- ✅ Documentare i requisiti non funzionali
- ✅ Facilitare la code review

## 🏗️ Checklists

### Repository Pattern
- [ ] Interface definita con metodi chiari
- [ ] Implementazione con tipizzazione rigorosa
- [ ] Metodi per operazioni CRUD base
- [ ] Metodi per query complesse
- [ ] Eager loading per relazioni

### Service Pattern
- [ ] Logica di business centralizzata
- [ ] Dependency injection per repository
- [ ] Gestione eventi e notifiche
- [ ] Validazione e gestione errori
- [ ] Transazioni database quando necessario

### Action Pattern
- [ ] Estende Spatie QueueableAction
- [ ] Metodo execute con tipizzazione
- [ ] Gestione errori appropriata
- [ ] Notifiche quando necessario
- [ ] Possibilità di accodamento

### Data Pattern
- [ ] Estende Spatie Laravel Data
- [ ] Attributi di validazione appropriati
- [ ] Metodi fromModel e toModel
- [ ] Tipizzazione rigorosa
- [ ] Immutabilità garantita

### Filament Pattern
- [ ] Estende classi base Xot
- [ ] Metodi get*Schema implementati
- [ ] Traduzioni tramite file (no ->label())
- [ ] Azioni personalizzate in setUp()
- [ ] Testing appropriato

---
**Vedi anche**: [Action Pattern](./action.md), [Repository Pattern](./repository.md)
