# Comando DatabaseSchemaExport

## Panoramica
Il comando `DatabaseSchemaExportCommand` esporta lo schema del database in formato JSON, utile per la generazione di modelli e documentazione.

## Caratteristiche Principali
- Esportazione completa dello schema del database
- Supporto per MySQL e SQLite
- Generazione di JSON strutturato
- Gestione delle relazioni tra tabelle
- Esportazione di indici e vincoli

## Parametri
- `connection`: Nome della connessione al database
- `output`: Percorso del file di output
- `tables`: Lista opzionale di tabelle da esportare
- `format`: Formato di output (default: json)

## Struttura Output
```json
{
  "database": "nome_database",
  "tables": {
    "nome_tabella": {
      "columns": {...},
      "indexes": {...},
      "foreign_keys": {...}
    }
  }
}
```

## Best Practices
- Utilizzare connessioni dedicate per l'esportazione
- Verificare i permessi di accesso
- Documentare le modifiche allo schema
- Mantenere backup degli schemi

## Recenti Modifiche
- Migliorata la gestione degli errori
- Aggiunto supporto per più tipi di database
- Ottimizzata la struttura JSON
- Standardizzazione dei messaggi in italiano 