# Script analyze_modules.sh

## Descrizione
Lo script `analyze_modules.sh` esegue l'analisi PHPStan su tutti i moduli Laravel presenti nella cartella `laravel/Modules/`. Per ogni modulo, esegue l'analisi a tutti i livelli di PHPStan (da 1 a max) e salva i risultati in formato JSON nella cartella `docs/phpstan` di ogni modulo.

## Posizione
`/var/www/html/ptvx/bashscripts/analyze_modules.sh`

## Utilizzo
```bash
cd /var/www/html/ptvx
./bashscripts/analyze_modules.sh
```

## Funzionalità
1. Analizza tutti i moduli presenti in `laravel/Modules/`
2. Per ogni modulo:
   - Crea la cartella `docs/phpstan` se non esiste
   - Esegue PHPStan ai livelli: 1, 2, 3, 4, 5, 6, 7, 8, 9, max
   - Salva i risultati in `docs/phpstan/level_<n>.json`

## Struttura dei File di Output
Per ogni modulo, vengono creati i seguenti file:
```
Modules/<NomeModulo>/docs/phpstan/
├── level_1.json
├── level_2.json
├── level_3.json
├── level_4.json
├── level_5.json
├── level_6.json
├── level_7.json
├── level_8.json
├── level_9.json
└── level_max.json
```

## Dipendenze
- PHPStan installato in `laravel/vendor/bin/phpstan`
- Configurazione PHPStan in `laravel/phpstan.neon`

## Variabili di Ambiente
- `BASE_DIR`: Directory base del progetto (`/var/www/html/ptvx/laravel`)
- `MODULES_DIR`: Directory dei moduli (`$BASE_DIR/Modules`)
- `LEVELS`: Array dei livelli PHPStan da analizzare

## Best Practices
1. Eseguire lo script dalla root del progetto
2. Verificare che PHPStan sia installato correttamente
3. Assicurarsi di avere i permessi necessari per creare le cartelle
4. Monitorare lo spazio su disco durante l'esecuzione

## Note
- Lo script crea automaticamente le cartelle necessarie
- I risultati sono in formato JSON per facilitare l'analisi successiva
- Ogni livello di analisi può richiedere tempo diverso
- I file di output possono essere utilizzati per generare report dettagliati

## Esempio di Output
```json
{
    "totals": {
        "errors": 0,
        "file_errors": 0
    },
    "files": [],
    "errors": []
}
```

## Troubleshooting
1. Se lo script fallisce, verificare:
   - Permessi delle cartelle
   - Installazione di PHPStan
   - Configurazione di PHPStan
   - Spazio su disco disponibile

2. Errori comuni:
   - Directory non trovata
   - Permessi insufficienti
   - PHPStan non installato
   - Configurazione PHPStan errata 