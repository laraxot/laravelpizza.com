# Checklist Qualità Modulo Activity

## Codice e architettura

- [x] PHPStan Level 10 su tutto il modulo.
- [ ] Rimozione sistematica di file obsoleti e duplicati.
- [ ] Nessuna dipendenza circolare verso altri moduli core.
- [ ] Documentazione chiara delle convenzioni di logging e degli eventi di dominio.

## Testing

- [ ] Copertura test Pest > soglia definita per moduli core (idealmente > 90%).
- [ ] Test di integrazione per i flussi principali di audit (creazione, aggiornamento, cancellazione).
- [ ] Test che verificano la corretta anonimizzazione o mascheramento di dati sensibili, dove previsto.

## Osservabilità

- [ ] Dashboard di monitoraggio (Filament) disponibile almeno in ambiente admin.
- [ ] Log strutturati e facilmente filtrabili per modulo, utente, tenant, tipo evento.
- [ ] Eventuali esportazioni (CSV/JSON) documentate e coperte da test.

