# Script di Verifica della Qualità del Codice

Questa documentazione descrive gli script e le procedure utilizzate per verificare e migliorare la qualità del codice nel progetto Laravel.

## Panoramica

Questa documentazione descrive gli script e le procedure utilizzate per verificare e migliorare la qualità del codice nel progetto Laravel.

## Panoramica



Il sistema di quality assurance è composto da diversi script automatizzati che verificano:
- Conformità alle architetture predefinite
- Implementazione corretta dei metodi obbligatori
- Aderenza agli standard di codifica
- Presenza di documentazione adeguata

## Script Principali

### check_form_schema.php

#### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form in Filament.

#### Posizione
```bash
bashscripts/check_form_schema.php
```

#### Funzionalità
- **Scansione ricorsiva**: Analizza tutti i file PHP nella directory del progetto Laravel
- **Identificazione classi**: Trova tutte le classi che estendono `XotBaseResource`
- **Verifica metodi**: Controlla la presenza del metodo `getFormSchema()`
- **Report dettagliato**: Genera un report delle classi non conformi
- **Logging**: Crea documentazione automatica dei risultati

#### Utilizzo
```bash
# Esecuzione dello script
php bashscripts/check_form_schema.php

# Esecuzione con output verbose
php bashscripts/check_form_schema.php --verbose

# Esecuzione con salvataggio del report
php bashscripts/check_form_schema.php --output=report.txt
```

#### Output di Esempio
```text
XotBaseResource Classes Form Schema Check

✅ Analisi completata: 15 classi trovate
❌ 3 classi mancanti del metodo getFormSchema():

- UserResource in Modules/User/app/Filament/Resources/UserResource.php
  → Linea: 12, Estende: XotBaseResource
  
- ProfileResource in Modules/User/app/Filament/Resources/ProfileResource.php  
  → Linea: 18, Estende: XotBaseResource
  
- EventResource in Modules/Activity/app/Filament/Resources/EventResource.php
  → Linea: 25, Estende: XotBaseResource

📊 Statistiche:
- Classi conformi: 12/15 (80%)
- Classi da correggere: 3/15 (20%)
```

#### Miglioramenti Implementati
- **Tipizzazione forte**: Uso di type hints PHP 8+
- **Funzioni sicure**: Implementazione di controlli robusti
- **Documentazione PHPDoc**: Annotazioni complete per ogni metodo
- **Gestione errori**: Controlli espliciti con cast di tipo
- **Sicurezza**: Validazione per `SplFileInfo` e path traversal

### check_before_phpstan.sh

#### Descrizione
Script bash che esegue controlli preliminari prima dell'analisi statica con PHPStan.

#### Funzionalità
- Verifica della configurazione PHPStan
- Controllo delle dipendenze
- Pulizia cache precedenti
- Validazione dei file di configurazione

#### Utilizzo
```bash
# Esecuzione controlli preliminari
bash bashscripts/check_before_phpstan.sh

# Esecuzione con livello di debug
bash bashscripts/check_before_phpstan.sh --debug
```

### phpstan_docs_generator.sh

#### Descrizione
Genera documentazione automatica dai risultati dell'analisi PHPStan.

#### Funzionalità
- Parsing risultati PHPStan
- Generazione report HTML/Markdown
- Creazione grafici di qualità
- Esportazione metriche

#### Utilizzo
```bash
# Generazione documentazione standard
bash bashscripts/phpstan_docs_generator.sh

# Generazione con formato specifico
bash bashscripts/phpstan_docs_generator.sh --format=html --output=docs/
```

## Integrazione nel Workflow di Sviluppo

### Pre-commit Hook
```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "🔍 Eseguendo controlli qualità..."

# Verifica form schema
php bashscripts/check_form_schema.php --quiet

# Controlli PHPStan
bash bashscripts/check_before_phpstan.sh --quiet
vendor/bin/phpstan analyse --no-progress --error-format=table

# PHP CS Fixer
vendor/bin/pint --test

if [ $? -ne 0 ]; then
    echo "❌ Controlli qualità falliti. Commit bloccato."
    exit 1
fi

echo "✅ Controlli qualità superati."
```

### CI/CD Pipeline
```yaml
# .github/workflows/quality-check.yml
name: Code Quality

on: [push, pull_request]

jobs:
  quality:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
          
      - name: Install dependencies
        run: composer install --no-dev --optimize-autoloader
        
      - name: Form Schema Check
        run: php bashscripts/check_form_schema.php
        
      - name: PHPStan Analysis
        run: |
          bash bashscripts/check_before_phpstan.sh
          vendor/bin/phpstan analyse --error-format=github
          
      - name: Code Style Check  
        run: vendor/bin/pint --test
```

### Momenti di Esecuzione Raccomandati
- **Pre-commit**: Controlli base per ogni commit
- **Pre-push**: Analisi completa prima del push
- **Pull Request**: Validazione completa per le review
- **Release**: Controlli estesi prima del rilascio
- **Nightly**: Analisi approfondita schedulata

## Principi di Qualità Applicati

### DRY (Don't Repeat Yourself)
- **Centralizzazione logica**: Script riutilizzabili e modulari
- **Configurazione unificata**: Parametri centralizzati in file di config
- **Funzioni comuni**: Librerie condivise tra script
- **Template standardizzati**: Pattern riutilizzabili per report

Questa documentazione descrive gli script e le procedure utilizzate per verificare e migliorare la qualità del codice nel progetto Laravel.

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```

#### Output di Esempio
```text
XotBaseResource Classes Form Schema Check

### Output
Esempio di output:
```
XotBaseResource Classes Form Schema Check
====

❌ 3 classi senza getFormSchema:
- UserResource in Modules/User/Http/Resources/UserResource.php
- ProfileResource in Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in Modules/Event/Http/Resources/EventResource.php
```

