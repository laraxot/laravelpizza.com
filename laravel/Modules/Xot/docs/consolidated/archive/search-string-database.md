# SearchStringInDatabaseCommand

## Descrizione
Questo comando permette di cercare una stringa specifica all'interno del database, attraverso tutte le tabelle e colonne.

## Utilizzo
```bash
php artisan xot:search-string-in-database {search_string} {--table=} {--column=}
```

### Parametri
- `search_string`: La stringa da cercare (obbligatorio)
- `--table`: Filtra la ricerca per una tabella specifica (opzionale)
- `--column`: Filtra la ricerca per una colonna specifica (opzionale)

## Funzionalità
1. Ricerca case-insensitive in tutto il database
2. Supporto per filtri su tabelle e colonne specifiche
3. Output formattato dei risultati
4. Gestione ottimizzata delle query
5. Supporto per diversi tipi di colonne

## Best Practices
1. Utilizzo di strict types
2. Gestione errori robusta
3. Query ottimizzate per performance
4. Supporto per PHPStan livello 9
5. Conforme alle convenzioni Laraxot/<nome progetto>

## Collegamenti
- [Database Guidelines](../DATABASE-GUIDELINES.md)
- [Performance Guidelines](../performance/database-queries.md)
- [PHPStan level 10 Guide](../PHPSTAN-LEVEL9-GUIDE.md) 