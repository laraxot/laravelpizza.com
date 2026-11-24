# Task: Aumentare Copertura Test User

**Modulo**: User  
**Fase**: 2 - Testing e Qualità  
**Priorità**: Media  
**Stima**: 10-15 ore

## Obiettivo

Portare la copertura test del modulo User da ~85% a > 95%.

## Sottotask

- [ ] Test unitari per tutti i Models
- [ ] Test feature per Actions
- [ ] Test integration per Resources Filament
- [ ] Test widget authentication (Login, Register, Logout)
- [ ] Test team management
- [ ] Test permission system

## Dipendenze

Fase 1 (Correzione violazioni architetturali) completata.

## Note

- Non usare RefreshDatabase; usare DatabaseTransactions o .env.testing con MySQL _test.
- Usare XotData::make()->getUserClass() per modello User nei test.

## Collegamenti

- [Roadmap User](../roadmap.md)
- [Indice task User](tasks-index.md)
- [Testing Guidelines](../testing-guidelines.md)
