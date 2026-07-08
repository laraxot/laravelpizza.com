# Regole Environment Development vs Testing in Laraxot

## Panoramica
In Laraxot è fondamentale comprendere la differenza tra le configurazioni di ambiente di sviluppo e di test, specialmente riguardo all'uso dei database.

## Configurazione per Sviluppo (.env.development)

### Database
- `DB_CONNECTION=sqlite`: Usa SQLite per setup immediato
- `DB_DATABASE=$PROJECT_ROOT/database/database.sqlite`: Percorso al database
- Questa configurazione è corretta per lo sviluppo perché:
  - Permette di iniziare immediatamente senza setup database
  - È ideale per sviluppo locale rapido
  - Non richiede configurazioni aggiuntive

### Altre Impostazioni
- `CACHE_DRIVER=array`: Caching in memoria (non persistente)
- `QUEUE_CONNECTION=sync`: Esecuzione immediata delle code
- `MAIL_MAILER=log`: Logging email invece di invio reale
- `SESSION_DRIVER=array`: Sessioni in memoria (non persistenti)

## Configurazione per Test (.env.testing)

### Database
- `DB_CONNECTION=mysql`: Usa MySQL per i test
- Database con suffisso "_test" (es. `healthcare_app_data_test`, `healthcare_app_user_test`)
- **MAI** usare SQLite per i test, nemmeno per convenienza

### Motivazione
La configurazione di test richiede MySQL perché:
- Garantisce corretto isolamento multi-tenant
- Supporta tutte le funzionalità richieste per i test
- Mantiene l'integrità dell'architettura multi-database
- Permette test accurati delle funzionalità specifiche del sistema

## Best Practices

### Per gli Sviluppatori
- Usa `.env.development` per lavoro quotidiano
- Usa `.env.testing` per esecuzione test
- Non modificare mai la configurazione di test per usare SQLite
- Rispetta sempre la configurazione definita nei file .env

### Per i Test
- Assicurati che i test utilizzino la configurazione corretta
- Non forzare connessioni SQLite nei test
- Usa `DatabaseTransactions` invece di `RefreshDatabase`
- Verifica che i dati siano correttamente isolati per tenant

## Conformità con Architettura Laraxot

Questa differenziazione rispetta i principi fondamentali:
- **DRY**: Configurazioni separate per scopi diversi
- **KISS**: Semplicità per sviluppo, completezza per test
- **Robustezza**: Isolamento adeguato nei test
- **Multi-tenancy**: Supporto completo per architettura multi-database