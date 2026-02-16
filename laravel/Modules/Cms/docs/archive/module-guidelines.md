# Linee Guida per la Documentazione dei Moduli

## Principi Fondamentali

### 1. Riutilizzabilità
- I moduli devono essere completamente riutilizzabili
- La documentazione NON DEVE contenere riferimenti specifici al progetto (es. "<nome progetto>")
- Utilizzare placeholder o variabili per riferimenti specifici al progetto
- Mantenere una documentazione generica e adattabile

### 2. Struttura della Documentazione
- Ogni modulo deve avere una cartella `docs/`
- I file di documentazione devono essere in formato Markdown
- Utilizzare nomi file descrittivi e in minuscolo
- Mantenere una struttura coerente tra i moduli

### 3. Riferimenti e Percorsi
- Usare percorsi relativi al modulo
- Evitare percorsi assoluti specifici del progetto
- Utilizzare la sintassi: `{project_root}/path/to/file`
- Per configurazioni specifiche del progetto, usare: `{config_path}/path/to/config`

### 4. Esempi di Codice
- Gli esempi devono essere generici
- Utilizzare nomi di variabili e classi descrittivi
- Evitare riferimenti a implementazioni specifiche
- Fornire esempi di personalizzazione

### 5. Configurazione
- Documentare le opzioni di configurazione in modo generico
- Utilizzare esempi di configurazione neutri
- Spiegare come personalizzare per progetti specifici
- Mantenere separata la documentazione specifica del progetto

## Esempi

### ❌ Non Corretto
```markdown
Il file di configurazione si trova in:
/laravel/config/<directory progetto>/database/content/pages/1.json
```

### ✅ Corretto
```markdown
Il file di configurazione si trova in:
{config_path}/database/content/pages/default.json
```

### ❌ Non Corretto
```php
$config = Config::get('<nome progetto>.homepage');
```

### ✅ Corretto
```php
$config = Config::get('{project_name}.homepage');
```

## Manutenzione

### Revisione della Documentazione
- Verificare regolarmente l'assenza di riferimenti specifici al progetto
- Aggiornare gli esempi per mantenerli generici
- Assicurarsi che la documentazione rimanga riutilizzabile
- Mantenere aggiornati i placeholder e le variabili

### Gestione dei Collegamenti
- Utilizzare collegamenti relativi
- Evitare URL hardcoded
- Mantenere una struttura di collegamenti coerente
- Documentare le dipendenze tra moduli in modo generico

## Override dei Template FrontOffice
I template del FrontOffice possono essere sovrascritti in un tema personalizzato utilizzando il percorso generico:
```
<laravel_base>/Themes/<ThemeName>/resources/views/components/sections/header.blade.php
```
I dati dell'header (titolo, link, logo, ecc.) sono recuperati da:
```
<laravel_base>/config/local/<project_key>/database/content/sections/1.json
```
**Nota**: la directory `database` deve essere tutto minuscolo.

Modifica il file `header.blade.php` in questa posizione per personalizzare l'header del FrontOffice.

## Collegamenti Bidirezionali
- [README](README.md) - Documentazione principale del modulo
- [Architettura](architecture.md) - Architettura del modulo
- [Struttura](structure.md) - Struttura del modulo
- [Namespace](namespace-moduli-laravel-<nome progetto>.md) - Convenzioni namespace
- [Case Sensitivity](case-sensitivity-percorsi-moduli.md) - Gestione case sensitivity
- [Frontoffice](frontoffice.md) - Documentazione frontend
- [Componenti](components.md) - Componenti disponibili

## Vedi Anche
- [Modulo Xot](../Xot/project_docs/README.md) - Linee guida generali
- [Modulo UI](../UI/project_docs/README.md) - Componenti di interfaccia
- [Modulo Theme](../Theme/project_docs/README.md) - Gestione temi
- [Convenzioni Naming](../../../project_docs/standards/file_naming_conventions.md) - Standard naming
- [Documentazione Laravel](https://laravel.com/docs) - Documentazione ufficiale
- [Best Practices](https://laravel.com/project_docs/11.x/best-practices) - Best practices Laravel
