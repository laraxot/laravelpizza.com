# Bank Use Case: Approcci Event Sourcing e Tradizionale

## Introduzione
Questo documento confronta tre approcci all'implementazione di un sistema bancario:
- **Approccio Tradizionale** (CRUD)
- **Event Sourcing con Projectors**
- **Event Sourcing con Eventsauce**

L'obiettivo è fornire una panoramica neutra e riutilizzabile dei pattern, dei vantaggi e delle criticità, con esempi e riferimenti pratici.

## Attori Principali
- **Utente**: gestisce il proprio conto, effettua depositi, prelievi, trasferimenti
- **Sistema**: processa le operazioni, mantiene lo storico
- **Revisore**: verifica audit trail e integrità

## Glossario
- **Account**: conto bancario
- **Transaction**: operazione (deposito, prelievo, trasferimento)
- **Aggregate**: oggetto che incapsula la logica di dominio e lo stato
- **Event**: rappresentazione immutabile di un cambiamento di stato
- **Projector**: componente che aggiorna proiezioni leggibili a partire dagli eventi

## Collegamenti correlati
- [Prediction Market](../prediction_market/README.md)
- [Event Sourcing & CQRS](../event_sourcing_cqrs/README.md)
- [Audit Log](../audit_log/README.md)
- [Workflow Approval](../workflow_approval/README.md)
- [Task Management](../task_management/README.md)

## Panoramica degli Approcci

### 1. Approccio Tradizionale (CRUD)
- Stato salvato direttamente nel database
- Ogni operazione aggiorna lo stato attuale
- Audit trail limitato (richiede log manuali)
- Semplice da implementare, difficile da estendere

### 2. Event Sourcing con Projectors
- Ogni operazione genera un evento persistito
- Lo stato attuale è una proiezione degli eventi
- Projectors aggiornano viste leggibili (es. saldo, storico)
- Audit trail completo, facile rollback
- Più complesso, ma molto flessibile

### 3. Event Sourcing con Eventsauce
- Simile ai projectors, ma con una libreria dedicata (Eventsauce)
- Gestione avanzata di aggregate, snapshot, replay
- Maggiore automazione e coerenza
- Ideale per sistemi complessi e ad alta tracciabilità

## Vantaggi e Limiti
- **Tradizionale**: semplice, ma poco auditabile
- **Projectors**: audit completo, maggiore complessità
- **Eventsauce**: massima tracciabilità, richiede conoscenza avanzata dei pattern

## Quando scegliere quale approccio?
- **Tradizionale**: sistemi semplici, pochi requisiti di audit
- **Projectors/Eventsauce**: sistemi critici, necessità di audit, rollback, proiezioni avanzate

## Prossimi passi
Consulta i file flow.md, domain_model.md, examples.md e tips.md per dettagli su flussi, modelli, esempi e best practice. 
