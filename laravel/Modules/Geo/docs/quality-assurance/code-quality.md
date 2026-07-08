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

# Regole per la Qualità del Codice

## Convenzioni di Nomenclatura File

### File di Documentazione
1. **README.md**
   - DEVE essere in maiuscolo
   - È il file principale di documentazione di ogni directory
   - Segue la convenzione storica Unix/GitHub
   - Esempio: `README.md`, `README.it.md`, `README.es.md`

2. **Altri File Markdown**
   - DEVONO essere in lowercase
   - DEVONO usare trattini per separare le parole
   - NON DEVONO contenere underscore
   - Esempio: `code-quality.md`, `git-scripts.md`, `best-practices.md`

3. **File di Testo**
   - DEVONO essere in lowercase
   - POSSONO usare trattini o underscore
   - Esempio: `tips.txt`, `git-reset.txt`

### Struttura Directory docs/
```
docs/
├── README.md              # File principale (MAIUSCOLO)
├── code-quality.md        # File markdown (lowercase con trattini)
├── best-practices.md      # File markdown (lowercase con trattini)
├── it/                    # Sottodirectory per lingue
│   └── README.md         # README localizzato (MAIUSCOLO)
└── roadmap/              # Sottodirectory per sezioni
    └── README.md         # README della sezione (MAIUSCOLO)
```

## PHPStan

Per mantenere alta la qualità del codice, utilizziamo PHPStan per l'analisi statica. 