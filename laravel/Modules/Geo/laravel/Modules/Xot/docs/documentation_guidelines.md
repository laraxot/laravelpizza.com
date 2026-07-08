
# Linee Guida per la Documentazione in Laraxot

Questo documento definisce le best practices per la creazione e la manutenzione della documentazione all'interno del framework Laraxot.

## Struttura della Documentazione

### 1. Organizzazione dei File

La documentazione dovrebbe essere organizzata in modo coerente in tutti i moduli:

```
Modules/NomeModulo/
├── docs/                  # Documentazione ufficiale in formato Markdown
│   ├── README.md          # Panoramica e punto d'ingresso
│   ├── module_nome.md     # Descrizione dettagliata del modulo
│   ├── BEST-PRACTICES.md  # Best practices specifiche del modulo
│   ├── MODELS.md          # Documentazione dei modelli
│   ├── ...                # Altri documenti specifici
│   └── assets/            # Immagini, diagrammi e altri assets
│
└── _docs/                 # Note, appunti e documenti in fase di sviluppo
    ├── topic1.txt         # Appunti su un argomento specifico
    ├── links.txt          # Collegamenti utili
    └── ...                # Altri appunti
```

### 2. Nomenclatura dei File

Per garantire coerenza e facilità di navigazione:

- File principali: utilizzare MAIUSCOLE con trattini (es. `BEST-PRACTICES.md`)
- File secondari: utilizzare lowercase con trattini (es. `getting-started.md`)
- File di appunti: utilizzare lowercase con underscore (es. `api_notes.txt`)
- File specifici del modulo: prefix `module_` seguito dal nome del modulo in minuscolo (es. `module_brain.md`)

## Formato dei Documenti

### 1. Frontmatter (opzionale)

Per i documenti che utilizzeranno un generatore di siti statici come Jigsaw, iniziare con un frontmatter YAML:

```markdown
---
title: Titolo del Documento
description: Breve descrizione del contenuto
category: Categoria (es. Modelli, API, Config)
position: 1
---
```

### 2. Intestazione e Introduzione

Ogni documento dovrebbe iniziare con:

```markdown
# Titolo Principale

Breve introduzione che spiega lo scopo del documento e il contesto.
```

### 3. Struttura delle Sezioni

Utilizzare una gerarchia chiara di intestazioni:

```markdown
## Sezione Principale

Descrizione della sezione principale.

### Sottosezione

Contenuto dettagliato della sottosezione.

#### Ulteriore dettaglio

Contenuto ancora più specifico.
```

### 4. Blocchi di Codice

Per gli esempi di codice, specificare sempre il linguaggio:

````markdown
```php
// Esempio di codice PHP
public function example(): string
{
    return 'Esempio';
}
```

```blade
{{-- Esempio di codice Blade --}}
<x-layout>
    <h1>{{ $title }}</h1>
</x-layout>
```
````

### 5. Note, Avvisi e Suggerimenti

Utilizzare un formato coerente per evidenziare informazioni importanti:

```markdown
> **Nota:** Informazioni aggiuntive che potrebbero essere utili.

> **Attenzione:** Avviso su potenziali problemi o considerazioni importanti.

> **Suggerimento:** Consigli per migliorare l'implementazione o l'utilizzo.
```

## Contenuti Specifici per Tipo di Documento

### 1. README.md

Il file README dovrebbe contenere:

- Descrizione del modulo e suo scopo
- Prerequisiti e dipendenze
- Istruzioni di installazione di base
- Esempi di utilizzo principali
- Collegamenti ad altra documentazione rilevante

### 2. MODELS.md

La documentazione dei modelli dovrebbe includere:

- Nome della classe del modello e namespace completo
- Tabella del database associata e chiave primaria
- Attributi principali con descrizioni
- Relazioni con altri modelli
- Scopes e metodi personalizzati
- Esempi di utilizzo comune

