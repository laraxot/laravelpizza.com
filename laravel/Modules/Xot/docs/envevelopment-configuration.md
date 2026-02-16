# Configurazione .env Development in Laraxot

## Panoramica
Il file `.env.development` nel progetto Laraxot è configurato in modo appropriato per fornire un ambiente di sviluppo immediato e senza complicazioni.

## Configurazione Specifica

### Database
- **DB_CONNECTION=sqlite**: Utilizza SQLite per lo sviluppo locale immediato
- **DB_DATABASE=$PROJECT_ROOT/database/database.sqlite**: Percorso al database SQLite
- Questa configurazione è corretta per lo sviluppo perché:
  - Non richiede setup aggiuntivi di database
  - Permette di iniziare a lavorare immediatamente
  - È ideale per test rapidi e sviluppo locale

### Altre Configurazioni
- **CACHE_DRIVER=array**: Usa array per il caching (non persistente)
- **QUEUE_CONNECTION=sync**: Sincrono per le code (esecuzione immediata)
- **MAIL_MAILER=log**: Logga le email invece di inviarle
- **SESSION_DRIVER=array**: Sessioni in array (non persistenti)
- Queste impostazioni sono ottimali per lo sviluppo perché semplificano il setup

## Importante Differenza con i Test
⚠️ **Attenzione**: La configurazione di sviluppo è diversa da quella dei test:
- Per **sviluppo** (ambiente reale): `.env.development` usa SQLite
- Per **test**: `.env.testing` deve usare MySQL con database suffissi "_test"
- Questa differenza è necessaria perché:
  - I test richiedono isolamento multi-tenant
  - MySQL è richiesto per la struttura multi-database
  - SQLite non supporta tutte le funzionalità necessarie per i test multi-tenant

## Best Practices
- Usa `.env.development` per sviluppo veloce
- Usa `.env.testing` per esecuzione test con MySQL
- Non usare mai SQLite per i test, anche per convenienza
- Mantieni le configurazioni separate per ogni ambiente

## Conformità con Architettura Laraxot
Questa configurazione è in linea con i principi DRY + KISS:
- Semplicità per lo sviluppo locale
- Separazione chiara tra ambienti
- Configurazione appropriata per ogni scopo