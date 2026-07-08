# Esecuzione PHPStan

## Configurazione

PHPStan è configurato per essere eseguito dalla cartella principale del progetto Laravel:

```bash
cd /var/www/html/_bases/base_ptvx_fila5/laravel
```

## Esecuzione

Per eseguire l'analisi statica del codice:

```bash
./vendor/bin/phpstan
```

## Livelli di Analisi

PHPStan supporta diversi livelli di analisi (0-9). Il livello predefinito è 1.

Per specificare un livello diverso:

```bash
./vendor/bin/phpstan --level=5
```

## Analisi di File Specifici

Per analizzare file o directory specifiche:

```bash
./vendor/bin/phpstan analyse app/Filament
```

## Output

L'output includerà:
- Numero di errori trovati
- Dettagli degli errori con file e riga
- Suggerimenti per la correzione

## Note
- Assicurarsi di essere nella directory corretta prima di eseguire PHPStan
- Verificare che tutte le dipendenze siano installate
- Considerare l'uso di `--xdebug` per analisi più dettagliate 