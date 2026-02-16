# Risoluzione Conflitto translation-file-syntax.md

## Problema Identificato

Il file `Modules/Lang/docs/translation-file-syntax.md` presenta un conflitto Git nella sezione finale:

**Linea 49**: Sezione "Novità 2025: Best practice obbligatorie" vs rimozione completa

## Analisi del Conflitto

### Conflitto (Linea 49) - Sezione Best Practice 2025
```markdown

## Novità 2025: Best practice obbligatorie

- Ogni file di traduzione deve avere la sezione `validation` con messaggi specifici per i campi principali.
- Ogni azione (`actions`) deve avere almeno `label`, `success`, `error`, `tooltip` dove serve.
- Tutti i campi in `fields` devono avere almeno `label`, `placeholder`, `help` o `tooltip`.
- Non rimuovere mai chiavi esistenti: solo aggiunte o miglioramenti.
- Uniformare la struttura tra i file (navigation, fields, actions, messages, validation, statuses, priorities, types, ecc.).

## Esempio aggiornato

```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'job_id' => [
            'label' => 'Job ID',
            'placeholder' => 'Enter job ID',
            'help' => 'Unique identifier for the job',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Import',
            'success' => 'Import completed successfully',
            'error' => 'Import failed',
            'tooltip' => 'Import jobs from file',
        ],
    ],
    'validation' => [
        'job_id_required' => 'Job ID is required.',
    ],
];
```

## ⚠️ Regola fondamentale: Non rimuovere mai chiavi dalle traduzioni

Quando si lavora sui file di traduzione, non è mai consentito rimuovere chiavi esistenti, ma solo aggiungere nuove chiavi o migliorare i valori e la struttura. Questa regola è prioritaria e va sempre rispettata in ogni intervento di refactoring o miglioramento delle traduzioni.

### Best Practice

- Non rimuovere mai chiavi esistenti: aggiungi solo nuove chiavi o migliora i valori.
```

**Problema**: Differenza tra mantenere le best practice 2025 vs rimuoverle completamente

## Soluzione Implementata

### Criteri di Risoluzione

1. **Valore della Documentazione**: Le best practice 2025 sono utili e aggiornate
2. **Completezza**: La sezione fornisce esempi pratici e regole chiare
3. **Manutenibilità**: Le regole sono importanti per la coerenza del progetto
4. **Struttura**: Mantiene la documentazione completa e aggiornata

### Risoluzione Applicata

#### Scelta: Versione HEAD (Mantenere Best Practice 2025)

**Motivazione**:
- Le best practice 2025 sono regole importanti per la coerenza del progetto
- L'esempio pratico è utile per gli sviluppatori
- La regola fondamentale sulla non rimozione delle chiavi è critica
- Mantiene la documentazione completa e aggiornata

#### Risoluzione Dettagliata

```markdown
// PRIMA (conflitto)

## Novità 2025: Best practice obbligatorie

- Ogni file di traduzione deve avere la sezione `validation` con messaggi specifici per i campi principali.
- Ogni azione (`actions`) deve avere almeno `label`, `success`, `error`, `tooltip` dove serve.
- Tutti i campi in `fields` devono avere almeno `label`, `placeholder`, `help` o `tooltip`.
- Non rimuovere mai chiavi esistenti: solo aggiunte o miglioramenti.
- Uniformare la struttura tra i file (navigation, fields, actions, messages, validation, statuses, priorities, types, ecc.).

## Esempio aggiornato

```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'job_id' => [
            'label' => 'Job ID',
            'placeholder' => 'Enter job ID',
            'help' => 'Unique identifier for the job',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Import',
            'success' => 'Import completed successfully',
            'error' => 'Import failed',
            'tooltip' => 'Import jobs from file',
        ],
    ],
    'validation' => [
        'job_id_required' => 'Job ID is required.',
    ],
];
```

## ⚠️ Regola fondamentale: Non rimuovere mai chiavi dalle traduzioni

Quando si lavora sui file di traduzione, non è mai consentito rimuovere chiavi esistenti, ma solo aggiungere nuove chiavi o migliorare i valori e la struttura. Questa regola è prioritaria e va sempre rispettata in ogni intervento di refactoring o miglioramento delle traduzioni.

### Best Practice

- Non rimuovere mai chiavi esistenti: aggiungi solo nuove chiavi o migliora i valori.

// DOPO (risolto)
## Novità 2025: Best practice obbligatorie

- Ogni file di traduzione deve avere la sezione `validation` con messaggi specifici per i campi principali.
- Ogni azione (`actions`) deve avere almeno `label`, `success`, `error`, `tooltip` dove serve.
- Tutti i campi in `fields` devono avere almeno `label`, `placeholder`, `help` o `tooltip`.
- Non rimuovere mai chiavi esistenti: solo aggiunte o miglioramenti.
- Uniformare la struttura tra i file (navigation, fields, actions, messages, validation, statuses, priorities, types, ecc.).

## Esempio aggiornato

```php
<?php

declare(strict_types=1);

return [
    'fields' => [
        'job_id' => [
            'label' => 'Job ID',
            'placeholder' => 'Enter job ID',
            'help' => 'Unique identifier for the job',
        ],
    ],
    'actions' => [
        'import' => [
            'label' => 'Import',
            'success' => 'Import completed successfully',
            'error' => 'Import failed',
            'tooltip' => 'Import jobs from file',
        ],
    ],
    'validation' => [
        'job_id_required' => 'Job ID is required.',
    ],
];
```

## ⚠️ Regola fondamentale: Non rimuovere mai chiavi dalle traduzioni

Quando si lavora sui file di traduzione, non è mai consentito rimuovere chiavi esistenti, ma solo aggiungere nuove chiavi o migliorare i valori e la struttura. Questa regola è prioritaria e va sempre rispettata in ogni intervento di refactoring o miglioramento delle traduzioni.

### Best Practice

- Non rimuovere mai chiavi esistenti: aggiungi solo nuove chiavi o migliora i valori.
```

## Giustificazione Tecnica

### Perché mantenere le best practice 2025?

1. **Completezza**: Forniscono regole chiare e aggiornate per il progetto
2. **Esempi Pratici**: L'esempio di codice è utile per gli sviluppatori
3. **Regole Critiche**: La regola sulla non rimozione delle chiavi è fondamentale
4. **Aggiornamento**: Mantiene la documentazione al passo con gli standard 2025

### Impatto

- ✅ Mantenimento delle best practice aggiornate
- ✅ Documentazione completa e utile
- ✅ Regole chiare per gli sviluppatori
- ✅ Esempi pratici per l'implementazione

## Collegamenti Correlati

- [Translation Standards](../translation-standards.md)
- [Translation File Management](../translation-file-management.md)
- [Best Practices](../translation-keys-best-practices.md)
- [PHP Array Configuration Best Practices](../../Xot/docs/php_array_configuration_best_practices.md)

## Note per Sviluppatori Futuri

1. **Best Practice**: Seguire sempre le regole 2025 per i file di traduzione
2. **Non Rimozione**: Mai rimuovere chiavi esistenti dalle traduzioni
3. **Struttura**: Uniformare sempre la struttura tra i file
4. **Validazione**: Includere sempre sezioni di validazione appropriate

## Data Risoluzione

- **Data**: Gennaio 2025
- **Modulo**: Lang
- **File**: `docs/translation-file-syntax.md`
- **Tipo Conflitto**: Documentazione best practice