Esempio:
```markdown
## NomeModello

```php
Modules\ModuloNome\Models\NomeModello
```

**Tabella:** `nome_tabella`  
**Chiave primaria:** `id_nome`

**Attributi principali:**
- `attributo_1`: Descrizione
- `attributo_2`: Descrizione

**Relazioni:**
- `relazioneUno()`: Appartiene a un `AltroModello`
- `relazioneDue()`: Ha molti `AltroModello`

**Scopes:**
- `attivi()`: Filtra per elementi attivi

**Esempio di utilizzo:**
```php
$modelli = NomeModello::attivi()->get();
```
```

### 3. SERVICE-PROVIDER.md

La documentazione dei service provider dovrebbe includere:

- Scopo del provider
- Metodi principali e cosa registrano
- Configurazioni specifiche
- Hooks e eventi associati

### 4. TRANSLATIONS.md

La documentazione delle traduzioni dovrebbe includere:

- Struttura dei file di traduzione
- Convenzioni di naming
- Esempi di utilizzo nelle view/componenti
- Best practices per la traduzione

## Mantenimento della Documentazione

### 1. Sincronizzazione con il Codice

La documentazione dovrebbe essere aggiornata contemporaneamente alle modifiche del codice correlato. In particolare:

- Quando si crea o si modifica un modello, aggiornare `MODELS.md`
- Quando si aggiungono nuovi provider, aggiornare `SERVICE-PROVIDER.md`
- Quando si modificano le convenzioni, aggiornare `BEST-PRACTICES.md`

### 2. Generazione Automatica

Utilizzare strumenti di generazione automatica quando possibile:

```bash
# Esempio: Generare documentazione per lo schema del database
php artisan xot:generate-db-documentation /path/to/schema.json /path/to/output
```

### 3. Controlli di Qualità

Prima di committare la documentazione:

- Verificare che i link siano validi
- Controllare che gli esempi di codice siano funzionanti e aggiornati
- Assicurarsi che la formattazione Markdown sia corretta
- Verificare la coerenza terminologica

## Integrazione Cross-Module

### 1. Collegamenti tra Moduli

Quando si fa riferimento a concetti o classi in altri moduli, utilizzare collegamenti relativi:

```markdown
Per ulteriori informazioni, consultare la [documentazione del modulo UI](../UI/project_docs/README.md).
```

### 2. Documentazione Centralizzata

Alcuni argomenti comuni a più moduli dovrebbero essere documentati nel modulo Xot e poi referenziati dagli altri moduli:

```markdown
Per le best practices generali sul framework, consultare la [guida principale](../Xot/project_docs/best-practices.md).
```

## Esempi di Eccellenza

### Documentazione di Modelli

```markdown
# Modelli del Modulo Brain

Questo documento descrive i modelli disponibili nel modulo Brain, che rappresentano le entità del database braindb.

## Struttura dei Modelli

Tutti i modelli seguono la struttura namespace `Modules\Brain\Models` e sono progettati per interfacciarsi con il database braindb configurato come connessione `brain` in Laravel.

## Modelli Disponibili

### Socio

Rappresenta un socio dell'associazione.

```php
Modules\Brain\Models\Socio
```

**Tabella:** `socio`  
**Chiave primaria:** `id_socio`

**Relazioni:**
- `sezione()`: Appartiene a una `Sezione`
- `statoSocio()`: Appartiene a uno `StatoSocio`
- `convenzioni()`: Ha molti attraverso `SocioRichiestaConvenzione`

**Scope:**
- `attivi()`: Filtra per soci attivi

**Esempio di utilizzo:**
```php
$sociAttivi = Socio::attivi()->with('sezione')->get();
```
```

## Implementazione

Per implementare queste linee guida:

1. Creare questa guida nel modulo Xot come riferimento centrale
2. Aggiornare gradualmente la documentazione esistente per seguire queste convenzioni
3. Utilizzare questa struttura per tutta la nuova documentazione
4. Condividere queste linee guida con il team di sviluppo
5. Includere controlli della documentazione nel processo di code review

## Risorse Utili

- [Markdown Guide](https://www.markdownguide.org/)
- [Documentazione Laravel](https://laravel.com/docs)
- [Documentazione PHPDoc](https://docs.phpdoc.org/)
