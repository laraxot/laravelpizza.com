# Comando GenerateModelsFromSchema

## Panoramica
Il comando `GenerateModelsFromSchemaCommand` genera modelli Laravel a partire da uno schema del database definito in formato JSON.

## Caratteristiche Principali
- Generazione automatica di modelli Eloquent
- Supporto per relazioni polimorfiche
- Gestione dei tipi di dati SQL
- Generazione di migrazioni opzionale
- Validazione dello schema JSON
- Gestione degli errori robusta

## Parametri
- `schema_file`: Percorso del file schema JSON
- `namespace`: Namespace dei modelli (es. Modules\\Brain\\Models)
- `model_path`: Percorso dove salvare i modelli
- `migration_path`: Percorso opzionale per le migrazioni

## Tipi di Dati Supportati
- Tipi numerici: int, tinyint, smallint, mediumint, bigint, float, double, decimal
- Tipi stringa: char, varchar, tinytext, text, mediumtext, longtext
- Tipi JSON e binari: json, binary, varbinary, blob
- Tipi data/ora: date, datetime, timestamp, time
- Altri tipi: enum, set, bit

## Best Practices
- Utilizzare namespace appropriati per i modelli
- Verificare la validità dello schema JSON prima dell'esecuzione
- Mantenere una struttura coerente delle directory
- Documentare le relazioni tra i modelli

## Recenti Modifiche
- Migliorata la gestione degli errori
- Aggiunto supporto per tipi di dati aggiuntivi
- Ottimizzata la generazione delle relazioni
- Aggiunta validazione dello schema JSON
- Standardizzazione dei messaggi in italiano 