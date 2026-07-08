# Script analyze_modules.sh

## Descrizione
Lo script `analyze_modules.sh` esegue l'analisi PHPStan su tutti i moduli Laravel presenti nella cartella `laravel/Modules/`. Per ogni modulo, esegue l'analisi a tutti i livelli di PHPStan (da 1 a max) e salva i risultati in formato JSON nella cartella `docs/phpstan` di ogni modulo.

## Posizione



`/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/analyze_modules.sh`

## Utilizzo
```bash
cd /var/www/html/_bases/base_ptvx_fila5_mono


`/var/www/html/ptvx/bashscripts/analyze_modules.sh`

## Utilizzo
```bash
cd /var/www/html/ptvx


`/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/analyze_modules.sh`

## Utilizzo
```bash
cd /var/www/html/_bases/base_ptvx_fila5_mono



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
- `BASE_DIR`: Directory base del progetto (`/var/www/html/_bases/base_ptvx_fila5_mono/laravel`)
- `BASE_DIR`: Directory base del progetto (`/var/www/html/ptvx/laravel`)

- `BASE_DIR`: Directory base del progetto (`/var/www/html/_bases/base_ptvx_fila5_mono/laravel`)


- `BASE_DIR`: Directory base del progetto (`/var/www/html/ptvx/laravel`)
- `BASE_DIR`: Directory base del progetto (`/var/www/html/_bases/base_ptvx_fila5_mono/laravel`)
- `BASE_DIR`: Directory base del progetto (`/var/www/html/_bases/base_ptvx_fila5_mono/laravel`)

- `BASE_DIR`: Directory base del progetto (`/var/www/html/ptvx/laravel`)

- `BASE_DIR`: Directory base del progetto (`/var/www/html/_bases/base_ptvx_fila5_mono/laravel`)



- `BASE_DIR`: Directory base del progetto (`/var/www/html/_bases/base_ptvx_fila5_mono/laravel`)

- `BASE_DIR`: Directory base del progetto (`/var/www/html/_bases/base_ptvx_fila5_mono/laravel`)
- `BASE_DIR`: Directory base del progetto (`/var/www/html/ptvx/laravel`)
- `BASE_DIR`: Directory base del progetto (`/var/www/html/_bases/base_ptvx_fila5_mono/laravel`)
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











## Gestione dei Conflitti
In caso di conflitti durante l'analisi dei moduli:
1. Verificare che non ci siano modifiche non committate
2. Eseguire `git status` per identificare i file in conflitto
3. Risolvere i conflitti manualmente seguendo le linee guida in [CONFLICT_RESOLUTION.md](../../docs/development/CONFLICT_RESOLUTION.md)
4. Dopo la risoluzione, rieseguire l'analisi PHPStan




## Collegamenti
- [Documentazione PHPStan](../../docs/phpstan/PHPSTAN_WORKFLOW.md)
- [Linee Guida Moduli](../../docs/MODULES.md)
- [Risoluzione Conflitti](../../docs/development/CONFLICT_RESOLUTION.md)








- [Risoluzione Conflitti](../../docs/development/CONFLICT_RESOLUTION.md)
- [Risoluzione Conflitti](../../docs/development/CONFLICT_RESOLUTION.md)
- [Risoluzione Conflitti](../../docs/development/CONFLICT_RESOLUTION.md)
- [Risoluzione Conflitti](../../docs/development/CONFLICT_RESOLUTION.md)











- [Risoluzione Conflitti](../../docs/development/CONFLICT_RESOLUTION.md)

- [Risoluzione Conflitti](../../docs/development/CONFLICT_RESOLUTION.md)
   - Configurazione PHPStan errata

## Pattern di Risoluzione Errori
Durante l'analisi PHPStan potrebbero emergere errori ricorrenti. Ecco le soluzioni più comuni:
































## Gestione dei Conflitti
In caso di conflitti durante l'analisi dei moduli:
1. Verificare che non ci siano modifiche non committate
2. Eseguire `git status` per identificare i file in conflitto
3. Risolvere i conflitti manualmente seguendo le linee guida in [CONFLICT_RESOLUTION.md](../../docs/development/CONFLICT_RESOLUTION.md)
4. Dopo la risoluzione, rieseguire l'analisi PHPStan















## Collegamenti
- [Documentazione PHPStan](../../docs/phpstan/PHPSTAN_WORKFLOW.md)
- [Linee Guida Moduli](../../docs/MODULES.md)
- [Risoluzione Conflitti](../../docs/development/CONFLICT_RESOLUTION.md)
   - Configurazione PHPStan errata

## Pattern di Risoluzione Errori
Durante l'analisi PHPStan potrebbero emergere errori ricorrenti. Ecco le soluzioni più comuni:

### 1. Tipizzazione nelle Collection
Utilizzare annotazioni PHPDoc appropriate per specificare il tipo di elementi in una Collection:
```php
/** @var Collection<int, User> $users */
$users = User::all();
```

### 2. Tipi Nullable
Quando una proprietà o un parametro può essere null, specificarlo esplicitamente:
```php
public function findUser(?int $id): ?User
{
    // Implementazione
}
```

### 3. Cast nei Modelli
Assicurarsi che la proprietà `$casts` nei modelli sia correttamente tipizzata:
```php
/**
 * @var array<string, string>
 */
protected $casts = [
    'email_verified_at' => 'datetime',
];
```

### 4. Verifiche di Nullità
Quando si accede a proprietà o metodi di oggetti potenzialmente null, verificare prima che non siano null:
```php
if ($user !== null) {
    $email = $user->email;
}
```

## Integrazione con CI/CD
Lo script può essere integrato in pipeline CI/CD per automatizzare l'analisi del codice:

```yaml











# Esempio di configurazione GitHub Actions
name: PHPStan Analysis
on: [push, pull_request]
jobs:
  phpstan:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.2'
      - name: Install Dependencies
        run: composer install --no-progress
      - name: Run Module Analysis
        run: ./bashscripts/analyze_modules.sh
```

## Collegamenti Bidirezionali
- [Configurazione PHPStan](/var/www/html/_bases/base_ptvx_fila5_mono/laravel/docs/phpstan.md)
- [Struttura dei Moduli](/var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules/Xot/docs/MODULE-STRUCTURE.md)
- [Best Practices PHPStan](/var/www/html/_bases/base_ptvx_fila5_mono/laravel/Modules/Xot/docs/PHPSTAN-LEVEL9-GUIDE.md)
- [Script di Automazione](/var/www/html/_bases/base_ptvx_fila5_mono/bashscripts/docs/scripts.md)
   - Configurazione PHPStan errata 



   - Configurazione PHPStan errata 



   - Configurazione PHPStan errata 
