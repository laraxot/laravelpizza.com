# GenerateDbDocumentationCommand

## Descrizione
Questo comando genera documentazione dettagliata dello schema del database in formato Markdown.

## Utilizzo
```bash
php artisan xot:generate-db-documentation {schema_file} {output_dir?}
```

### Parametri
- `schema_file`: Percorso del file schema JSON (obbligatorio)
- `output_dir`: Directory di output per i file markdown (opzionale, default: docs/database)

## Funzionalità
1. Genera documentazione completa del database
2. Crea file markdown per ogni tabella
3. Genera diagrammi ER usando Mermaid
4. Documenta relazioni tra tabelle
5. Supporta indici e chiavi esterne

## Output
- `README.md`: Indice principale con panoramica del database
- File separati per ogni tabella con:
  - Struttura delle colonne
  - Chiavi primarie
  - Indici
  - Relazioni
  - Statistiche

## Best Practices
1. Utilizzo di strict types
2. Gestione errori robusta
3. Documentazione PHPDoc completa
4. Supporto per PHPStan livello 9
5. Conforme alle convenzioni Laraxot/<nome progetto>

## Collegamenti
- [Database Guidelines](../DATABASE-GUIDELINES.md)
- [Documentation Guidelines](../DOCUMENTATION-GUIDELINES.md)
- [PHPStan level 10 Guide](../PHPSTAN-LEVEL9-GUIDE.md) 