### Best Practice e Integrazione
- Utilizzare tipi PHP forti e annotazioni PHPDoc
- Integrare lo script nel workflow CI/CD (es. GitHub Actions, GitLab CI)
- Eseguire lo script prima di ogni commit importante e durante le review
- Preferire l'uso di Spatie Laravel Data per la validazione e la tipizzazione dei dati
- Utilizzare strumenti come PHPStan e PHP-CS-Fixer per garantire la qualità del codice

## Altri Script di Verifica della Qualità
XotBaseResource Classes Form Schema Check
====

❌ 3 classi senza getFormSchema:
- UserResource in Modules/User/Http/Resources/UserResource.php
- ProfileResource in Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in Modules/Event/Http/Resources/EventResource.php
```

### Best Practice e Integrazione
- Utilizzare tipi PHP forti e annotazioni PHPDoc
- Integrare lo script nel workflow CI/CD (es. GitHub Actions, GitLab CI)
- Eseguire lo script prima di ogni commit importante e durante le review
- Preferire l'uso di Spatie Laravel Data per la validazione e la tipizzazione dei dati
- Utilizzare strumenti come PHPStan e PHP-CS-Fixer per garantire la qualità del codice

## Altri Script di Verifica della Qualità

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

### phpstan_docs_generator.sh
Genera la documentazione dei risultati di PHPStan.

## Raccomandazioni Generali
- Documentare sempre le regole di qualità e i criteri di accettazione
- Aggiornare la documentazione ogni volta che vengono introdotti nuovi controlli
- Integrare i controlli di qualità nel processo di sviluppo e deploy

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

## Raccomandazioni Generali
- Documentare sempre le regole di qualità e i criteri di accettazione
- Aggiornare la documentazione ogni volta che vengono introdotti nuovi controlli
- Integrare i controlli di qualità nel processo di sviluppo e deploy

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```

### Output
Il comando genererà un output simile a:
```
XotBaseResource Classes Form Schema Check
====

❌ 3 classes missing getFormSchema method:

- UserResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/User/Http/Resources/UserResource.php
- ProfileResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Event/Http/Resources/EventResource.php
```

### Risoluzione Conflitti Applicata
- Migliorato il codice con tipi PHP fortemente tipizzati
- Utilizzate le funzioni Safe per una maggiore sicurezza
- Aggiunta documentazione di tipo tramite annotazioni PHPDoc
- Implementati controlli più robusti con cast di tipo espliciti
- Aggiunto controllo per `SplFileInfo` per maggiore sicurezza

### Integrazione con il Workflow di Sviluppo
È consigliabile eseguire questo script:
- Prima di ogni commit importante
- Come parte del processo di CI/CD
- Durante le revisioni del codice

## Altri Script di Verifica della Qualità

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

# Script di Verifica della Qualità del Codice

Questa documentazione descrive gli script utilizzati per verificare e migliorare la qualità del codice nel progetto.

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```

### Output
Il comando genererà un output simile a:
```
XotBaseResource Classes Form Schema Check
====

❌ 3 classes missing getFormSchema method:

- UserResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/User/Http/Resources/UserResource.php
- ProfileResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Event/Http/Resources/EventResource.php
```

### Risoluzione Conflitti Applicata
- Migliorato il codice con tipi PHP fortemente tipizzati
- Utilizzate le funzioni Safe per una maggiore sicurezza
- Aggiunta documentazione di tipo tramite annotazioni PHPDoc
- Implementati controlli più robusti con cast di tipo espliciti
- Aggiunto controllo per `SplFileInfo` per maggiore sicurezza

### Integrazione con il Workflow di Sviluppo
È consigliabile eseguire questo script:
- Prima di ogni commit importante
- Come parte del processo di CI/CD
- Durante le revisioni del codice

## Altri Script di Verifica della Qualità

Questa documentazione descrive gli script e le procedure utilizzate per verificare e migliorare la qualità del codice nel progetto Laravel.

## Panoramica

Il sistema di quality assurance è composto da diversi script automatizzati che verificano:
- Conformità alle architetture predefinite
- Implementazione corretta dei metodi obbligatori
- Aderenza agli standard di codifica
- Presenza di documentazione adeguata

## Script Principali

### check_form_schema.php

#### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form in Filament.

#### Posizione
```bash
bashscripts/check_form_schema.php
```

#### Funzionalità
- **Scansione ricorsiva**: Analizza tutti i file PHP nella directory del progetto Laravel
- **Identificazione classi**: Trova tutte le classi che estendono `XotBaseResource`
- **Verifica metodi**: Controlla la presenza del metodo `getFormSchema()`
- **Report dettagliato**: Genera un report delle classi non conformi
- **Logging**: Crea documentazione automatica dei risultati

#### Utilizzo
```bash
# Esecuzione dello script
php bashscripts/check_form_schema.php

# Esecuzione con output verbose
php bashscripts/check_form_schema.php --verbose

# Esecuzione con salvataggio del report
php bashscripts/check_form_schema.php --output=report.txt
```

#### Output di Esempio
```text
XotBaseResource Classes Form Schema Check

✅ Analisi completata: 15 classi trovate
❌ 3 classi mancanti del metodo getFormSchema():

- UserResource in Modules/User/app/Filament/Resources/UserResource.php
  → Linea: 12, Estende: XotBaseResource
  
- ProfileResource in Modules/User/app/Filament/Resources/ProfileResource.php  
  → Linea: 18, Estende: XotBaseResource
  
- EventResource in Modules/Activity/app/Filament/Resources/EventResource.php
  → Linea: 25, Estende: XotBaseResource

