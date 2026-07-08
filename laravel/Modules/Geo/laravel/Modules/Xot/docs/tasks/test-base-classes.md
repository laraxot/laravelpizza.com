# Task: Test Base Classes

**Modulo**: Xot  
**Fase**: 2 - Testing e Qualità  
**Priorità**: Alta  
**Stima**: 15-20 ore

## Obiettivo

Testare tutte le classi base del modulo Xot per aumentare la copertura (attualmente ~5%).

## Sottotask

- [ ] Test XotBaseModel
- [ ] Test XotBaseResource
- [ ] Test XotBaseWidget
- [ ] Test XotBasePage
- [ ] Test XotBaseServiceProvider
- [ ] Test trait principali (HasXotTable, HasUuid, ecc.)

## Dipendenze

Fase 1 (Completamento Funzionalità Core) completata.

## Note

- Non usare RefreshDatabase; usare DatabaseTransactions o .env.testing con MySQL _test.
- Usare XotData::make()->getUserClass() dove serve modello User.

## Collegamenti

- [Roadmap Xot](roadmap.md)
- [Lista task Xot](tasks-index.md)
- [Database Testing Rule](database-testing-rule.md)
