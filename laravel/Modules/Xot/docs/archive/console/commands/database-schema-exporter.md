# DatabaseSchemaExporter Command Documentation

## Overview
Il comando `database:schema-exporter` esporta lo schema del database, fornendo una panoramica completa della struttura del database.

## Caratteristiche

### Funzionalità Principali
- Estrazione elenco tabelle dal database
- Supporto per connessione MySQL
- Gestione errori robusta
- Output formattato per la console

### Parametri
```bash
php artisan database:schema-exporter
```

### Output
- Lista delle tabelle trovate
- Messaggi di errore dettagliati in caso di problemi
- Codici di ritorno standard di Laravel (SUCCESS/FAILURE)

## Implementazione

### Metodi Principali
- `handle()`: Punto di ingresso del comando
- `getTables()`: Recupera l'elenco delle tabelle
  - Validazione configurazione database
  - Query sicura per elenco tabelle
  - Mappatura risultati

### Sicurezza
- Validazione stringhe con Assert
- Gestione eccezioni
- Controlli configurazione database

## Utilizzo
```bash

# Esportazione schema database
php artisan database:schema-exporter

# Output esempio
Tabelle trovate: users, migrations, password_resets
```

## Recent Changes
- Rimossi conflitti di merge
- Migliorata la gestione degli errori
- Aggiunta validazione input
- Ottimizzata la query di estrazione tabelle 

## Collegamenti tra versioni di database-schema-exporter.md
* [database-schema-exporter.md](../../../Xot/project_docs/commands/database-schema-exporter.md)
* [database-schema-exporter.md](../../../Xot/project_docs/console/commands/database-schema-exporter.md)

