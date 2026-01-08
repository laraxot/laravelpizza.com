# Comandi di Importazione MDB

## Panoramica
Questi comandi permettono l'importazione di database Microsoft Access (MDB) in MySQL o SQLite.

## Comandi Disponibili

### ImportMdbToMySQL
- Importa un database MDB in MySQL
- Supporta la conversione dei tipi di dati
- Gestisce le relazioni tra tabelle
- Mantiene l'integrità referenziale

### ImportMdbToSQLite
- Importa un database MDB in SQLite
- Ottimizzato per database più piccoli
- Supporta la migrazione dei dati
- Gestisce le chiavi esterne

## Parametri Comuni
- `source`: Percorso del file MDB sorgente
- `destination`: Configurazione del database di destinazione
- `tables`: Lista opzionale di tabelle da importare
- `skip-data`: Opzione per saltare l'importazione dei dati

## Best Practices
- Verificare la compatibilità dei tipi di dati
- Eseguire backup prima dell'importazione
- Testare su un ambiente di sviluppo
- Documentare le conversioni effettuate

## Recenti Modifiche
- Migliorata la gestione degli errori
- Aggiunto supporto per più versioni di Access
- Ottimizzata la conversione dei tipi di dati
- Standardizzazione dei messaggi in italiano 