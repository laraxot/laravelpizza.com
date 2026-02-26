# InformationSchemaTable

## Descrizione
Questa classe modella la tabella `information_schema.tables` del database, fornendo funzionalità per l'analisi e la gestione dello schema del database.

## Struttura
```php
class InformationSchemaTable extends Model
{
    protected $table = 'information_schema.tables';
    protected $connection = 'mysql';
    public $timestamps = false;
}
```

## Funzionalità
1. Accesso alle informazioni dello schema del database
2. Supporto per:
   - Lettura struttura tabelle
   - Analisi colonne
   - Gestione indici
   - Chiavi esterne
3. Integrazione con:
   - Database Schema Exporter
   - Documentation Generator
   - Migration Generator

## Attributi
- `table_schema`: Nome del database
- `table_name`: Nome della tabella
- `engine`: Engine della tabella
- `table_rows`: Numero approssimativo di righe
- `data_length`: Dimensione dei dati
- `table_comment`: Commento della tabella

## Best Practices Implementate
1. Utilizzo di strict types
2. Gestione efficiente delle query
3. Caching appropriato
4. Supporto per PHPStan livello 9
5. Conforme alle convenzioni Laraxot/<nome progetto>

## Collegamenti
- [Database Guidelines](../DATABASE-GUIDELINES.md)
- [Schema Documentation](../DIRECTORY-STRUCTURE-GUIDE.md)
- [PHPStan level 10 Guide](../PHPSTAN-LEVEL9-GUIDE.md)
- [Model Best Practices](../models/README.md) 