# Standard per Modal Heading e Description nelle Traduzioni <nome progetto>

## Regola: Stringhe Dirette per Modal Properties

### Principio Fondamentale
Le proprietà `modal_heading` e `modal_description` devono essere **stringhe dirette**, non array con chiave `label`.

### Motivazione
- **Coerenza con Filament**: Filament si aspetta stringhe dirette per queste proprietà
- **Semplicità**: Evita nesting inutile di array
- **Performance**: Accesso diretto senza lookup di chiavi
- **Leggibilità**: Codice più pulito e intuitivo

## Pattern di Implementazione

### ✅ CORRETTO - Stringhe Dirette
```php
'actions' => [
    'edit' => [
        'label' => 'Modifica',
        'modal_heading' => 'Modifica Profilo',
        'modal_description' => 'Aggiorna le informazioni del tuo profilo personale',
    ],
],
```

### ❌ ERRATO - Array con Label
```php
'actions' => [
    'edit' => [
        'label' => 'Modifica',
        'modal_heading' => [
            'label' => 'Modifica Profilo', // NON NECESSARIO
        ],
        'modal_description' => [
            'label' => 'Aggiorna le informazioni del tuo profilo personale', // NON NECESSARIO
        ],
    ],
],
```

## Utilizzo nel Codice

### Pattern Corretto nel Widget
```php
->modalHeading(static::trans('actions.edit.modal_heading'))
->modalDescription(static::trans('actions.edit.modal_description'))
```

### Pattern Corretto in Filament Actions
```php
Actions\EditAction::make()
    ->modalHeading(__('modulename::actions.edit.modal_heading'))
    ->modalDescription(__('modulename::actions.edit.modal_description'))
```

## Applicazione Globale

Questa regola si applica a:
- **Tutti i moduli**: `Modules/*/lang/*/`
- **Tutti i temi**: `Themes/*/lang/*/`
- **Tutte le azioni**: `actions.*.modal_heading`, `actions.*.modal_description`
- **Tutte le lingue**: it, en, de, etc.

## Eccezioni

- **Campi form**: Mantengono la struttura espansa con `label`, `placeholder`, `help`
- **Messaggi**: Possono mantenere struttura espansa se necessario
- **Altri elementi**: Seguono le regole specifiche per il loro tipo

## Checklist di Conformità

- [ ] `modal_heading` è stringa diretta
- [ ] `modal_description` è stringa diretta
- [ ] Non ci sono array inutili con chiave `label`
- [ ] Le traduzioni sono naturali e contestuali
- [ ] Coerenza tra tutte le lingue
- [ ] `declare(strict_types=1);` presente
- [ ] Sintassi breve degli array `[]`

## Esempi Completi

### Azione di Modifica
```php
'actions' => [
    'edit' => [
        'label' => 'Modifica',
        'modal_heading' => 'Modifica Elemento',
        'modal_description' => 'Aggiorna le informazioni di questo elemento',
        'success' => 'Elemento modificato con successo',
        'error' => 'Errore durante la modifica',
    ],
],
```

### Azione di Eliminazione
```php
'actions' => [
    'delete' => [
        'label' => 'Elimina',
        'modal_heading' => 'Conferma Eliminazione',
        'modal_description' => 'Sei sicuro di voler eliminare questo elemento? Questa azione è irreversibile.',
        'success' => 'Elemento eliminato con successo',
        'error' => 'Errore durante l\'eliminazione',
    ],
],
```

## Collegamenti

- [Regole Traduzioni <nome progetto>](translation-helper-text-standards.md)
- [Standard Helper Text](translation-helper-text-standards.md)
- [Convenzioni Filament](filament-best-practices.md)

*Ultimo aggiornamento: 2025-01-06* 