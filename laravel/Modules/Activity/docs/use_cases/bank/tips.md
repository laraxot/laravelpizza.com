# Consigli e Best Practice - Use Case Bancario

## Refactoring e Miglioramenti
- Separare comandi e query (CQRS)
- Usare aggregate per la logica di dominio
- Validare input sia lato comando che evento
- Implementare proiezioni per query efficienti
- Usare snapshot per velocizzare il replay
- Integrare fallback su activitylog per audit trail
- Gestire la concorrenza sugli aggregate

## Checklist di Implementazione
- [ ] Definire eventi e comandi principali
- [ ] Implementare aggregate Account, Transaction
- [ ] Gestire proiezioni e query
- [ ] Scrivere test per ogni evento/aggregate
- [ ] Documentare i flussi principali
- [ ] Prevedere rollback e replay

## Errori Comuni
- Non validare input lato comando
- Non gestire la concorrenza sugli aggregate
- Dimenticare il rollback in caso di errore
- Non tracciare tutte le operazioni per audit

## Risorse di Approfondimento
- [Larabank Eventsauce (Spatie)](https://github.com/spatie/larabank-eventsauce)
- [Larabank Projectors (Spatie)](https://github.com/spatie/larabank-projectors)
- [Larabank Traditional (Spatie)](https://github.com/spatie/larabank-traditional) 