📊 Statistiche:
- Classi conformi: 12/15 (80%)
- Classi da correggere: 3/15 (20%)
```

#### Miglioramenti Implementati
- **Tipizzazione forte**: Uso di type hints PHP 8+
- **Funzioni sicure**: Implementazione di controlli robusti
- **Documentazione PHPDoc**: Annotazioni complete per ogni metodo
- **Gestione errori**: Controlli espliciti con cast di tipo
- **Sicurezza**: Validazione per `SplFileInfo` e path traversal

### check_before_phpstan.sh

#### Descrizione
Script bash che esegue controlli preliminari prima dell'analisi statica con PHPStan.

#### Funzionalità
- Verifica della configurazione PHPStan
- Controllo delle dipendenze
- Pulizia cache precedenti
- Validazione dei file di configurazione

#### Utilizzo
```bash
# Esecuzione controlli preliminari
bash bashscripts/check_before_phpstan.sh

# Esecuzione con livello di debug
bash bashscripts/check_before_phpstan.sh --debug
```

### phpstan_docs_generator.sh

#### Descrizione
Genera documentazione automatica dai risultati dell'analisi PHPStan.

#### Funzionalità
- Parsing risultati PHPStan
- Generazione report HTML/Markdown
- Creazione grafici di qualità
- Esportazione metriche

#### Utilizzo
```bash
# Generazione documentazione standard
bash bashscripts/phpstan_docs_generator.sh

# Generazione con formato specifico
bash bashscripts/phpstan_docs_generator.sh --format=html --output=docs/
```

## Integrazione nel Workflow di Sviluppo

### Pre-commit Hook
```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "🔍 Eseguendo controlli qualità..."

# Verifica form schema
php bashscripts/check_form_schema.php --quiet

# Controlli PHPStan
bash bashscripts/check_before_phpstan.sh --quiet
vendor/bin/phpstan analyse --no-progress --error-format=table

# PHP CS Fixer
vendor/bin/pint --test

if [ $? -ne 0 ]; then
    echo "❌ Controlli qualità falliti. Commit bloccato."
    exit 1
fi

echo "✅ Controlli qualità superati."
```

### CI/CD Pipeline
```yaml
# .github/workflows/quality-check.yml
name: Code Quality

on: [push, pull_request]

jobs:
  quality:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
          
      - name: Install dependencies
        run: composer install --no-dev --optimize-autoloader
        
      - name: Form Schema Check
        run: php bashscripts/check_form_schema.php
        
      - name: PHPStan Analysis
        run: |
          bash bashscripts/check_before_phpstan.sh
          vendor/bin/phpstan analyse --error-format=github
          
      - name: Code Style Check  
        run: vendor/bin/pint --test
```

### Momenti di Esecuzione Raccomandati
- **Pre-commit**: Controlli base per ogni commit
- **Pre-push**: Analisi completa prima del push
- **Pull Request**: Validazione completa per le review
- **Release**: Controlli estesi prima del rilascio
- **Nightly**: Analisi approfondita schedulata

## Principi di Qualità Applicati

### DRY (Don't Repeat Yourself)
- **Centralizzazione logica**: Script riutilizzabili e modulari
- **Configurazione unificata**: Parametri centralizzati in file di config
- **Funzioni comuni**: Librerie condivise tra script
- **Template standardizzati**: Pattern riutilizzabili per report

### KISS (Keep It Simple, Stupid)
- **Struttura lineare**: Script comprensibili e diretti
- **Output chiari**: Report facilmente interpretabili
- **Configurazione minimale**: Solo parametri essenziali
- **Interfaccia intuitiva**: Comandi semplici e consistenti

### SOLID Principles
- **Single Responsibility**: Ogni script ha un compito specifico
- **Open/Closed**: Estendibile senza modifiche al core
- **Interface Segregation**: API specifiche per ogni use case
- **Dependency Inversion**: Configurazioni iniettabili

## Metriche di Qualità

### Indicatori Monitorati
- **Copertura test**: Target 90%+ per codice critico
- **Complessità ciclomatica**: Max 10 per metodo
- **Duplicazione codice**: Max 5% del codebase  
- **Debt tecnico**: Tracking tramite SonarQube
- **Performance**: Response time <200ms per endpoint

### Soglie di Qualità
```php
// phpstan.neon
parameters:
    level: 9
    checkMissingIterableValueType: true
    checkGenericClassInNonGenericObjectType: true
    reportUnmatchedIgnoredErrors: true
```

## Strumenti Aggiuntivi

### Analisi Statica
- **PHPStan**: Livello 9+ obbligatorio
- **Psalm**: Analisi tipi avanzata
- **PHP_CodeSniffer**: Standard PSR-12

### Formattazione Codice
- **Laravel Pint**: Formattazione automatica
- **PHP-CS-Fixer**: Regole personalizzate
- **EditorConfig**: Consistenza IDE

### Testing
- **Pest**: Framework di test principale
- **PHPUnit**: Test legacy e integrazione
- **Mockery**: Mocking avanzato

### Performance
- **Blackfire**: Profiling produzione
- **XDebug**: Debug e profiling sviluppo
- **Laravel Telescope**: Monitoring real-time

## Configurazione Avanzata

### File di Configurazione
```php
// config/quality.php
return [
    'checks' => [
        'form_schema' => [
            'enabled' => true,
            'base_class' => 'XotBaseResource',
            'required_methods' => ['getFormSchema'],
            'exclude_paths' => ['vendor/', 'storage/'],
        ],
        'phpstan' => [
            'level' => 9,
            'config' => 'phpstan.neon',
            'memory_limit' => '2G',
        ],
    ],
    'reports' => [
        'output_format' => 'json',
        'save_to_file' => true,
        'file_path' => 'storage/quality-reports/',
    ],
];
```

### Script Personalizzati
```bash
# bashscripts/custom-checks.sh
#!/bin/bash

# Check per convenzioni naming
check_naming_conventions() {
    echo "🏷️  Verificando convenzioni di naming..."
    # Implementazione custom
}

# Check per architettura moduli
check_module_structure() {
    echo "🏗️  Verificando struttura moduli..."  
    # Implementazione custom
}
```

## Troubleshooting

### Problemi Comuni

#### Script non trovato
```bash
# Verifica percorso
ls -la bashscripts/check_form_schema.php

