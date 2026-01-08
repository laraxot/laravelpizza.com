# Linee Guida per la Documentazione

## Principi Fondamentali

1. **Struttura Modulare**
   - Ogni modulo ha la sua documentazione in `/Modules/{ModuleName}/docs/`
   - Le regole generali sono in `/Modules/Xot/docs/`
   - La root `/docs` contiene solo indici e collegamenti

2. **Collegamenti Bidirezionali**
   - Ogni documento deve essere referenziato nell'indice appropriato
   - I collegamenti devono essere mantenuti aggiornati
   - Usare percorsi relativi alla root del progetto

3. **Organizzazione dei Contenuti**
   ```
   Modules/Xot/docs/
   ├── guidelines/           # Linee guida generali
   ├── conventions/          # Convenzioni di codice
   ├── architecture/         # Architettura del framework
   └── best-practices/       # Best practices generali
   ```

## Formato dei Documenti

### 1. Intestazione
```markdown

# Titolo del Documento

Breve descrizione dello scopo del documento (1-2 frasi).

## Indice dei Contenuti
- [Sezione 1](#sezione-1)
- [Sezione 2](#sezione-2)
```

### 2. Struttura delle Sezioni
```markdown

## Nome Sezione

### Sottosezione
Contenuto...

#### Dettagli
Contenuto dettagliato...
```

### 3. Esempi di Codice
```markdown
```php
// Esempio di codice PHP
public function example(): void
{
    // ...
}
```
```

## Regole di Scrittura

1. **Lingua**
   - Documentazione primaria in italiano
   - Commenti nel codice in inglese
   - Nomi delle variabili e funzioni in inglese

2. **Formattazione**
   - Usare Markdown per tutti i documenti
   - Mantenere una larghezza massima di 120 caratteri
   - Usare liste puntate per elenchi brevi
   - Usare liste numerate per procedure

3. **Collegamenti**
   - Usare percorsi relativi alla root
   - Verificare i collegamenti prima del commit
   - Mantenere una sezione "Vedi anche" alla fine

## Documentazione dei Moduli

### 1. Struttura Base
```
Modules/{ModuleName}/docs/
├── README.md              # Panoramica del modulo
├── installation.md        # Istruzioni di installazione
├── configuration.md       # Configurazione
├── usage/                 # Guide all'uso
├── api/                   # Documentazione API
└── examples/              # Esempi pratici
```

### 2. File README.md
```markdown

# Nome Modulo

Breve descrizione...

## Installazione
[Istruzioni di installazione](installation.md)

## Configurazione
[Configurazione](configuration.md)

## Utilizzo
[Guide all'uso](usage/README.md)
```

## Manutenzione

1. **Aggiornamenti**
   - Revisione periodica dei contenuti
   - Verifica dei collegamenti
   - Aggiornamento esempi di codice

2. **Versionamento**
   - Indicare la versione del framework
   - Segnalare breaking changes
   - Mantenere un changelog

3. **Review**
   - Review della documentazione nei PR
   - Verifica ortografica
   - Validazione dei collegamenti

## Testing della Documentazione

```bash

# Verifica collegamenti
markdown-link-check **/*.md

# Validazione markdown
markdownlint **/*.md

# Generazione documentazione API
php artisan api:generate
```

## Best Practices

1. **Contenuti**
   - Mantenere la documentazione concisa
   - Usare esempi pratici
   - Includere casi d'uso comuni
   - Documentare le eccezioni

2. **Struttura**
   - Un argomento per file
   - Massimo 3 livelli di heading
   - Usare template consistenti
   - Includere sezione troubleshooting

3. **Manutenibilità**
   - Evitare duplicazione
   - Usare riferimenti incrociati
   - Mantenere una struttura coerente
   - Documentare le assunzioni

## Collegamenti

- [Convenzioni di Codice](../conventions/README.md)
- [Architettura](../architecture/README.md)
- [Best Practices](../best-practices/README.md)
- [Markdown Guide](https://www.markdownguide.org) 

## Collegamenti tra versioni di documentation.md
* [documentation.md](docs/rules/documentation.md)
* [documentation.md](../../../Xot/docs/documentation.md)
* [documentation.md](../../../Xot/docs/guidelines/documentation.md)
* [documentation.md](../../../Cms/docs/roadmap/features/documentation.md)

