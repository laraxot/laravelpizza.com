# Task: Creare Test Suite Completa - Meetup

**Modulo**: Meetup
**Priorita'**: Critica
**Completamento**: 0%

---

## Descrizione

Il modulo Meetup ha ZERO file di test. Essendo il modulo core business, e' critico avere copertura test.

## Test da Creare

### Unit Tests
- [ ] Event model: creazione, validazione, stati
- [ ] Registration model: RSVP, capacita', waitlist
- [ ] Speaker model: profilo, eventi associati

### Feature Tests
- [ ] Creazione evento via Filament
- [ ] Registrazione utente ad evento
- [ ] Cancellazione registrazione
- [ ] Lista eventi prossimi
- [ ] Dettaglio evento

### Integration Tests
- [ ] Flusso completo: crea evento -> registra utente -> notifica
- [ ] Integrazione con Notify per invii email
- [ ] Integrazione con Geo per venue

## Criteri di Completamento

- [ ] 15+ test files creati
- [ ] Copertura modelli al 80%
- [ ] Copertura actions al 60%
- [ ] Tutti i test passano