# Verifica permessi
chmod +x bashscripts/*.sh
```

#### Memory limit PHPStan
```bash
# Aumenta memory limit
php -d memory_limit=2G vendor/bin/phpstan analyse
```

#### Conflitti Git nei report
```bash
# Pulisci file di report
rm -f storage/quality-reports/*.tmp
git checkout HEAD -- storage/quality-reports/
```

## Risorse e Link Utili

### Documentazione Ufficiale
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Laravel Pint](https://laravel.com/docs/pint)
- [Pest Testing Framework](https://pestphp.com/)
- [Filament Documentation](https://filamentphp.com/docs)

### Best Practices
- [PHP Standards (PSR)](https://www.php-fig.org/psr/)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Clean Code PHP](https://github.com/jupeter/clean-code-php)

### Tools e Integrations
- [GitHub Actions PHP](https://docs.github.com/en/actions/guides/building-and-testing-php)
- [SonarQube PHP](https://docs.sonarqube.org/latest/analysis/languages/php/)
- [Blackfire Profiler](https://blackfire.io/docs/introduction)


Questa documentazione descrive gli script e le procedure utilizzate per verificare e migliorare la qualità del codice nel progetto Laravel.
Questa documentazione descrive gli script utilizzati per verificare e migliorare la qualità del codice nel progetto.

Questa documentazione descrive gli script e le procedure utilizzate per verificare e migliorare la qualità del codice nel progetto Laravel.


## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```


#### Output di Esempio
```text

XotBaseResource Classes Form Schema Check


### Output
Esempio di output:
```
XotBaseResource Classes Form Schema Check
====

❌ 3 classi senza getFormSchema:
- UserResource in Modules/User/Http/Resources/UserResource.php
- ProfileResource in Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in Modules/Event/Http/Resources/EventResource.php
```

### Best Practice e Integrazione
- Utilizzare tipi PHP forti e annotazioni PHPDoc
- Integrare lo script nel workflow CI/CD (es. GitHub Actions, GitLab CI)
- Eseguire lo script prima di ogni commit importante e durante le review
- Preferire l'uso di Spatie Laravel Data per la validazione e la tipizzazione dei dati
- Utilizzare strumenti come PHPStan e PHP-CS-Fixer per garantire la qualità del codice

## Altri Script di Verifica della Qualità
#### Output di Esempio
```text
### Output
Esempio di output:
```

XotBaseResource Classes Form Schema Check
====

✅ Analisi completata: 15 classi trovate
❌ 3 classi mancanti del metodo getFormSchema():

- UserResource in Modules/User/app/Filament/Resources/UserResource.php
  → Linea: 12, Estende: XotBaseResource
  
- ProfileResource in Modules/User/app/Filament/Resources/ProfileResource.php  
  → Linea: 18, Estende: XotBaseResource
  
- EventResource in Modules/Activity/app/Filament/Resources/EventResource.php
  → Linea: 25, Estende: XotBaseResource

📊 Statistiche:
- Classi conformi: 12/15 (80%)
- Classi da correggere: 3/15 (20%)
```

#### Miglioramenti Implementati
- **Tipizzazione forte**: Uso di type hints PHP 8+
- **Funzioni sicure**: Implementazione di controlli robusti
- **Documentazione PHPDoc**: Annotazioni complete per ogni metodo
- **Gestione errori**: Controlli espliciti con cast di tipo
- **Sicurezza**: Validazione per `SplFileInfo` e path traversal

### Output
Esempio di output:
```
XotBaseResource Classes Form Schema Check
====


XotBaseResource Classes Form Schema Check
====



❌ 3 classi senza getFormSchema:
- UserResource in Modules/User/Http/Resources/UserResource.php
- ProfileResource in Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in Modules/Event/Http/Resources/EventResource.php
```

### Best Practice e Integrazione
- Utilizzare tipi PHP forti e annotazioni PHPDoc
- Integrare lo script nel workflow CI/CD (es. GitHub Actions, GitLab CI)
- Eseguire lo script prima di ogni commit importante e durante le review
- Preferire l'uso di Spatie Laravel Data per la validazione e la tipizzazione dei dati
- Utilizzare strumenti come PHPStan e PHP-CS-Fixer per garantire la qualità del codice

## Altri Script di Verifica della Qualità




### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

### phpstan_docs_generator.sh


Genera la documentazione dei risultati di PHPStan.

## Raccomandazioni Generali
- Documentare sempre le regole di qualità e i criteri di accettazione
- Aggiornare la documentazione ogni volta che vengono introdotti nuovi controlli
- Integrare i controlli di qualità nel processo di sviluppo e deploy

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

Genera la documentazione dei risultati di PHPStan.



## Raccomandazioni Generali
- Documentare sempre le regole di qualità e i criteri di accettazione
- Aggiornare la documentazione ogni volta che vengono introdotti nuovi controlli
- Integrare i controlli di qualità nel processo di sviluppo e deploy

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.


### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```

### Output
Il comando genererà un output simile a:
```
XotBaseResource Classes Form Schema Check
====

❌ 3 classes missing getFormSchema method:

- UserResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/User/Http/Resources/UserResource.php
- ProfileResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Event/Http/Resources/EventResource.php
```

### Risoluzione Conflitti Applicata
- Migliorato il codice con tipi PHP fortemente tipizzati
- Utilizzate le funzioni Safe per una maggiore sicurezza
- Aggiunta documentazione di tipo tramite annotazioni PHPDoc
- Implementati controlli più robusti con cast di tipo espliciti
- Aggiunto controllo per `SplFileInfo` per maggiore sicurezza

### Integrazione con il Workflow di Sviluppo
È consigliabile eseguire questo script:
- Prima di ogni commit importante
- Come parte del processo di CI/CD
- Durante le revisioni del codice

## Altri Script di Verifica della Qualità

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

# Script di Verifica della Qualità del Codice

Questa documentazione descrive gli script utilizzati per verificare e migliorare la qualità del codice nel progetto.

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```

### Output
Il comando genererà un output simile a:
```
XotBaseResource Classes Form Schema Check
====

❌ 3 classes missing getFormSchema method:

- UserResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/User/Http/Resources/UserResource.php
- ProfileResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Event/Http/Resources/EventResource.php
```

### Risoluzione Conflitti Applicata
- Migliorato il codice con tipi PHP fortemente tipizzati
- Utilizzate le funzioni Safe per una maggiore sicurezza
- Aggiunta documentazione di tipo tramite annotazioni PHPDoc
- Implementati controlli più robusti con cast di tipo espliciti
- Aggiunto controllo per `SplFileInfo` per maggiore sicurezza

### Integrazione con il Workflow di Sviluppo
È consigliabile eseguire questo script:
- Prima di ogni commit importante
- Come parte del processo di CI/CD
- Durante le revisioni del codice

## Altri Script di Verifica della Qualità


Questa documentazione descrive gli script e le procedure utilizzate per verificare e migliorare la qualità del codice nel progetto Laravel.

## Panoramica

Il sistema di quality assurance è composto da diversi script automatizzati che verificano:
- Conformità alle architetture predefinite
- Implementazione corretta dei metodi obbligatori
- Aderenza agli standard di codifica
- Presenza di documentazione adeguata

## Script Principali

### check_form_schema.php

#### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form in Filament.

#### Posizione
```bash
bashscripts/check_form_schema.php
```

#### Funzionalità
- **Scansione ricorsiva**: Analizza tutti i file PHP nella directory del progetto Laravel
- **Identificazione classi**: Trova tutte le classi che estendono `XotBaseResource`
- **Verifica metodi**: Controlla la presenza del metodo `getFormSchema()`
- **Report dettagliato**: Genera un report delle classi non conformi
- **Logging**: Crea documentazione automatica dei risultati

#### Utilizzo
```bash
# Esecuzione dello script
php bashscripts/check_form_schema.php

# Esecuzione con output verbose
php bashscripts/check_form_schema.php --verbose

# Esecuzione con salvataggio del report
php bashscripts/check_form_schema.php --output=report.txt
```

#### Output di Esempio
```text
XotBaseResource Classes Form Schema Check

✅ Analisi completata: 15 classi trovate
❌ 3 classi mancanti del metodo getFormSchema():

- UserResource in Modules/User/app/Filament/Resources/UserResource.php
  → Linea: 12, Estende: XotBaseResource
  
- ProfileResource in Modules/User/app/Filament/Resources/ProfileResource.php  
  → Linea: 18, Estende: XotBaseResource
  
- EventResource in Modules/Activity/app/Filament/Resources/EventResource.php
  → Linea: 25, Estende: XotBaseResource

📊 Statistiche:
- Classi conformi: 12/15 (80%)
- Classi da correggere: 3/15 (20%)
```

#### Miglioramenti Implementati
- **Tipizzazione forte**: Uso di type hints PHP 8+
- **Funzioni sicure**: Implementazione di controlli robusti
- **Documentazione PHPDoc**: Annotazioni complete per ogni metodo
- **Gestione errori**: Controlli espliciti con cast di tipo
- **Sicurezza**: Validazione per `SplFileInfo` e path traversal

### check_before_phpstan.sh

#### Descrizione
Script bash che esegue controlli preliminari prima dell'analisi statica con PHPStan.

#### Funzionalità
- Verifica della configurazione PHPStan
- Controllo delle dipendenze
- Pulizia cache precedenti
- Validazione dei file di configurazione

#### Utilizzo
```bash
# Esecuzione controlli preliminari
bash bashscripts/check_before_phpstan.sh

# Esecuzione con livello di debug
bash bashscripts/check_before_phpstan.sh --debug
```

### phpstan_docs_generator.sh

#### Descrizione
Genera documentazione automatica dai risultati dell'analisi PHPStan.

#### Funzionalità
- Parsing risultati PHPStan
- Generazione report HTML/Markdown
- Creazione grafici di qualità
- Esportazione metriche

#### Utilizzo
```bash
# Generazione documentazione standard
bash bashscripts/phpstan_docs_generator.sh

# Generazione con formato specifico
bash bashscripts/phpstan_docs_generator.sh --format=html --output=docs/
```

## Integrazione nel Workflow di Sviluppo

### Pre-commit Hook
```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "🔍 Eseguendo controlli qualità..."

# Verifica form schema
php bashscripts/check_form_schema.php --quiet

# Controlli PHPStan
bash bashscripts/check_before_phpstan.sh --quiet
vendor/bin/phpstan analyse --no-progress --error-format=table

# PHP CS Fixer
vendor/bin/pint --test

if [ $? -ne 0 ]; then
    echo "❌ Controlli qualità falliti. Commit bloccato."
    exit 1
fi

echo "✅ Controlli qualità superati."
```

### CI/CD Pipeline
```yaml
# .github/workflows/quality-check.yml
name: Code Quality

on: [push, pull_request]

jobs:
  quality:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
          
      - name: Install dependencies
        run: composer install --no-dev --optimize-autoloader
        
      - name: Form Schema Check
        run: php bashscripts/check_form_schema.php
        
      - name: PHPStan Analysis
        run: |
          bash bashscripts/check_before_phpstan.sh
          vendor/bin/phpstan analyse --error-format=github
          
      - name: Code Style Check  
        run: vendor/bin/pint --test
```

### Momenti di Esecuzione Raccomandati
- **Pre-commit**: Controlli base per ogni commit
- **Pre-push**: Analisi completa prima del push
- **Pull Request**: Validazione completa per le review
- **Release**: Controlli estesi prima del rilascio
- **Nightly**: Analisi approfondita schedulata

## Principi di Qualità Applicati

### DRY (Don't Repeat Yourself)
- **Centralizzazione logica**: Script riutilizzabili e modulari
- **Configurazione unificata**: Parametri centralizzati in file di config
- **Funzioni comuni**: Librerie condivise tra script
- **Template standardizzati**: Pattern riutilizzabili per report


### KISS (Keep It Simple, Stupid)
- **Struttura lineare**: Script comprensibili e diretti
- **Output chiari**: Report facilmente interpretabili
- **Configurazione minimale**: Solo parametri essenziali
- **Interfaccia intuitiva**: Comandi semplici e consistenti

### SOLID Principles
- **Single Responsibility**: Ogni script ha un compito specifico
- **Open/Closed**: Estendibile senza modifiche al core
- **Interface Segregation**: API specifiche per ogni use case
- **Dependency Inversion**: Configurazioni iniettabili

## Metriche di Qualità



### Indicatori Monitorati
- **Copertura test**: Target 90%+ per codice critico
- **Complessità ciclomatica**: Max 10 per metodo
- **Duplicazione codice**: Max 5% del codebase  
- **Debt tecnico**: Tracking tramite SonarQube
- **Performance**: Response time <200ms per endpoint

### Soglie di Qualità
```php
// phpstan.neon
parameters:
    level: 9
    checkMissingIterableValueType: true
    checkGenericClassInNonGenericObjectType: true
    reportUnmatchedIgnoredErrors: true

```

## Strumenti Aggiuntivi


### Analisi Statica
- **PHPStan**: Livello 9+ obbligatorio
- **Psalm**: Analisi tipi avanzata
- **PHP_CodeSniffer**: Standard PSR-12

### Formattazione Codice
- **Laravel Pint**: Formattazione automatica
- **PHP-CS-Fixer**: Regole personalizzate
- **EditorConfig**: Consistenza IDE

### Testing
- **Pest**: Framework di test principale
- **PHPUnit**: Test legacy e integrazione
- **Mockery**: Mocking avanzato

### Performance
- **Blackfire**: Profiling produzione
- **XDebug**: Debug e profiling sviluppo
- **Laravel Telescope**: Monitoring real-time


## Configurazione Avanzata

### File di Configurazione
```php

// config/quality.php
return [
    'checks' => [
        'form_schema' => [
            'enabled' => true,
            'base_class' => 'XotBaseResource',
            'required_methods' => ['getFormSchema'],
            'exclude_paths' => ['vendor/', 'storage/'],
        ],
        'phpstan' => [
            'level' => 9,
            'config' => 'phpstan.neon',
            'memory_limit' => '2G',
        ],


    ],
    'reports' => [
        'output_format' => 'json',
        'save_to_file' => true,
        'file_path' => 'storage/quality-reports/',

    ],
];
```

### Script Personalizzati
```bash
# bashscripts/custom-checks.sh
#!/bin/bash


# Check per convenzioni naming
check_naming_conventions() {
    echo "🏷️  Verificando convenzioni di naming..."
    # Implementazione custom
}


# Check per architettura moduli
check_module_structure() {
    echo "🏗️  Verificando struttura moduli..."  
    # Implementazione custom
}
```

## Troubleshooting

### Problemi Comuni

#### Script non trovato
```bash
# Verifica percorso
ls -la bashscripts/check_form_schema.php

# Verifica permessi
chmod +x bashscripts/*.sh
```

#### Memory limit PHPStan
```bash
# Aumenta memory limit
php -d memory_limit=2G vendor/bin/phpstan analyse
```

#### Conflitti Git nei report
```bash
# Pulisci file di report
rm -f storage/quality-reports/*.tmp
git checkout HEAD -- storage/quality-reports/
```

## Risorse e Link Utili


### Documentazione Ufficiale
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Laravel Pint](https://laravel.com/docs/pint)
- [Pest Testing Framework](https://pestphp.com/)
- [Filament Documentation](https://filamentphp.com/docs)

### Best Practices
- [PHP Standards (PSR)](https://www.php-fig.org/psr/)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Clean Code PHP](https://github.com/jupeter/clean-code-php)

### Tools e Integrations
- [GitHub Actions PHP](https://docs.github.com/en/actions/guides/building-and-testing-php)
- [SonarQube PHP](https://docs.sonarqube.org/latest/analysis/languages/php/)
- [Blackfire Profiler](https://blackfire.io/docs/introduction)

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.
---



---


# Script di Verifica della Qualità del Codice

Questa documentazione descrive gli script utilizzati per verificare e migliorare la qualità del codice nel progetto.

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```

### Output
Il comando genererà un output simile a:
```
XotBaseResource Classes Form Schema Check
====

❌ 3 classes missing getFormSchema method:

- UserResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/User/Http/Resources/UserResource.php
- ProfileResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Event/Http/Resources/EventResource.php
```

### Risoluzione Conflitti Applicata
- Migliorato il codice con tipi PHP fortemente tipizzati
- Utilizzate le funzioni Safe per una maggiore sicurezza
- Aggiunta documentazione di tipo tramite annotazioni PHPDoc
- Implementati controlli più robusti con cast di tipo espliciti
- Aggiunto controllo per `SplFileInfo` per maggiore sicurezza

### Integrazione con il Workflow di Sviluppo
È consigliabile eseguire questo script:
- Prima di ogni commit importante
- Come parte del processo di CI/CD
- Durante le revisioni del codice

## Altri Script di Verifica della Qualità

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

# Script di Verifica della Qualità del Codice

Questa documentazione descrive gli script utilizzati per verificare e migliorare la qualità del codice nel progetto.

## check_form_schema.php

### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form.

### Posizione
```
bashscripts/check_form_schema.php
```

### Funzionalità
- Scansiona ricorsivamente i file PHP nella directory del progetto Laravel
- Identifica tutte le classi che estendono `XotBaseResource`
- Verifica la presenza del metodo `getFormSchema()`
- Genera un report delle classi che non implementano il metodo
- Crea un log di documentazione con i risultati

### Uso
```bash
php bashscripts/check_form_schema.php
```

### Output
Il comando genererà un output simile a:
```
XotBaseResource Classes Form Schema Check
====

❌ 3 classes missing getFormSchema method:

- UserResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/User/Http/Resources/UserResource.php
- ProfileResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Profile/Http/Resources/ProfileResource.php
- EventResource in /var/www/html/base_<nome progetto>_fila5/laravel/Modules/Event/Http/Resources/EventResource.php
```

### Risoluzione Conflitti Applicata
- Migliorato il codice con tipi PHP fortemente tipizzati
- Utilizzate le funzioni Safe per una maggiore sicurezza
- Aggiunta documentazione di tipo tramite annotazioni PHPDoc
- Implementati controlli più robusti con cast di tipo espliciti
- Aggiunto controllo per `SplFileInfo` per maggiore sicurezza

### Integrazione con il Workflow di Sviluppo
È consigliabile eseguire questo script:
- Prima di ogni commit importante
- Come parte del processo di CI/CD
- Durante le revisioni del codice

## Altri Script di Verifica della Qualità

### check_before_phpstan.sh
Esegue controlli preliminari prima dell'analisi con PHPStan.

### phpstan_docs_generator.sh 




## Risorse Utili
- [PHPStan](https://phpstan.org/)
- [Spatie Laravel Data](https://spatie.be/docs/laravel-data/v4/introduction)
- [CI/CD Best Practices](https://docs.github.com/en/actions/guides/building-and-testing-php) 
---

*Ultimo aggiornamento: Agosto 2025*  
*Versione: 2.1.0*

*Ultimo aggiornamento: Agosto 2025*  
*Versione: 2.1.0*
---

*Ultimo aggiornamento: Agosto 2025*  
*Versione: 2.1.0*




*Ultimo aggiornamento: Agosto 2025*  
*Versione: 2.1.0*
---

*Ultimo aggiornamento: Agosto 2025*  
*Versione: 2.1.0*

*Ultimo aggiornamento: Agosto 2025*  
*Versione: 2.1.0*



*Ultimo aggiornamento: Agosto 2025*  
*Versione: 2.1.0*
Questa documentazione descrive gli script e le procedure utilizzate per verificare e migliorare la qualità del codice nel progetto Laravel.

## Panoramica

Il sistema di quality assurance è composto da diversi script automatizzati che verificano:
- Conformità alle architetture predefinite
- Implementazione corretta dei metodi obbligatori
- Aderenza agli standard di codifica
- Presenza di documentazione adeguata

## Script Principali

### check_form_schema.php

#### Descrizione
Script PHP che verifica se le classi che estendono `XotBaseResource` implementano correttamente il metodo `getFormSchema()`, essenziale per il corretto funzionamento del sistema di form in Filament.

#### Posizione
```bash
bashscripts/check_form_schema.php
```

#### Funzionalità
- **Scansione ricorsiva**: Analizza tutti i file PHP nella directory del progetto Laravel
- **Identificazione classi**: Trova tutte le classi che estendono `XotBaseResource`
- **Verifica metodi**: Controlla la presenza del metodo `getFormSchema()`
- **Report dettagliato**: Genera un report delle classi non conformi
- **Logging**: Crea documentazione automatica dei risultati

#### Utilizzo
```bash
# Esecuzione dello script
php bashscripts/check_form_schema.php

# Esecuzione con output verbose
php bashscripts/check_form_schema.php --verbose

# Esecuzione con salvataggio del report
php bashscripts/check_form_schema.php --output=report.txt
```

#### Output di Esempio
```text
XotBaseResource Classes Form Schema Check

✅ Analisi completata: 15 classi trovate
❌ 3 classi mancanti del metodo getFormSchema():

- UserResource in Modules/User/app/Filament/Resources/UserResource.php
  → Linea: 12, Estende: XotBaseResource
  
- ProfileResource in Modules/User/app/Filament/Resources/ProfileResource.php  
  → Linea: 18, Estende: XotBaseResource
  
- EventResource in Modules/Activity/app/Filament/Resources/EventResource.php
  → Linea: 25, Estende: XotBaseResource

📊 Statistiche:
- Classi conformi: 12/15 (80%)
- Classi da correggere: 3/15 (20%)
```

#### Miglioramenti Implementati
- **Tipizzazione forte**: Uso di type hints PHP 8+
- **Funzioni sicure**: Implementazione di controlli robusti
- **Documentazione PHPDoc**: Annotazioni complete per ogni metodo
- **Gestione errori**: Controlli espliciti con cast di tipo
- **Sicurezza**: Validazione per `SplFileInfo` e path traversal

### check_before_phpstan.sh

#### Descrizione
Script bash che esegue controlli preliminari prima dell'analisi statica con PHPStan.

#### Funzionalità
- Verifica della configurazione PHPStan
- Controllo delle dipendenze
- Pulizia cache precedenti
- Validazione dei file di configurazione

#### Utilizzo
```bash
# Esecuzione controlli preliminari
bash bashscripts/check_before_phpstan.sh

# Esecuzione con livello di debug
bash bashscripts/check_before_phpstan.sh --debug
```

### phpstan_docs_generator.sh

#### Descrizione
Genera documentazione automatica dai risultati dell'analisi PHPStan.

#### Funzionalità
- Parsing risultati PHPStan
- Generazione report HTML/Markdown
- Creazione grafici di qualità
- Esportazione metriche

#### Utilizzo
```bash
# Generazione documentazione standard
bash bashscripts/phpstan_docs_generator.sh

# Generazione con formato specifico
bash bashscripts/phpstan_docs_generator.sh --format=html --output=docs/
```

## Integrazione nel Workflow di Sviluppo

### Pre-commit Hook
```bash
#!/bin/bash
# .git/hooks/pre-commit

echo "🔍 Eseguendo controlli qualità..."

# Verifica form schema
php bashscripts/check_form_schema.php --quiet

# Controlli PHPStan
bash bashscripts/check_before_phpstan.sh --quiet
vendor/bin/phpstan analyse --no-progress --error-format=table

# PHP CS Fixer
vendor/bin/pint --test

if [ $? -ne 0 ]; then
    echo "❌ Controlli qualità falliti. Commit bloccato."
    exit 1
fi

echo "✅ Controlli qualità superati."
```

### CI/CD Pipeline
```yaml
# .github/workflows/quality-check.yml
name: Code Quality

on: [push, pull_request]

jobs:
  quality:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.4'
          
      - name: Install dependencies
        run: composer install --no-dev --optimize-autoloader
        
      - name: Form Schema Check
        run: php bashscripts/check_form_schema.php
        
      - name: PHPStan Analysis
        run: |
          bash bashscripts/check_before_phpstan.sh
          vendor/bin/phpstan analyse --error-format=github
          
      - name: Code Style Check  
        run: vendor/bin/pint --test
```

### Momenti di Esecuzione Raccomandati
- **Pre-commit**: Controlli base per ogni commit
- **Pre-push**: Analisi completa prima del push
- **Pull Request**: Validazione completa per le review
- **Release**: Controlli estesi prima del rilascio
- **Nightly**: Analisi approfondita schedulata

## Principi di Qualità Applicati

### DRY (Don't Repeat Yourself)
- **Centralizzazione logica**: Script riutilizzabili e modulari
- **Configurazione unificata**: Parametri centralizzati in file di config
- **Funzioni comuni**: Librerie condivise tra script
- **Template standardizzati**: Pattern riutilizzabili per report

### KISS (Keep It Simple, Stupid)
- **Struttura lineare**: Script comprensibili e diretti
- **Output chiari**: Report facilmente interpretabili
- **Configurazione minimale**: Solo parametri essenziali
- **Interfaccia intuitiva**: Comandi semplici e consistenti

### SOLID Principles
- **Single Responsibility**: Ogni script ha un compito specifico
- **Open/Closed**: Estendibile senza modifiche al core
- **Interface Segregation**: API specifiche per ogni use case
- **Dependency Inversion**: Configurazioni iniettabili

## Metriche di Qualità

### Indicatori Monitorati
- **Copertura test**: Target 90%+ per codice critico
- **Complessità ciclomatica**: Max 10 per metodo
- **Duplicazione codice**: Max 5% del codebase  
- **Debt tecnico**: Tracking tramite SonarQube
- **Performance**: Response time <200ms per endpoint

### Soglie di Qualità
```php
// phpstan.neon
parameters:
    level: 9
    checkMissingIterableValueType: true
    checkGenericClassInNonGenericObjectType: true
    reportUnmatchedIgnoredErrors: true
```

## Strumenti Aggiuntivi

### Analisi Statica
- **PHPStan**: Livello 9+ obbligatorio
- **Psalm**: Analisi tipi avanzata
- **PHP_CodeSniffer**: Standard PSR-12

### Formattazione Codice
- **Laravel Pint**: Formattazione automatica
- **PHP-CS-Fixer**: Regole personalizzate
- **EditorConfig**: Consistenza IDE

### Testing
- **Pest**: Framework di test principale
- **PHPUnit**: Test legacy e integrazione
- **Mockery**: Mocking avanzato

### Performance
- **Blackfire**: Profiling produzione
- **XDebug**: Debug e profiling sviluppo
- **Laravel Telescope**: Monitoring real-time

## Configurazione Avanzata

### File di Configurazione
```php
// config/quality.php
return [
    'checks' => [
        'form_schema' => [
            'enabled' => true,
            'base_class' => 'XotBaseResource',
            'required_methods' => ['getFormSchema'],
            'exclude_paths' => ['vendor/', 'storage/'],
        ],
        'phpstan' => [
            'level' => 9,
            'config' => 'phpstan.neon',
            'memory_limit' => '2G',
        ],
    ],
    'reports' => [
        'output_format' => 'json',
        'save_to_file' => true,
        'file_path' => 'storage/quality-reports/',
    ],
];
```

### Script Personalizzati
```bash
# bashscripts/custom-checks.sh
#!/bin/bash

# Check per convenzioni naming
check_naming_conventions() {
    echo "🏷️  Verificando convenzioni di naming..."
    # Implementazione custom
}

# Check per architettura moduli
check_module_structure() {
    echo "🏗️  Verificando struttura moduli..."  
    # Implementazione custom
}
```

## Troubleshooting

### Problemi Comuni

#### Script non trovato
```bash
# Verifica percorso
ls -la bashscripts/check_form_schema.php

# Verifica permessi
chmod +x bashscripts/*.sh
```

#### Memory limit PHPStan
```bash
# Aumenta memory limit
php -d memory_limit=2G vendor/bin/phpstan analyse
```

#### Conflitti Git nei report
```bash
# Pulisci file di report
rm -f storage/quality-reports/*.tmp
git checkout HEAD -- storage/quality-reports/
```

## Risorse e Link Utili

### Documentazione Ufficiale
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Laravel Pint](https://laravel.com/docs/pint)
- [Pest Testing Framework](https://pestphp.com/)
- [Filament Documentation](https://filamentphp.com/docs)

### Best Practices
- [PHP Standards (PSR)](https://www.php-fig.org/psr/)
- [Laravel Best Practices](https://github.com/alexeymezenin/laravel-best-practices)
- [Clean Code PHP](https://github.com/jupeter/clean-code-php)

### Tools e Integrations
- [GitHub Actions PHP](https://docs.github.com/en/actions/guides/building-and-testing-php)
- [SonarQube PHP](https://docs.sonarqube.org/latest/analysis/languages/php/)
- [Blackfire Profiler](https://blackfire.io/docs/introduction)

---

*Ultimo aggiornamento: Agosto 2025*  
*Versione: 2.1.0*
*Versione: 2.1.0*



