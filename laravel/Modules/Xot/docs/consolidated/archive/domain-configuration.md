# Gestione Domini e Configurazioni

## Prerequisiti
- Laravel 12.x
- PHP 8.2+

## Struttura dei Domini

### Formato del Dominio
Il formato del dominio segue la struttura inversa del dominio web:
- Esempio: `http://example.local` diventa `local/example`
- Questo formato viene utilizzato per organizzare le configurazioni specifiche per dominio

### Percorsi di Configurazione
- Le configurazioni specifiche per dominio si trovano in: `laravel/config/<dominio_inverso>/`
- Esempio: `laravel/config/local/example/`

## Gestione delle Configurazioni

### File di Configurazione
- Ogni dominio può avere i propri file di configurazione
- I file di configurazione seguono la stessa struttura dei file standard di Laravel
- Le configurazioni specifiche per dominio sovrascrivono quelle globali

### Esempio di Configurazione
```php
// laravel/config/local/example/metatag.php
return [
    'logo_header' => 'patient::images/logo-horizontal.svg',    // Logo orizzontale per l'header
    'logo_square' => 'patient::images/logo-square.svg',        // Logo quadrato per icone
    'logo_header_dark' => 'patient::images/logo-horizontal-dark.svg', // Versione dark del logo orizzontale
];
```

## Gestione delle Risorse

### Percorsi delle Risorse
- Le risorse (immagini, CSS, JS) sono organizzate per modulo
- Il formato `module::path` si traduce in `laravel/Modules/Module/resources/path`
- Esempio: `patient::images/logo-horizontal.svg` → `laravel/Modules/Patient/resources/images/logo-horizontal.svg`

### Best Practices
1. **Organizzazione**:
   - Mantenere le configurazioni specifiche per dominio separate
   - Utilizzare il formato inverso del dominio per i percorsi
   - Organizzare le risorse per modulo

2. **Nomenclatura**:
   - Utilizzare nomi descrittivi per i file di configurazione
   - Seguire le convenzioni di Laravel per i nomi dei file
   - Mantenere coerenza nei percorsi delle risorse
   - Distinguere chiaramente tra logo orizzontale e quadrato nei nomi dei file

3. **Manutenzione**:
   - Documentare tutte le configurazioni specifiche per dominio
   - Mantenere aggiornati i percorsi delle risorse
   - Verificare la coerenza tra configurazioni globali e specifiche

## Struttura delle Configurazioni
```
laravel/config/
└── [dominio]/
    └── [sottodominio]/
        ├── metatag.php
        └── altri_file_config.php
```

### Interpretazione dei Percorsi
Il formato `module::path` viene interpretato come:
- `module`: Nome del modulo (es: 'patient')
- `path`: Percorso relativo all'interno del modulo

Esempio:
```
patient::images/logo-horizontal.svg -> /Modules/Patient/resources/images/logo-horizontal.svg
```

## Collegamenti
- [Configurazione Generale](CONFIGURATION.md)
- [Risoluzione dei Loghi](LOGO_RESOLUTION.md) - **IMPORTANTE**: Processo dettagliato di risoluzione dei loghi
- [Gestione Asset](assets.md)
- [Struttura Temi](themes.md)
- [Linee Guida per i Loghi](../../../project_docs/standards/logo_guidelines.md)
- [Documentazione Principale](../../../project_docs/README.md)
- [Standard di Progetto](../../../project_docs/standards/README.md)
- [Gestione Media](../../Media/project_docs/README.md)
- [Gestione UI](../../UI/project_docs/README.md)
- [Gestione Temi](../../Cms/project_docs/themes.md)

## Collegamenti Correlati
- [Configurazione Moduli](MODULE_CONFIGURATION.md)
- [Gestione Risorse](ASSETS.md)
- [Linee Guida Sviluppo](DEVELOPMENT_GUIDELINES.md)
- [Troubleshooting](TROUBLESHOOTING.md)

## Vedi Anche
- [Documentazione UI](../../UI/project_docs/configuration.md)
- [Documentazione Media](../../Media/project_docs/assets.md)
- [Documentazione Temi](../../Cms/project_docs/theming.md)
- [Standard Interfaccia](../../../project_docs/standards/interface_guidelines.md)
- [Best Practices](../../../project_docs/standards/best_practices.md)

# Configurazione Basata sul Dominio

## Introduzione
Il sistema utilizza un meccanismo intelligente per determinare le configurazioni specifiche per dominio, inclusi loghi e metatag.

## Meccanismo di Risoluzione del Dominio

### 1. Determinazione del Percorso di Configurazione
```php
// Da APP_URL (es: http://example.local)
$url = 'example.local';                    // Rimozione protocollo
$parts = explode('.', $url);                 // ['example', 'local']
$reversed = array_reverse($parts);           // ['local', 'example']
$configPath = implode('/', $reversed);       // 'local/example'
```

Il percorso risultante viene utilizzato per localizzare i file di configurazione specifici per dominio in `laravel/config/`.

### 2. Struttura delle Configurazioni
```
laravel/config/
└── local/
    └── example/
        ├── metatag.php
        └── altri_file_config.php
```

### 3. Risoluzione del Logo
Il logo viene determinato dal file `metatag.php`:

```php
return [
    'logo_header' => 'patient::images/logo-horizontal.svg',    // Logo orizzontale per l'header
    'logo_square' => 'patient::images/logo-square.svg',        // Logo quadrato per icone
    'logo_header_dark' => 'patient::images/logo-horizontal-dark.svg', // Versione dark del logo orizzontale
];
```

### 4. Interpretazione dei Percorsi
Il formato `module::path` viene interpretato come:
- `module`: Nome del modulo (es: 'patient')
- `path`: Percorso relativo all'interno del modulo

Esempio:
```
patient::images/logo-horizontal.svg -> /Modules/Patient/resources/images/logo-horizontal.svg
```

## Best Practices

1. **Organizzazione**
   - Mantenere una struttura gerarchica chiara per i domini
   - Utilizzare nomi descrittivi per i file di configurazione
   - Documentare ogni configurazione specifica
   - Distinguere chiaramente tra diverse versioni del logo

2. **Naming**
   - Usare nomi lowercase per i domini
   - Separare i livelli di dominio con punti
   - Utilizzare underscore per separare parole nei nomi dei file
   - Utilizzare suffissi chiari per distinguere le versioni dei loghi (-horizontal, -square, -dark)

3. **Manutenzione**
   - Aggiornare le configurazioni quando cambiano i domini
   - Mantenere backup delle configurazioni
   - Verificare regolarmente la validità dei percorsi
   - Assicurarsi che tutte le versioni necessarie del logo siano presenti

## Collegamenti
- [Configurazione Generale](CONFIGURATION.md)
- [Gestione Asset](assets.md)
- [Struttura Temi](themes.md) 