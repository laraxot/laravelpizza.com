# DatabaseSchemaExporterCommand

## Descrizione
Questo comando esporta lo schema del database in formato JSON, includendo dettagli su tabelle, colonne, indici e relazioni.

## Utilizzo
```bash
php artisan xot:export-db-schema {output_file?} {--tables=*}
```

### Parametri
- `output_file`: Percorso del file di output JSON (opzionale, default: database/schema.json)
- `--tables`: Filtra l'esportazione per tabelle specifiche (opzionale)

## Funzionalità
1. Esportazione dello schema completo del database
2. Supporto per filtri su tabelle specifiche
3. Documentazione di:
   - Struttura delle tabelle
   - Tipi di colonne
   - Indici e chiavi
   - Relazioni tra tabelle
4. Formato JSON strutturato e leggibile

## Output
Il file JSON generato contiene:
```json
{
    "database": "nome_database",
    "connection": "mysql",
    "tables": {
        "nome_tabella": {
            "columns": {},
            "indexes": {},
            "foreign_keys": {},
            "record_count": 0
        }
    },
    "relationships": []
}
```

## Best Practices
1. Utilizzo di strict types
2. Gestione errori robusta
3. Query ottimizzate per performance
4. Supporto per PHPStan livello 9
5. Conforme alle convenzioni Laraxot/<nome progetto>

## Collegamenti
- [Database Guidelines](../DATABASE-GUIDELINES.md)
- [Schema Documentation](../DIRECTORY-STRUCTURE-GUIDE.md)
- [PHPStan Level 9 Guide](../PHPSTAN-LEVEL9-GUIDE.md)
## Collegamenti tra versioni di database-schema-exporter.md
* [database-schema-exporter.md](../../../Xot/docs/commands/database-schema-exporter.md)
* [database-schema-exporter.md](../../../Xot/docs/console/commands/database-schema-exporter.md)

