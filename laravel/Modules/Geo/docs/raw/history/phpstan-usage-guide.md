# Guida all'Utilizzo di PHPStan nel Framework Laraxot PTVX

## Introduzione

PHPStan è uno strumento di analisi statica che aiuta a identificare errori nel codice senza doverlo eseguire. Questo documento fornisce informazioni dettagliate su come usare PHPStan nel contesto del framework Laraxot PTVX.

## Comando Base per Eseguire PHPStan

### Posizione Corretta di PHPStan

PHPStan è installato come dipendenza Composer, quindi il binario eseguibile si trova in:

```
./vendor/bin/phpstan
```

all'interno della directory `laravel` del progetto.

### Comando Corretto per l'Analisi

**Importante:** Eseguire sempre PHPStan dalla directory `laravel` del progetto:

```bash
cd /percorso/al/progetto/laravel
./vendor/bin/phpstan analyse [opzioni] [percorso]
```

❌ **NON usare:**
```bash
php artisan phpstan:analyse
```

✅ **Usare invece:**
```bash
./vendor/bin/phpstan analyse
```

## Analisi di Moduli Specifici

Per analizzare un modulo specifico:

```bash
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9
```

Per analizzare più moduli:

```bash
./vendor/bin/phpstan analyse Modules/Xot Modules/User --level=9
```

Per analizzare tutti i moduli (può richiedere molto tempo):

```bash
./vendor/bin/phpstan analyse Modules --level=9
```

## Livelli di Analisi

PHPStan offre più livelli di rigore nell'analisi (da 0 a 10). Il framework Laraxot PTVX mira a essere compatibile con:

- **Livello 9:** Standard attuale del progetto
- **Livello 10:** Obiettivo futuro (massima rigidità)

```bash
# Analisi a livello 9 (standard corrente)
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9

# Analisi a livello 10 (più severo)
./vendor/bin/phpstan analyse Modules/NomeModulo --level=10
```

## Configurazione

La configurazione di PHPStan per Laraxot PTVX si trova in:

```
laravel/phpstan.neon
```

Questo file include le configurazioni di base per tutti i moduli.

### Configurazioni specifiche per modulo

Ogni modulo può avere la propria configurazione PHPStan in:

```
Modules/NomeModulo/phpstan.neon.php
```

## Esclusione di File e Directory

Per escludere file o directory dall'analisi, ci sono due approcci:

### 1. Utilizzo delle Opzioni della Riga di Comando

```bash
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9 --exclude Modules/NomeModulo/tests
```

### 2. Configurazioni nel File phpstan.neon

```neon
parameters:
  excludePaths:
    - */tests/*
    - */vendor/*
```

## Generazione del Baseline

Se hai molti errori e vuoi stabilire un punto di partenza per correggerli gradualmente:

```bash
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9 --generate-baseline
```

Questo creerà un file `phpstan-baseline.neon` che PHPStan utilizzerà come base per ignorare gli errori esistenti.

## Output e Formattazione

### Output su Console

```bash
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9
```

### Output in JSON

```bash
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9 --error-format=json
```

### Output in un File

```bash
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9 > phpstan-results.txt
```

## Ignorare Specifici Errori nel Codice

A volte è necessario ignorare alcuni errori specifici. Questo dovrebbe essere fatto con parsimonia e con una chiara giustificazione:

```php
/** @phpstan-ignore-next-line */
$variabile = qualcosa_che_trigghera_errore();

// Oppure per un intero blocco
/** @phpstan-ignore-next-line */
function miaFunzioneProblematica() {
    // Codice con errori PHPStan
}
```

## Risoluzione degli Errori Comuni

### 1. Errori di Tipo nelle Proprietà dei Modelli

```php
/**
 * @property string $name Nome utente
 * @property int $age Età utente
 */
class User extends Model {
    // ...
}
```

### 2. Errori nei Metodi Dinamici di Eloquent

```php
/**
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail(string $email)
 */
class User extends Model {
    // ...
}
```

### 3. Relazioni non Tipi Correttamente

```php
/**
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Post>
 */
public function post(): \Illuminate\Database\Eloquent\Relations\BelongsTo
{
    return $this->belongsTo(Post::class);
}
```

## Integrazione con CI/CD

È consigliabile integrare PHPStan nel flusso CI/CD per garantire che tutti i commit rispettino gli standard:

```yaml
# Esempio per GitHub Actions
name: PHPStan

on:
  push:
    branches: [ main, develop ]
  pull_request:
    branches: [ main, develop ]

jobs:
  phpstan:
    runs-on: ubuntu-latest
    steps:
    - uses: actions/checkout@v3
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
    - name: Install Dependencies
      run: cd laravel && composer install --no-ansi --no-interaction
    - name: Run PHPStan
      run: cd laravel && ./vendor/bin/phpstan analyse Modules --level=9
```

## Conclusione

Seguendo questa guida, sarai in grado di utilizzare efficacemente PHPStan all'interno del framework Laraxot PTVX. Ricorda che l'obiettivo è migliorare la qualità del codice e prevenire errori, non complicare lo sviluppo. Utilizzando PHPStan regolarmente, potrai identificare e correggere i problemi prima che diventino critici.

## Promemoria Rapido

```bash
# Dalla directory laravel del progetto
cd /percorso/al/progetto/laravel

# Analisi di base
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9

# Analisi più rigida
./vendor/bin/phpstan analyse Modules/NomeModulo --level=10

# Analisi con output dettagliato
./vendor/bin/phpstan analyse Modules/NomeModulo --level=9 --verbose
``` 